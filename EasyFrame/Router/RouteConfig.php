<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:51
 */

namespace EasyFrame\Router;

use EasyFrame\Cache\AbstractCacheable;
use EasyFrame\Config;

class RouteConfig extends AbstractCacheable
{
    public $routes;
    protected $moduleDir;

    public function __construct()
    {
        $this->moduleDir = Config::$moduleDir;
    }

    public function add(RouteModel $routeModel)
    {
        $this->routes[] = $routeModel;
    }
}