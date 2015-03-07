<?php
class Controller_Hook extends Controller
{

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
            if (isset($_POST["pull_request"])) {
                // unlock対象の動画を取得する
                $query = DB::select('id')->from('wish_list')->where('flag', false)->limit(1)->execute();
                $query_array = $query->as_array();

                $unlock_video_id = isset($query_array[0]) ? $query_array[0]["id"] : -1;

                echo $unlock_video_id;

                // unlockする動画がある場合は、unlockする
                if($unlock_video_id != -1) {
                    $result = DB::update('wish_list')->value("flag", true)->where('id', $unlock_video_id)->execute();
                }
            }
	}
}
