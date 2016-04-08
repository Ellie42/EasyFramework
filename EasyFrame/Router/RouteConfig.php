<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:51
 */

namespace EasyFrame\Router;

use EasyFrame\Cache\AbstractCacheable;

class RouteConfig extends AbstractCacheable
{
    public $routes;
    protected $moduleDir;

    /**
     * @param mixed $moduleDir
     */
    public function requestModuleDir($moduleDir)
    {
        $this->moduleDir = $moduleDir;
    }

    public function add(RouteModel $routeModel)
    {
        $this->routes[] = $routeModel;
    }
}