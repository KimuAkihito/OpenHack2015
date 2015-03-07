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
            "gtvid" => "1SJP7FE41425722400"
        );

        /* $request = Request::forge($search_url, 'curl'); */
        /* $request->set_method('post'); */
        /* $request->set_params($data); */
        /* $request->execute(); */
        /* $response = $request->response(); */

        /* $resp_json = json_decode($response, true); */

        /* foreach($resp_json["program"] as $key => $value){ */
        /*     var_dump($value["caption"]); */
        /* } */

		return Response::forge(View::forge('home/index', $view_data));
	}

}