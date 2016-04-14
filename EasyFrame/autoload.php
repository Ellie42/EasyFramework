<?php

use EasyFrame\Config;

/**
 * Autoload all classes within the module directory
 */
spl_autoload_register(function ($class) {
    $splitClass = explode("\\", $class);
    $modDir = Config::$moduleDir;
    $classSegmentCount = count($splitClass);

    $filePath = $modDir;

    foreach ($splitClass as $index => $segment) {
        $filePath .= "/$segment";
        if ($index === $classSegmentCount - 1) {
            if (!is_file("$filePath.php")) {
                return false;
            }
            include "$filePath.php";
        }

        if (!file_exists($filePath)) {
            return false;
        }
    }
});