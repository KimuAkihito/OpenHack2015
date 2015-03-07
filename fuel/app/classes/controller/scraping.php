<?php

class Controller_Scraping extends Controller
{

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
        $search_url = "http://monjiro.net/";

        $data = array(
            'before' => 'こんにちは',
            'gn_id' => '2',
            'mode' => 'conv'
        );

        $request = Request::forge($search_url, 'curl');
        $request->set_method('post');
        $request->set_params($data);
        $request->execute();
        $response = $request->response();

        /* $resp_json = json_decode($response, true); */

        echo $response;

		/* return Response::forge(View::forge('login/index')); */
	}

}
