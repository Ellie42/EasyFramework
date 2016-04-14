<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:26
 */

namespace EasyFrame\View\Models;


use EasyFrame\Config\ViewConfig;

class HttpErrorViewModel extends AbstractViewModel
{
    public $code;

    public function __construct($code, ViewConfig $config = null)
    {
        parent::__construct($config);
        $this->code = $code;
    }

    public function getTemplatePath() : string
    {
        if ($this->templatePath === null) {
            return null;
        }

        return "$this->templatePath/$this->code.phtml";
    }
}