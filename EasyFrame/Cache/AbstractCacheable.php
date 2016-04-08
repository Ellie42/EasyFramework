<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 10:14
 */

namespace EasyFrame\Cache;

abstract class AbstractCacheable implements Cacheable
{
    /**
     * Set the model data from array
     * @param array $data
     * @return mixed
     */
    public function setData(array $data){

    }

    /**
     * Return the model data as array
     * @return array
     */
    public function getData(){

    }
}