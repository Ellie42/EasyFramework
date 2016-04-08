<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 10:21
 */

namespace EasyFrame;

class Object
{
    protected static $objects = [];

    /**
     * @param string $name Class name or alias
     * @param callable $initCallback
     * @return mixed
     */
    public static function create($name, $initCallback = null)
    {
        $object = null;

        //TODO add auto DI and caching
        if (class_exists($name)) {
            $object = new $name();
        }

        //If there is an initialisation callback then call it
        if (is_callable($initCallback)) {
            $res = $initCallback($object);
            $object = $res === null ? $object : $res;
        }

        //Sets properties that the object has requested
        $object = self::handleObjectRequests($object);

        return $object;
    }

    /**
     * Objects can request various properties by implementing methods like
     * public function request"xxxxx"($request){}
     * @param $object
     * @return mixed
     */
    public static function handleObjectRequests($object)
    {
        //TODO turn this into it's own object
        if (method_exists($object, "requestRootDir")) {
            $object->requestRootDir(Config::$rootDir);
        }
        if (method_exists($object, "requestModuleDir")) {
            $object->requestModuleDir(Config::$moduleDir);
        }
        return $object;
    }
}