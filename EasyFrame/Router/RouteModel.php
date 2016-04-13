<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 11:59
 */

namespace EasyFrame\Router;


use EasyFrame\Http\Request;

class RouteModel
{
    protected $route;
    protected $controller;
    protected $action;
    protected $method;

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * RouteModel constructor.
     * @param Request $request
     */
    public function __construct(Request $request = null)
    {
        if ($request === null) {
            return;
        }
        $this->fromRequest($request);
    }

    public function fromRequest(Request $request)
    {
        $this->route = $request->uri;
        $this->method = $request->method;
    }


    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Check to see if a route matches another route and return a score to show how
     * specific the match is. This allows static routes to override variable routes
     * @param RouteModel $routeModel
     * @return bool
     */
    public function getRouteMatchScore(RouteModel $routeModel)
    {
        if (strtolower($routeModel->getMethod()) !== strtolower($this->getMethod())) {
            return false;
        }
        $routeASplit = explode("/", $this->getRoute());
        $requestRouteSplit = explode("/", $routeModel->getRoute());

        //If the requested route requires another uri segment then there is no match
        if (count($routeASplit) < count($requestRouteSplit)) {
            return false;
        }

        return $this->getRouteScore($routeASplit, $requestRouteSplit);
    }

    /**
     * Compare the split config route segments to the request route to check
     * for validity and to get a match score
     * @param array $configRoute
     * @param array $requestRoute
     * @return bool|int
     */
    private function getRouteScore(array $configRoute, array $requestRoute)
    {
        $score = 0;
        foreach ($configRoute as $index => $routeSegment) {
            //There can be blank segments when splitting by /
            if ($routeSegment === "") {
                continue;
            }

            //If the requested uri does not contain any more segments but the
            //config uri does, check if the remaining segment is optional
            //and return false if it is required
            if (!isset($requestRoute[$index])) {
                if ($this->isRouteSegmentOptional($routeSegment)) {
                    return $score;
                }
                return false;
            }

            $requestRouteSegment = $requestRoute[$index];

            //Get the score of the specific segment
            $segmentScore = $this->getSegmentScore($routeSegment, $requestRouteSegment);
            //Segment is not a match
            if ($segmentScore === false) {
                return false;
            }

            $score += $segmentScore;
        }

        return $score;
    }

    /**
     * Returns true if the last character is ?
     * @param $routeSegment
     * @return bool
     */
    private function isRouteSegmentOptional($routeSegment)
    {
        return $routeSegment[strlen($routeSegment) - 1] === "?";
    }

    /**
     * Returns true if the first character is :
     * @param $routeSegment
     * @return bool
     */
    private function isRouteSegmentVariable($routeSegment)
    {
        return $routeSegment[0] === ":";
    }

    /**
     * Calculate the segment score using the following table
     * this allows static routes to override variable routes
     *
     * Optional -1
     * Static +2
     * Variable +1
     *
     * @param $routeSegment
     * @param $requestRouteSegment
     * @return bool|int
     */
    private function getSegmentScore($routeSegment, $requestRouteSegment)
    {
        $score = 0;
        $isVariable = $this->isRouteSegmentVariable($routeSegment);
        $isOptional = $this->isRouteSegmentOptional($routeSegment);

        if (!$isVariable) {
            if ($isOptional) {
                //It's not a variable but it's optional
                $score += -1;
            } elseif (strtolower($requestRouteSegment) !== strtolower($routeSegment)) {
                //It's not a variable and it's not optional AND it doesn't match
                return false;
            } else {
                //It's not a variable or optional but it does match
                $score += 2;
            }
        } else {
            if (!$isOptional) {
                //Variable but not optional
                $score += 1;
            }

            //If it's variable but also optional we give score 0
            //+1 variable -1 optional
        }

        return $score;
    }
}