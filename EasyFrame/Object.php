<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 10:21
 */

namespace EasyFrame;

use Mockery\CountValidator\Exception;

class Object
{
    protected static $objects = [];

    /**
     * @param string $name Class name or alias
     * @param array $params
     * @return mixed
     */
    public static function create($name, array $params = null)
    {
        $object = self::getInstance($name, $params);

        //Sets properties that the object has requested
        $object = self::handleObjectRequests($object);

        return $object;
    }

    /**
     * Return an object from class name
     * @param string $class
     * @param $params
     * @return mixed
     */
    protected static function getInstance($class, $params = null)
    {
        //TODO add auto DI and caching
        if (!class_exists($class)) {
            throw new Exception("Class $class does not exist");
        }

        return $params === null ? new $class() : new $class(...$params);
    }

    /**
     * TODO make this better or remove it
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