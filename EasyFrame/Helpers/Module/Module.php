<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 11:34
 */

namespace EasyFrame\Helpers\Module;


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
        $this->dir = "$this->moduleDir/$this->name";
    }

    public function requestModuleDir($dir)
    {
        $this->moduleDir = $dir;
    }
}