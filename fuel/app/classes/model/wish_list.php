<?php
namespace Model;
use \DB;

class WishList extends \Model  {
    public static function get_all()
    {
        $results = DB::query('SELECT * FROM wish_list')->execute();
        return $results->as_array();
    }

    public static function insert() {
      $query = DB::insert('wish_list');
      $query->set(array(
        "id" => "",
        "flag" => false
      ));
    }
}
