<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 14/04/16
 * Time: 07:39
 */

namespace EasyFrame\Model;


use EasyFrame\Object;

abstract class AbstractObject
{
    /**
     * Create a new instance of this object
     * @param $params
     * @return static
     */
    public static function create(...$params)
    {
        //TODO setup a static config or something to allow easy testing override of this funciton
        return Object::create(static::class, $params);
    }
}