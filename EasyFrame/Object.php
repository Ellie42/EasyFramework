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
    protected static $singletons = [];

    /**
     * @param string $name Class name or alias
     * @param array $params
     * @return mixed
     */
    public static function create($name, array $params = [])
    {
        $object = self::getInstance($name, $params);

        //Sets properties that the object has requested
        $object = self::handleObjectRequests($object);

        return $object;
    }

    /**
     * Create an instance of an object if there is no other instance
     * otherwise return the instance
     * @param $name
     * @param array $params
     * @return mixed
     */
    public static function singleton($name, array $params = [])
    {
        if (!isset(self::$singletons[$name])) {
            self::$singletons[$name] = self::create($name, $params);
        }

        return self::$singletons[$name];
    }

    /**
     * Return an object from class name
     * @param string $class
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    protected static function getInstance($class, $params = [])
    {
        //TODO add auto DI and caching
        if (!class_exists($class)) {
            throw new \Exception("Class $class does not exist");
        }

        //TODO cache! cache! cache!
        $args = self::buildArgumentsArray($class, $params);

        return count($args) <= 0 ? new $class() : new $class(...$args);
    }

    /**
     * Build the list of construct params for a given class using
     * user supplied $params first then auto injecting classes using typehints
     * if there are no user supplied params that cover that parameter.
     * @param $class
     * @param $params
     * @return array
     */
    private static function buildArgumentsArray($class, $params) : array
    {
        $reflectedClass = new \ReflectionClass($class);
        $construct = $reflectedClass->getConstructor();

        if ($construct == null) {
            return [];
        }

        $constructParams = $construct->getParameters();

        $params = self::getAllParams($constructParams, $params);

        return $params ?? [];
    }

    /**
     * TODO make this better or remove it....probably remove it
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

    /**
     * Instantiates a class specifically for injection.
     * If the requested class is a singleton then it will return the singleton,
     * otherwise it will just create a new object.
     * @param string $className
     * @return mixed
     */
    private static function getInjectionClass(string $className)
    {
        if (isset(self::$singletons[$className])) {
            return self::$singletons[$className];
        }
        return self::create($className);
    }

    /**
     * Combine the given params and params requested from the construct
     * @param \ReflectionParameter[] $constructParams
     * @param $params
     * @return array
     */
    private static function getAllParams($constructParams, $params) : array
    {
        $userParamCount = count($params);
        $constructParamCount = count($constructParams);
        $realParams = [];

        $curUserParamIndex = 0;

        //Loop through all the construct parameters
        foreach ($constructParams as $index => $param) {
            //Get the type hinted class name of the parameter
            $reflectedClassParam = $param->getClass();

            //If the number of params remaining to loop are less than or equal to the number
            //of user supplied params then just skip the auto injection.
            //OR if the current param doesn't have a class type hint then we just assume
            //the rest of the params are for the user to add.
            //OOOR if the param is optional we assume the user doesn't want us to inject it automatically
            //This allows the user to override any auto injection as a bonus I guess. :)
            //TODO all of this needs to be cached
            if ($curUserParamIndex > 0
                || $constructParamCount - $index <= $userParamCount
                || $reflectedClassParam === null
                || $param->isOptional()
            ) {

                //Ran out of user params.... I hope the rest of the construct params are optional...
                if (!isset($params[$curUserParamIndex])) {
                    break;
                }
                $realParams[] = $params[$curUserParamIndex];

                //Looping through the user params now
                $curUserParamIndex++;
                continue;
            }

            //Get the param class typehint and inject it
            $className = $reflectedClassParam->getName();
            $realParams[] = self::getInjectionClass($className);
        }
        return $realParams ?? [];
    }


}