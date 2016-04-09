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
    public $route;
    public $controller;
    public $action;
    public $method;

    /**
     * RouteModel constructor.
     * @param Request $request
     */
    public function __construct(Request $request = null)
    {
        if ($request === null) {
            return;
        }
        $this->route = $request->uri;
        $this->method = $request->method;
    }


    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->$key = strtolower($value);
        }
    }

    /**
     * Check to see if a route matches another route and return a score to show how
     * specific the match is.
     * @param RouteModel $routeModel
     * @return bool
     */
    public function getRouteMatchScore(RouteModel $routeModel)
    {
        if ($routeModel->method !== $this->method) {
            return false;
        }
        $score = 0;
        $routeASplit = explode("/", $this->route);
        $requestRouteSplit = explode("/", $routeModel->route);

        //If the requested route requires another uri segment then there is no match
        if (count($routeASplit) < count($requestRouteSplit)) {
            return false;
        }

        foreach ($routeASplit as $index => $routeSegment) {
            //There can be blank segments when splitting by /
            if ($routeSegment === "") {
                continue;
            }

            //If the requested uri does not contain any more segments but the
            //config uri does, check if the remaining segment is optional
            //and return false if it is required
            if (!isset($requestRouteSplit[$index])) {
                if ($this->isRouteSegmentOptional($routeSegment)) {
                    return $score;
                }
                return false;
            }

            $requestRouteSegment = $requestRouteSplit[$index];

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
            } elseif ($requestRouteSegment !== $routeSegment) {
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