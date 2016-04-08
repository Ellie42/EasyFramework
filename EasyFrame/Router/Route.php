<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:20
 */

namespace EasyFrame\Router;

class Route
{
    /**
     * @var Router
     */
    protected static $router;

    /**
     * @return Router
     */
    public static function getRouter()
    {
        return self::$router;
    }

    /**
     * @param Router $router
     */
    public static function setRouter($router)
    {
        self::$router = $router;
    }

    public static function get($route, $controller, $action)
    {
        self::$router->AddRoute($route, $controller, $action,Router::HTTP_GET);
    }
}