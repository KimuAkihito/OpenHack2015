<?php
namespace Model;
use \DB;
class WishList extends \Model  {
    public static function get_all()
    {
        $query = DB::query('SELECT * FROM wish_list');
        $results = $query->execute();
        return $results->as_array();
    }

    public static function get($id) {
      $query = DB::query('SELECT * FROM wish_list WHERE id = `$id`');
      $results = $query->execute();
      return $results->as_array();
    }

    public static function insert($id) {
      $query = DB::insert('wish_list');
      $query->set(array(
        "id" => $id,
        "flag" => false
      ));
      $query->execute();
    }

    public static function update($id) {
      $query = DB::update('wish_list');
      $query->where('id', '=', '$id');
      $query->value('flag', true);
    }
}
