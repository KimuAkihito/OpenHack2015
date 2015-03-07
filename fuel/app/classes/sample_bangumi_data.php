<?php
define("DEV_ID", "4eacefa94a16d0e6f1a958ffe5850aa8"); //デベロッパーIDはAPI申請して発行されたものをお使いください

$gtvid = "";
if ( isset($_POST["gtvid"]) ) {
    $gtvid = $_POST["gtvid"];
}

$programdata = FALSE;
if ( $gtvid != "" && isset($_COOKIE["ipaddr"]) && isset($_COOKIE["apiver"]) && isset($_COOKIE["gtvsession"]) ) {
    $programdata = get_program_data($gtvid, $_COOKIE["ipaddr"], $_COOKIE["apiver"], $_COOKIE["gtvsession"]);
}

$thumbnail = "";
if ( isset($_COOKIE["cipaddr"]) && $gtvid ) {
    $thumbnail = "http://".$_COOKIE["cipaddr"]."/thumbs/".$gtvid;
}

/*
 * ガラポンTV端末のAPIをコールして指定した番組IDの番組情報を取得する関数
 */
function get_program_data ( $gtvid, $ipaddr, $apiver, $gtvsession ) {
    
    //番組検索APIのURL
    $url = "http://".$ipaddr."/gapi/".$apiver."/search?gtvsession=".$gtvsession."&dev_id=".DEV_ID;
    $post  = "gtvid=".$gtvid;
    
    $data = http_post_request($url, $post);
    
    if ( !$data ) {
        return FALSE;
    }
    
    $programdata = json_decode($data, TRUE);
    
    return $programdata;
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
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<h1>ガラポンTV　LAB</h1>
<p>これらの機能は全て<a href="http://garapon.tv/developer">ガラポンTV API</a>で実現しています。</p>

<?php if ( !$programdata ) {?>
<p>番組情報の取得に失敗しました。</p>
<a href="sample_index.html">戻る</a>
<?php }?>

<?php if ( $programdata["status"] == "1" ) {?>
<h4>
    <a href="http://site.garapon.tv/social_gtvid_view?gtvid=<?php echo $gtvid;?>">
        <?php echo $programdata["program"][0]["title"];?>
    </a>
</h4>
<?php if ( $thumbnail != "" ) {?>
<img src="<?php echo $thumbnail; ?>" />
<?php }?>
<table border="1">
    <tr><th width="100">放送日時</th><td><?php echo $programdata["program"][0]["startdate"];?></td>
    <tr><th>番組尺</th><td><?php echo $programdata["program"][0]["duration"];?></td>
    <tr><th>放送局</th><td><?php echo $programdata["program"][0]["bc"];?></td>
    <tr><th>番組説明</th><td><?php echo $programdata["program"][0]["description"];?></td>
</table>
<h4>番組字幕</h4>
<?php if ( $programdata["program"][0]["caption_hit"] > 0 ) { ?>
    <?php foreach  ( $programdata["program"][0]["caption"] as $caption ) {
        list($cap_h, $cap_m, $cap_s) = explode(":", $caption["caption_time"]);
        $caption_sec = $cap_h*60*60 + $cap_m*60 + $cap_s - 7; //7秒前から再生開始
    ?>
        <p>
            <a href="http://site.garapon.tv/g?g=<?php echo $gtvid;?>&t=<?php echo $caption_sec;?>">
            [<?php echo $caption["caption_time"];?>]</a>
            <?php echo $caption["caption_text"];?>
        </p>
    <?php }?>
<?php }?>

<?php }?>
</body>
</html>
