<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 11:34
 */

namespace EasyFrame\Helpers\Module;


use EasyFrame\Config;

class Module
{
    /**
     * @var string
     */
    public $name;
    public $dir;
    protected $moduleDir;

    public function load()
    {
        $this->moduleDir = Config::$moduleDir;
        $this->dir = "$this->moduleDir/$this->name";
    }

    /**
     * @return mixed
     */
    public function getDir() : string
    {
        return $this->dir ?? "";
    }
}