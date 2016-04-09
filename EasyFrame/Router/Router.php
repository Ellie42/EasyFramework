<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:55
 */

namespace EasyFrame\Router;

use EasyFrame\Helpers\Module\ModuleIterator;
use EasyFrame\Http\Request;
use EasyFrame\Object;

class Router
{
    const HTTP_GET = "GET";
    /**
     * @var RouteConfig
     */
    protected $routeConfig;
    protected $rootDir;

    /**
     * @param mixed $rootDir
     */
    public function requestRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * Add new route
     * @param $route
     * @param $controller
     * @param $action
     * @param string $method
     */
    public function addRoute($route, $controller, $action, $method = self::HTTP_GET)
    {
        $newRoute = Object::create(RouteModel::class);
        $newRoute->setData([
            "route" => $route,
            "controller" => $controller,
            "action" => $action,
            "method" => $method
        ]);
        $this->routeConfig->add($newRoute);
    }

    /**
     * Run each modules routes.php if it exists
     */
    public function loadRoutes()
    {
        $this->routeConfig = Object::create(RouteConfig::class);

        $moduleIterator = Object::create(ModuleIterator::class);
        $moduleIterator->iterateModules(function ($module) {
            if (file_exists("$module->dir/routes.php")) {
                include_once "$module->dir/routes.php";
            }
        });
    }

    /**
     * Determine the route to use and run it
     * @param Request $request
     */
    public function route(Request $request)
    {
        $foundRoute = $this->findRoute($request, $this->routeConfig->routes);
    }

    /**
     * @param Request $request
     * @param RouteModel[] $routes
     * @return RouteModel
     */
    private function findRoute(Request $request, $routes)
    {
        $foundRoute = null;
        $foundRouteMatchScore = 0;

        $requestRoute = Object::create(RouteModel::class);

        foreach ($routes as $route) {
            $curMatchScore = $route->getRouteMatchScore($requestRoute);
            if ($curMatchScore === false) {
                continue;
            }
            if ($curMatchScore > $foundRouteMatchScore){
                $foundRoute = $route;
            }
        }

        return $foundRoute;
    }
}

























