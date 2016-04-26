<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 26/04/16
 * Time: 10:13
 */

namespace EasyFrame\Helpers\Common;


trait ArrayHelper
{
    /**
     * Return the value at a specified index or null if not set
     * @param array $array
     * @param $index
     * @return null|mixed
     */
    protected function aVal(array $array,$index){
        return isset($array[$index])?$array[$index]:null;
    }
}