<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:21
 */

namespace EasyFrame;

use EasyFrame\Http\Request;
use EasyFrame\Router\Router;
use EasyFrame\Router\Route;

class EasyFrame
{
    /**
     * @var Router
     */
    public $router;
    public $env;

    public function __construct($rootDir)
    {
        Config::$rootDir = $rootDir;
        Config::$moduleDir = $rootDir . "/Modules/";
        $this->router = Object::create(Router::class);
    }

    public function run($env)
    {
        $this->env = $env;

        Route::setRouter($this->router);
        $this->router->loadRoutes();

        $this->router->route(new Request($_SERVER));
    }
}