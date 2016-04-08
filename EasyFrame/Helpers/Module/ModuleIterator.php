<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 11:33
 */

namespace EasyFrame\Helpers\Module;


use EasyFrame\Helpers\Module\Module;
use EasyFrame\Object;

class ModuleIterator
{
    protected $moduleDir;

    public function iterateModules($callable)
    {
        $moduleDirs = array_slice(scandir($this->moduleDir), 2);
        foreach ($moduleDirs as $moduleName) {
            //Create module object and set the module name
            $module = Object::create(Module::class, function (&$module) use ($moduleName) {
                $module->name = $moduleName;
            });

            $module->load();

            $callable($module);
        }
    }

    public function requestModuleDir($moduleDir)
    {
        $this->moduleDir = $moduleDir;
    }
}