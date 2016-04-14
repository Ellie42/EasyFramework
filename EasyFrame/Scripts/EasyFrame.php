<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 06/04/16
 * Time: 08:14
 */

use EasyFrame\Scripts\EasyFrame\EasyFrameCreate;

include __DIR__ . "/../../bootstrap.php";

foreach ($argv as $index => $value) {
    switch ($value) {
        case "create":
            $creator = new EasyFrameCreate();
            $creator->create(array_slice($argv, $index + 1));
            break;
    }
}