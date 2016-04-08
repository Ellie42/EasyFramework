<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 11:59
 */

namespace EasyFrame\Router;


class RouteModel
{
    public $route;
    public $controller;
    public $action;
    public $method;

    public function setData(array $data){
        foreach($data as $key => $value){
            $this->$key = strtolower($value);
        }
    }
}