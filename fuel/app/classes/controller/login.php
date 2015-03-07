<?php

class Controller_Login extends Controller
{

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		return Response::forge(View::forge('login/index'));
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_auth()
	{
        $username = $_POST["username"];
        $password = $_POST["password"];
        $md5password = md5($password);

        $url = "http://".GARAPON_GURL.":".GARAPON_HTTP_PORT."/gapi/v3/auth?dev_id=".DEV_ID;
        
        $data = array(
            "type" => "login",
            "loginid" => $username,
            "md5pswd" => $md5password
        );

        $request = Request::forge($url, 'curl');
        $request->set_method('post');
        $request->set_params($data);
        $request->execute();
        $response = $request->response();

        $resp_json = json_decode($response, true);
        
        Session::set("gtvsession", $resp_json["gtvsession"]);

        return Response::redirect('list/index');
	}
}
