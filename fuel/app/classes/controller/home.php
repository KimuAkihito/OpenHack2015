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
            $view_data["movie_url"] = $_POST['mvurl'];
            $view_data["thumbnail_url"] = $_POST['thumb'];

	    return Response::forge(View::forge('home/index', $view_data));
	}
}
