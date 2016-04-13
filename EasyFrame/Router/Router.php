<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:55
 */

namespace EasyFrame\Router;

use EasyFrame\Config;
use EasyFrame\Exceptions\HttpException;
use EasyFrame\Helpers\Module\ModuleIterator;
use EasyFrame\Http\Request;
use EasyFrame\Object;
use EasyFrame\View\AbstractViewModel;
use EasyFrame\View\ErrorViewModel;

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
     * @return AbstractViewModel
     * @throws HttpException
     */
    public function route(Request $request)
    {
        $foundRoute = $this->findRoute($request, $this->routeConfig->routes);
        if ($foundRoute === null) {
            throw new HttpException(404);
        }

        return $foundRoute;
    }

    /**
     * Find a matching route in the config
     * @param Request $request
     * @param RouteModel[] $routes
     * @return RouteModel
     */
    private function findRoute(Request $request, $routes)
    {
        $foundRoute = null;
        //Used to compare matches and see which is the most matchy...
        //Static routes will always override variable routes using this method
        // /a/b/c > /a/b/:c
        //And required variables will always override optional params
        // /a/b/:c > /a/b/c? > /a/b/:c?
        $foundRouteMatchScore = 0;

        $requestRoute = Object::create(RouteModel::class, [$request]);

        foreach ($routes as $route) {
            $curMatchScore = $route->getRouteMatchScore($requestRoute);

            //If score is false then the route is not a valid match
            if ($curMatchScore === false) {
                continue;
            }

            //Only set the found match if the score is greater than previous
            //the first match of the same score value will be used
            if ($curMatchScore > $foundRouteMatchScore) {
                $foundRoute = $route;
                $foundRouteMatchScore = $curMatchScore;
            }
        }

        return $foundRoute;
    }
}

























