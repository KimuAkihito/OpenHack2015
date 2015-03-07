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

        $view_data = array();
        
        echo Session::get("gtvsession");

        $search_url = "http://".GARAPON_GURL.":".GARAPON_HTTP_PORT."/gapi/v3/search?gtvsession="
            .Session::get("gtvsession")."&dev_id=".DEV_ID;

        $data = array(
            "n" => "100",
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

        $gtvid = "";

        foreach($resp_json["program"] as $key => $value){

            $gtvid = $value["gtvid"];

            $view_data["title"] = $value["title"];

            $view_data["thumbnail_url"] = 'http://'.GARAPON_GURL.
                ':'.GARAPON_HTTP_PORT.'/thumbs/'.$value["gtvid"];

            $view_data["movie_url"] = 'http://'.GARAPON_GURL.
                ':'.GARAPON_HTTP_PORT.'/'.$value["gtvid"].
                '.m3u8?gtvsession='.Session::get("gtvsession").'&starttime=0&dev_id='.DEV_ID;
        }

        $search_url = "http://".GARAPON_GURL.":".GARAPON_HTTP_PORT."/gapi/v3/search?gtvsession="
            .Session::get("gtvsession")."&dev_id=".DEV_ID;

        $data = array(
            "gtvid" => $gtvid
        );

        $request = Request::forge($search_url, 'curl');
        $request->set_method('post');
        $request->set_params($data);
        $request->execute();
        $response = $request->response();

        $resp_json = json_decode($response, true);

        // セッション毎に翻訳ファイルを作成する
        $caption_file_path = "trans_".Session::get("gtvsession").".vtt";
        $caption_file = fopen(APPPATH."data/".$caption_file_path, "c");

        $captions = "WEBVTT\n\n";

        $caption_index = 0;

        foreach($resp_json["program"] as $key => $value){
            foreach($value["caption"] as $ckey => $cvalue) {
                $captions .= ++$caption_index . "\n";
                $captions .= $cvalue["caption_time"]. ".000 --> ". $cvalue["caption_time"]. ".999\n";
                $captions .= $cvalue["caption_text"]. "\n\n";
            }
        }

        fwrite($caption_file, $captions);
        fclose($caption_file);

        $view_data["caption_file_path"] = "./caption?file=".$caption_file_path;

		return Response::forge(View::forge('home/index', $view_data));
	}

    public function action_caption() {
        $caption_file_path = "trans_".Session::get("gtvsession").".vtt";

        echo file_get_contents(APPPATH."data/".$caption_file_path);
    }

}