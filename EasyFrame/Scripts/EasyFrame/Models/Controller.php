<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:02
 */

namespace EasyFrame\Scripts\EasyFrame\Models;


use EasyFrame\Scripts\EasyFrame\Models\Tests\ControllerTest;
use EasyFrame\Scripts\EasyFrame\Models\Tests\TestModel;
use EasyFrame\Traits\FileManagement;

class Controller extends AbstractFileModel
{
    use FileManagement;

    public function create($withTest = false)
    {
        $this->path = $this->moduleRootDir . "/$this->name/Controllers/{$this->name}Controller.php";
        $text = $this->getFileData($this->templateDir . "/ControllerTemplate.php");
        $this->setType(self::TYPE_FILE);

        $this->populatePlaceholder($text);
        $this->createFile(
            $this->path,
            $text
        );

        if ($withTest) {
            $test = new ControllerTest($this->name, $this->rootPath, $this->templateDir);
            $test->create($this);
        }
    }
}