<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 06/04/16
 * Time: 08:31
 */

namespace EasyFrame\Scripts\EasyFrame;

use EasyFrame\Scripts\AbstractScript;
use EasyFrame\Scripts\EasyFrame\Models\Module;

class EasyFrameCreate extends AbstractScript
{
    /**
     * @param array $arguments
     */
    public function create($arguments)
    {
        if (count($arguments) <= 0) {
            self::showError(self::ERR_MSG_MISSING_PARAMETER, "create", "module\nmodel\nservice\ncontroller\nmigration\n");
        }

        //First argument is 'create' so ignore that and get the rest
        $otherArgs = array_slice($arguments, 1);

        switch ($arguments[0]) {
            case "module":
                $this->createModule($otherArgs);
        }
    }

    /**
     * @param array $args
     */
    private function createModule($args)
    {
        if (count($args) <= 0) {
            self::showError(self::ERR_MSG_REQUIRED_VALUE_MISSING, "`name`\neg. create module \"ModuleName\"");
        }

        $newModule = new Module($args[0],getcwd(), __DIR__ . "/Templates");
        $newModule->create();
    }
}