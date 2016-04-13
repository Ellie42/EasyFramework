<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:21
 */

namespace EasyFrame;

use EasyFrame\Controller\ControllerManager;
use EasyFrame\Exceptions\HttpException;
use EasyFrame\Http\Request;
use EasyFrame\Router\Router;
use EasyFrame\Router\Route;
use EasyFrame\View\Engines\EasyFrame\EasyFrameRenderEngine;
use EasyFrame\View\ErrorViewModel;
use EasyFrame\View\ViewRenderer;

class EasyFrame
{
    /**
     * @var Router
     */
    public $router;
    public $viewRenderer;
    public $controllerManager;
    public $env;

    public function __construct($rootDir)
    {
        Config::$rootDir = $rootDir;
        Config::$moduleDir = $rootDir . "/Modules/";
        $this->router = Object::create(Router::class);
        $this->controllerManager = Object::create(ControllerManager::class);
        $this->viewRenderer = Object::create(ViewRenderer::class, [
            Object::create(EasyFrameRenderEngine::class)
        ]);
    }

    public function run($env)
    {
        $this->env = $env;

        Config::load();

        Route::setRouter($this->router);
        $this->router->loadRoutes();

        $this->runApp();
    }

    private function runApp()
    {
        $route = null;
        
        try {
            $route = $this->router->route(new Request($_SERVER));
        } catch (HttpException $e) {
            $this->viewRenderer->render(
                Object::create(ErrorViewModel::class, [$e->getCode()])
            );
        }

        $view = $this->controllerManager->run($route);
    }
}