<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:26
 */

namespace EasyFrame\View;


use EasyFrame\Config\ViewConfig;

class ErrorViewModel extends AbstractViewModel
{
    public $code;

    public function __construct($code, ViewConfig $config)
    {
        parent::__construct($config);
        $this->code = $code;
    }
}