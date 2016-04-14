<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 12:27
 */

namespace EasyFrame\Http;


use EasyFrame\Router\RouteModel;

class Request
{
    protected $uri;
    protected $method;
    protected $action = [];
    /**
     * @var RouteModel
     */
    protected $route;

    public function __construct($server)
    {
        $this->uri = $server["REQUEST_URI"];
        $this->method = $server["REQUEST_METHOD"];
    }

    /**
     * @param RouteModel $foundRoute
     */
    public function setRoute(RouteModel $foundRoute)
    {
        $this->route = $foundRoute;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return RouteModel
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @param string $controller
     * @param string $method
     */
    public function setAction(string $controller, string $method)
    {
        $this->action['controller'] = $controller;
        $this->action['method'] = $method;
    }

    /**
     * @param string $module
     */
    public function setModule(string $module)
    {
        $this->action['module'] = $module;
    }

    /**
     * @return mixed
     */
    public function getAction():array
    {
        return $this->action ?? [];
    }

    /**
     * @return mixed
     */
    public function getModule():string
    {
        return $this->action['module'] ?? "";
    }
}