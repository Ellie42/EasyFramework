<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 06/04/16
 * Time: 14:09
 */

namespace EasyFrame\Scripts;


use CLIFramework\Command;

class AbstractScript
{
    const ERR_MSG_REQUIRED_VALUE_MISSING = -1;
    const ERR_MSG_MISSING_PARAMETER = -2;

    protected static function showError($message, ...$params)
    {
        $spacerLine = str_repeat("-", 50);

        switch ($message) {
            case self::ERR_MSG_MISSING_PARAMETER:
                die("Error: Option `$params[0]` requires a second parameter\n$spacerLine\nAllowed parameters are:\n$params[1]\n");
            case self::ERR_MSG_REQUIRED_VALUE_MISSING:
                die("Error: Missing parameter $params[0]\n");
            default:
                die($message);
        }
    }
}