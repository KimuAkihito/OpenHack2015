<?php

class Model_WishList extends \Model_Crud
{
    public static function find_all()
    {
        $query=DB::select()->from('wish_list')->execute();

        return $query->as_array();
    }
}