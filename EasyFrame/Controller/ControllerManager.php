<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 11:07
 */

namespace EasyFrame\Controller;


use EasyFrame\Exceptions\ControllerNotFoundException;
use EasyFrame\Http\Request;
use EasyFrame\Object;
use EasyFrame\Router\RouteModel;
use EasyFrame\View\Models\AbstractViewModel;

class ControllerManager
{
    /**
     * @var RouteModel
     */
    protected $route;
    /**
     * @var EasyFrameController
     */
    protected $controller;
    /**
     * @var string
     */
    protected $action;

    /**
     * @param RouteModel $routeModel
     * @param Request $request
     * @return AbstractViewModel
     * @throws ControllerNotFoundException
     */
    public function run(RouteModel $routeModel, Request &$request) : AbstractViewModel
    {
        $this->route = $routeModel;

        $this->controller = $this->getControllerInstance($routeModel->getController());
        $this->action = $routeModel->getAction();

        $action = $this->action;

        $request->setAction($routeModel->getController(), $this->action);
        $request->setModule(explode("\\", $routeModel->getController())[0]);

        return $this->controller->$action();
    }

    /**
     * @param $controllerName
     * @return EasyFrameController
     * @throws ControllerNotFoundException
     */
    protected function getControllerInstance(string $controllerName) : EasyFrameController
    {
        if (!class_exists($controllerName)) {
            throw new ControllerNotFoundException(
                "Controller $controllerName not found"
            );
        }

        return Object::create($controllerName);
    }
}