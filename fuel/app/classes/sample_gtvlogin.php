<?php
define("DEV_ID", "4eacefa94a16d0e6f1a958ffe5850aa8"); //デベロッパーIDはAPI申請して発行されたものをお使いください
define("COOKIE_EXPIRE", time() + 60 * 60 * 24 * 7); //クッキーの有効期限（１週間）

$user_id = $_POST["user"];
$raw_password = $_POST["raw_password"];
$md5_password = md5($raw_password);

//ガラポンWEBの認証APIに接続してガラポンTV端末にアクセスするための必要な情報を取得する
$gtvinfo = get_gtvinfo($user_id, $md5_password);

$logininfo = array();
if ( $gtvinfo["result"] ) { //ガラポンWEBとの認証に成功したら
    if ( isset($gtvinfo["ipaddr"]) && isset($gtvinfo["apiver"]) ) {
        $logininfo = login_to_gtv($gtvinfo["ipaddr"], $gtvinfo["apiver"], $user_id, $md5_password); //ガラポンTV端末のAPIでログイン
    }
}
$login_message = "";
if ( $gtvinfo["result"] ) {
    if( isset($logininfo["gtvsession"]) && $logininfo["gtvsession"] != "" ) {
        $login_message = "ガラポンTVに接続しました。";
    } else {
        $login_message = "ガラポンTV端末へのログインに失敗しました。";
    }
} else {
    $login_message = "ガラポンWEBへのログインに失敗しました。";
}


/*
 * HTTPでPOSTデータを送信する関数
 */
function http_post_request($url, $post, $con_timeout=10, $action_timeout=120) {
    
    $curl_handle = curl_init($url);
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $con_timeout);
    curl_setopt($curl_handle, CURLOPT_TIMEOUT, $action_timeout);
    $result = curl_exec($curl_handle);
    curl_close($curl_handle);
    
    return $result;
}

/*
 * ガラポンWEBの認証APIに接続してガラポンTV端末にアクセスするための必要な情報を取得する関数 
 */
function get_gtvinfo ($userid, $md5passwd) {

    $gtvinfo = array();
    $gtvinfo["result"] = FALSE; //ガラポンWEB認証の成否

    $url = "http://garagw.garapon.info/getgtvaddress"; //URLはAPI仕様書記載のURLに修正してください
    $post  = "user=".$userid;
    $post .= "&md5passwd=".$md5passwd;
    $post .= "&dev_id=".DEV_ID;
    
    $result = http_post_request($url, $post); //ガラポンWEB認証のAPIをコール
    
    if ( !$result ) {
        return $gtvinfo;
    }
    
    $list = preg_split("/\n/", $result); //ガラポンWEB認証の結果は改行区切り
    
    if ( isset($list[0]) && preg_match("/0;success/", $list[0]) ) {
        //ガラポン認証サーバ（ガラポンWEB）へのログイン成功の場合
        
        //サーバから見たガラポンTVのIPアドレス
        if ( isset($list[1]) ) {
            list($null, $gtvinfo["ipaddr"]) = explode(";", $list[1]);
        }
    
        //ガラポンTVのプライベートIPアドレス
        if ( isset($list[2]) ) {
            list($null, $gtvinfo["pipaddr"]) = explode(";", $list[2]);
        }
    
        //ガラポンTVのグローバルIPアドレス
        if ( isset($list[3]) ) {
            list($null, $gtvinfo["gipaddr"]) = explode(";", $list[3]);
        }
    
        //ガラポンTVのアクセスポート
        if ( isset($list[4]) ) {
            list($null, $gtvinfo["port"]) = explode(";", $list[4]);
        }
        
        //TSデータ再生ポート
        if ( isset($list[5]) ) {
            list($null, $gtvinfo["tsport"]) = explode(";", $list[5]);
        }
    
        //端末のバージョン（弐号機か四・参号機かの判定）
        $gtvver = "";
        if ( isset($list[6]) ) {
            list($null, $gtvver_str) = explode(";", $list[6]);
            if ( preg_match("/^GTV2/", $gtvver_str) > 0 ) {
                $gtvinfo["gtvver"] = 2;
            } else if ( preg_match("/^GTV3/", $gtvver_str) > 0 ) {
                $gtvinfo["gtvver"] = 3;
            } else if ( preg_match("/^GTV4/", $gtvver_str) > 0 ) {
                $gtvinfo["gtvver"] = 4;
            }
        }
        
        //APIバージョンの判定
        if ( $gtvinfo["gtvver"] == 2 ) {
            $gtvinfo["apiver"] = "v2"; //弐号機のAPIバージョン
        } else if ( $gtvinfo["gtvver"] == 3 || $gtvinfo["gtvver"] == 4 ) {
            $gtvinfo["apiver"] = "v3"; //四・参号機用のAPIバージョン
        }

        //サーバから見たガラポンTVのIPアドレスは必ずグローバルなのでポート番号をつける
        if ( isset($gtvinfo["ipaddr"]) && isset($gtvinfo["port"]) ) {
            $gtvinfo["ipaddr"] .= ":".$gtvinfo["port"];
        }
        
        //利用者から見たガラポンTVのIPアドレス
        //リモートアドレスとグローバルIPアドレスが一緒であれば宅内利用
        if ( isset($gtvinfo["gipaddr"]) && $gtvinfo["gipaddr"] == $_SERVER["REMOTE_ADDR"] && isset($gtvinfo["pipaddr"]) ) {
            $gtvinfo["cipaddr"] .= $gtvinfo["pipaddr"];
        } else if ( isset($gtvinfo["gipaddr"]) && $gtvinfo["gipaddr"] != $_SERVER["REMOTE_ADDR"] && isset($gtvinfo["port"]) ) { //宅外からの利用
            $gtvinfo["cipaddr"] .= $gtvinfo["gipaddr"].":".$gtvinfo["port"];
        }

        //各値をクッキーにセットしておく（次のAPIコールの時に利用）
        foreach ( $gtvinfo as $key => $val ) {
            setcookie($key, $val,  COOKIE_EXPIRE, "/");
        }
        
        $gtvinfo["result"] = TRUE;
    }
    
    return $gtvinfo;
}

/*
 * ガラポンTV端末のAPIを使ってログインする関数
 */
function login_to_gtv($ipaddr, $apiver, $userid, $md5passwd ) {
    
    $url = "http://".$ipaddr."/gapi/".$apiver."/auth?dev_id=".DEV_ID;
    $post  = "type=login";
    $post .= "&loginid=".$userid;
    $post .= "&md5pswd=".$md5passwd;
    
    $login_result = http_post_request($url, $post);
    $logininfo   = json_decode($login_result, TRUE);
    
    //クッキーにガラポンTVのAPIを次にコールするときに必要な情報をセットしておく
    if( isset($logininfo["gtvsession"]) ) {
        setcookie('gtvsession', $logininfo['gtvsession'], COOKIE_EXPIRE, "/");
    }
    
    return $logininfo;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php var_dump($logininfo['gtvsession']); ?>
<h1>ガラポンTV　LAB</h1>
<p>これらの機能は全て<a href="http://garapon.tv/developer">ガラポンTV API</a>で実現しています。</p>

<p><?php echo $login_message; ?></p>

<?php if ( $logininfo["status"] == "1" ) {?>
<h3>GTVID（番組ID）を入力すると当該番組の字幕を全出力</h3>
<form action="sample_bangumi_data.php" method="post">
番組ID：<input type="textbox" name="gtvid" /><br>
<input type="submit" value="送信" />
</form>
<?php } else { ?>
<a href="sample_index.html">戻る</a>
<?php }?>
</body>
</html>
