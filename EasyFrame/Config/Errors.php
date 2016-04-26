<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:06
 */

namespace EasyFrame\Config;


use EasyFrame\Object;

class Errors
{
    public $templateDir;

    public function getViewConfig($code)
    {
        return Object::create(ViewConfig::class, [
            "$this->templateDir/$code.php"
        ]);
    }

    /**
     * @return mixed
     */
    public function getTemplateDir()
    {
        return $this->templateDir;
    }

    /**
     * @param mixed $templateDir
     */
    public function setHttpTemplateDir($templateDir)
    {
        if ($templateDir[strlen($templateDir) - 1] === "/") {
            $templateDir = substr($templateDir, 0, -1);
        }
        $this->templateDir = $templateDir;
    }
}