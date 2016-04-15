<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 11:17
 */

namespace EasyFrame;


use EasyFrame\Config\AppConfig;
use EasyFrame\Config\Errors;
use EasyFrame\Traits\FileManagement;

class Config
{
    use FileManagement;

    public static $rootDir;
    public static $moduleDir;
    public static $testDir;

    private static $app;
    /**
     * @var Errors
     */
    private static $errors;

    /**
     * @return Errors
     */
    public static function Errors() : Errors
    {
        return self::$errors;
    }

    public static function App() : AppConfig
    {
        return self::$app;
    }

    public static function load()
    {
        self::$errors = new Errors();
        self::$app = new AppConfig();
        $configDir = self::$rootDir . "config";
        $files = array_slice(scandir($configDir), 2);
        foreach ($files as $file) {
            if (!is_file("$configDir/$file")) {
                continue;
            }

            include_once "$configDir/$file";
        }
    }
}