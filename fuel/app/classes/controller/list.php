<?php

class Controller_List extends Controller
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
        
        $search_url = "http://".GARAPON_GURL.":".GARAPON_HTTP_PORT."/gapi/v3/search?gtvsession="
            .Session::get("gtvsession")."&dev_id=".DEV_ID;

        $data = array(
            "n" => "10",
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

        $gtvid = array();

        foreach($resp_json["program"] as $key => $value){

            $view_data['response'][$key]["gtvid"] = $value["gtvid"];

            $view_data["response"][$key]["title"] = $value["title"];

            $view_data["response"][$key]["thumbnail_url"] = 'http://'.GARAPON_GURL.
                ':'.GARAPON_HTTP_PORT.'/thumbs/'.$value["gtvid"];

            $view_data["response"][$key]["movie_url"] = 'http://'.GARAPON_GURL.
                ':'.GARAPON_HTTP_PORT.'/'.$value["gtvid"].
                '.m3u8?gtvsession='.Session::get("gtvsession").'&starttime=0&dev_id='.DEV_ID;
        }
	return Response::forge(View::forge('list/index', $view_data));
	}


}
