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
        echo Session::get("gtvsession");

        $search_url = "http://126.94.120.187:60405/gapi/v3/search?gtvsession="
            .Session::get("gtvsession")."&dev_id=4eacefa94a16d0e6f1a958ffe5850aa8";

        $data = array(
            "n" => "100",
            "p" => "1",
            "s" => "e",
			"video" => "all",
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
            var_dump( $value["gtvid"] );
        }

		return Response::forge(View::forge('home/index'));
	}

}
