<?php
use EasyFrame\Object;
use EasyFrame\Router\RouteModel;

/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 09/04/16
 * Time: 18:26
 */
class RouteModelTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var RouteModel
     */
    protected $routeModel;

    public function setUp()
    {
        $this->routeModel = Object::create(RouteModel::class);
    }

    public function test_getRouteMatchScore()
    {
        //Test Request Route
        $route = Object::create(RouteModel::class);
        $route->setRoute("/a/b/c");
        $route->setMethod("GET");

        //3 static
        $this->routeModel->setRoute("/a/b/c");
        $this->routeModel->setMethod("GET");
        $score = $this->routeModel->getRouteMatchScore($route);
        $this->assertEquals(6, $score);

        //1 optional 2 static
        $this->routeModel->setRoute("/a/b?/c");
        $this->routeModel->setMethod("GET");
        $score = $this->routeModel->getRouteMatchScore($route);
        $this->assertEquals(3, $score);

        //2 optional 1 static
        $this->routeModel->setRoute("/a/b?/c?");
        $this->routeModel->setMethod("GET");
        $score = $this->routeModel->getRouteMatchScore($route);
        $this->assertEquals(0, $score);

        //1 static 2 variable
        $this->routeModel->setRoute("/a/:b/:c");
        $this->routeModel->setMethod("GET");
        $score = $this->routeModel->getRouteMatchScore($route);
        $this->assertEquals(4, $score);

        //1 static 1 variable 1 optional variable
        $this->routeModel->setRoute("/a/:b/:c?");
        $this->routeModel->setMethod("GET");
        $score = $this->routeModel->getRouteMatchScore($route);
        $this->assertEquals(3, $score);

        $this->routeModel->setRoute("/a/b?");
        $this->routeModel->setMethod("GET");
        $score = $this->routeModel->getRouteMatchScore($route);
        $this->assertEquals(false, $score);

        $this->routeModel->setRoute("/a/b?");
        $this->routeModel->setMethod("GET");
        $score = $this->routeModel->getRouteMatchScore($route);
        $this->assertEquals(false, $score);
    }

    public function test_getRouteMatchScore_moreConfigParamsThanRequested()
    {
        //Test Request Route
        $route = Object::create(RouteModel::class);
        $route->setRoute("/a/b/c");
        $route->setMethod("GET");

        $this->routeModel->setRoute("/a/b/c/d");
        $this->routeModel->setMethod("GET");
        $score = $this->routeModel->getRouteMatchScore($route);
        $this->assertEquals(false, $score);

        $this->routeModel->setRoute("/a/b/c/d?");
        $this->routeModel->setMethod("GET");
        $score = $this->routeModel->getRouteMatchScore($route);
        $this->assertEquals(6, $score);
    }
}