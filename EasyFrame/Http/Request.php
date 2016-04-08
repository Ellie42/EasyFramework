<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 12:27
 */

namespace EasyFrame\Http;


class Request
{
    public $uri;
    public $method;

    public function __construct($server)
    {
        $this->uri = $server["REQUEST_URI"];
        $this->method = $server["REQUEST_METHOD"];
    }
}