<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:21
 */

namespace EasyFrame;

use EasyFrame\Config\ViewConfig;
use EasyFrame\Controller\ControllerManager;
use EasyFrame\Exceptions\HttpException;
use EasyFrame\Http\Request;
use EasyFrame\Router\Router;
use EasyFrame\Router\Route;
use EasyFrame\View\Engines\EasyFrame\EasyFrameRenderEngine;
use EasyFrame\View\Helpers\ExceptionHelper;
use EasyFrame\View\Models\HttpErrorViewModel;
use EasyFrame\View\Models\ViewModel;
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
    public $request;

    public function __construct($rootDir)
    {
        $this->request = Object::singleton(Request::class, [$_SERVER]);
        Config::$rootDir = $rootDir;
        Config::$moduleDir = $rootDir . "Modules";
        $this->router = Object::create(Router::class);
        $this->controllerManager = Object::create(ControllerManager::class);
        $this->viewRenderer = Object::create(ViewRenderer::class, [
            Object::create(EasyFrameRenderEngine::class)
        ]);
    }

    /**
     * @param string $env App environment 'development' or 'release'
     */
    public function run(string $env = 'release')
    {
        $this->env = $env;
        Config::load();
        Route::setRouter($this->router);
        $this->router->loadRoutes();

        include_once 'autoload.php';

        try {
            $this->runApp();
        } catch (HttpException $e) {
            $this->viewRenderer->render(
                Object::create(HttpErrorViewModel::class, [$e->getCode(),
                    ViewConfig::create(Config::Errors()->getTemplateDir())])
            );
        } catch (\Throwable $e) {
            $this->renderError($env, $e);
        }
    }

    /**
     * Depending on the app environment render errors in different manners
     * @param string $env
     * @param $e
     * @throws \Exception
     */
    protected function renderError(string $env, $e)
    {
        if ($env === "development") {
            $vm = ViewModel::create();
            $vm->useHelper(ExceptionHelper::class, "exHelper");
            $vm->setVariable("e", $e);
            $vm->setTemplatePath(Config::Errors()->getTemplateDir() . "/exception.phtml");
            $this->viewRenderer->render($vm);
        }
    }

    /**
     * Route -> Run -> Render
     * @throws HttpException
     */
    private function runApp()
    {
        $route = $this->router->route($this->request);

        $view = $this->controllerManager->run($route, $this->request);

        $this->viewRenderer->render($view);
    }
}