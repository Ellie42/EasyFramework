<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 11:07
 */

namespace EasyFrame\Controller;


use EasyFrame\Exceptions\ControllerNotFoundException;
use EasyFrame\Object;
use EasyFrame\Router\RouteModel;

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

    public function run(RouteModel $routeModel)
    {
        $this->route = $routeModel;

        $this->controller = $this->getControllerInstance($routeModel->getController());
        $this->action = $routeModel->getAction();

        return $this->controller->$this->action();
    }

    protected function getControllerInstance($controllerName)
    {
        if (!class_exists($controllerName)) {
            throw new ControllerNotFoundException(
                "Controller $controllerName not found"
            );
        }

        return Object::create($controllerName);
    }
}