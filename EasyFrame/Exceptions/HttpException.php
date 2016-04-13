<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 11:01
 */

namespace EasyFrame\Exceptions;


class HttpException extends \Exception
{
    public function __construct($code){
        parent::__construct("Http Error Code $code", $code);
    }
}