<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 11:33
 */

namespace EasyFrame\Helpers\Module;


use EasyFrame\Config;
use EasyFrame\Helpers\Module\Module;
use EasyFrame\Object;

class ModuleIterator
{
    protected $moduleDir;

    public function __construct(){
        $this->moduleDir = Config::$moduleDir;
    }

    public function iterateModules($callable)
    {
        $moduleDirs = array_slice(scandir($this->moduleDir), 2);
        foreach ($moduleDirs as $moduleName) {
            //Create module object and set the module name
            $module = Object::create(Module::class);
            $module->name = $moduleName;

            $module->load();

            $callable($module);
        }
    }

}