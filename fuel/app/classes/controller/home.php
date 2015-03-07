<?php

class Controller_Home extends Controller
{

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
        set_time_limit(10000);
        
        echo Session::get("gtvsession");

        $search_url = "http://".GARAPON_GURL.":".GARAPON_HTTP_PORT."/gapi/v3/search?gtvsession="
            .Session::get("gtvsession")."&dev_id=".DEV_ID;

        $data = array(
            "n" => "1",
            "p" => "1",
            "s" => "e",
			"dt" => "s",
			"sort" => "std",
			"ch" => "32740"
        );

        $request = Request::forge($search_url, 'curl');
        $request->set_method('post');
        $request->set_params($data);
        $request->execute();
        $response = $request->response();

        $resp_json = json_decode($response, true);

        foreach($resp_json["program"] as $key => $value){

            echo $value["title"];
            /* echo "<video src='http://".GARAPON_GURL.":".GARAPON_HTTP_PORT."/".$value["gtvid"].".m3u8?gtvsession=".Session::get("gtvsession")."&starttime=10&dev_id=".DEV_ID."'></video>"; */

            echo '<video id="hls_player" poster="http://'.GARAPON_GURL.':'.GARAPON_HTTP_PORT.'/thumbs/'.$value["gtvid"].'" controls="controls" preload="preload" autoplay="autoplay" width="765" height="510" style="width: 765px; height: 510px;">';
            echo '<source src="http://'.GARAPON_GURL.':'.GARAPON_HTTP_PORT.'/'.$value["gtvid"].'.m3u8?gtvsession='.Session::get("gtvsession").'&starttime=0&dev_id='.DEV_ID.'" type="video/quicktime">';
            echo '</video>';

            /* echo '<video id="player_rtmp" class="flowplayer" controls width="624" height="260" preload="metadata">'; */
            /* echo '<source type="application/x-mpegURL" src="http://126.94.120.187:60406/'.$value["gtvid"].'.m3u8?gtvsession='.Session::get("gtvsession").'&starttime=10&dev_id=4eacefa94a16d0e6f1a958ffe5850aa8"/>'; */
            /* echo '<source type="video/x-flv" src="mp4:stsp"/>'; */
            /* echo '</video>'; */

            /* echo "<a href='http://garapon.info/play/".$value["gtvid"]."' />".$value["gtvid"]."</a>"; */
            
            /* echo "<img src=http://".GARAPON_GURL.":".GARAPON_HTTP_PORT."/thumbs/".$value["gtvid"]." />"; */
        }

        $search_url = "http://".GARAPON_GURL.":".GARAPON_HTTP_PORT."/gapi/v3/search?gtvsession="
            .Session::get("gtvsession")."&dev_id=".DEV_ID;

        $data = array(
            "n" => "1",
            "p" => "1",
            "s" => "c",
            "gtvid" => "1SJP7FE41425722400"
        );

        $request = Request::forge($search_url, 'curl');
        $request->set_method('post');
        $request->set_params($data);
        $request->execute();
        $response = $request->response();

        $resp_json = json_decode($response, true);

        foreach($resp_json["program"] as $key => $value){
            var_dump($value["caption"]);
        }

		return Response::forge(View::forge('home/index'));
	}

}