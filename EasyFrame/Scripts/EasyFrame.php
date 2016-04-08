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
    if ($value === "create") {

        $creator = new EasyFrameCreate();
        $creator->create(array_slice($argv, $index + 1));
    }
}