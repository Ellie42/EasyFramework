<?php
use EasyFrame\Router\RouteModel;
use EasyFrame\Router\Router;

/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 09/04/16
 * Time: 17:06
 */
class RouterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Router
     */
    protected $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function createRoutes(array ...$args)
    {
        $routes = [];
        foreach ($args as $index => $params) {
            $defaultParams = [
                "/",
                "testController" . $index,
                "testAction" . $index,
                "GET"
            ];

            $params = array_merge($params, $defaultParams);

            $route = new RouteModel();
            $route->setData([
                "route" => $params[0],
                "controller" => $params[1],
                "action" => $params[2],
                "method" => $params[3]
            ]);
            $routes[] = $route;
        }

        return $routes;
    }

    public function test_findRoute()
    {
        $reflectedRouter = new ReflectionClass($this->router);
        $reflectedFindRoute = $reflectedRouter->getMethod("findRoute");
        $reflectedFindRoute->setAccessible(true);

        $routes = $this->createRoutes(
            ["/a"], ["/a/:b?"]
        );

        $foundRoute = $reflectedFindRoute->invokeArgs($this->router, ["/a/10", $routes]);

        $this->assertEquals("/a", $foundRoute->route);
    }
}



































