<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:21
 */

namespace EasyFrame;

include __DIR__ . "/../bootstrap.php";

use EasyFrame\Config\ViewConfig;
use EasyFrame\Controller\ControllerManager;
use EasyFrame\Exceptions\HttpException;
use EasyFrame\Http\Request;
use EasyFrame\Router\Router;
use EasyFrame\Router\Route;
use EasyFrame\View\Engines\EasyFrameRenderEngine;
use EasyFrame\View\Engines\TwigRenderEngine;
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
        $this->loadConfig($rootDir);
        include_once 'autoload.php';

        $this->request = Object::singleton(Request::class, [$_SERVER]);
        $this->router = Object::create(Router::class);
        Route::setRouter($this->router);
        $this->router->loadRoutes();
        $this->controllerManager = Object::create(ControllerManager::class);

        $this->viewRenderer = Object::create(ViewRenderer::class, [
            Object::create(Config::App()->getDefaultRenderEngine())
        ]);
    }

    /**
     * @param string $env App environment 'development' or 'release'
     */
    public function run(string $env = 'release')
    {
        $this->env = $env;

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
        $vr = ViewRenderer::create(EasyFrameRenderEngine::create());
        if ($env === "development") {
            $vm = ViewModel::create();
            $vm->useHelper(ExceptionHelper::class, "exHelper");
            $vm->setVariable("e", $e);
            $vm->setTemplatePath(Config::Errors()->getTemplateDir() . "/exception.phtml");
            $vr->render($vm);
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

    private function loadConfig($rootDir)
    {
        Config::$rootDir = $rootDir;
        Config::$testDir = $rootDir . "Tests";
        Config::$moduleDir = $rootDir . "Modules";
        Config::load();
    }
}