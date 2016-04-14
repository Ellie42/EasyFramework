<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:49
 */

namespace EasyFrame\Config;


use EasyFrame\Model\AbstractObject;

class ViewConfig extends AbstractObject
{
    /**
     * @var string
     */
    public $templatePath;

    public function __construct($templatePath){
        $this->templatePath = $templatePath;
    }
}