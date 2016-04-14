<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 14/04/16
 * Time: 18:53
 */

namespace EasyFrame\Scripts\EasyFrame\Models\Tests;

use EasyFrame\Scripts\EasyFrame\Models\AbstractFileModel;
use EasyFrame\Traits\FileManagement;

abstract class AbstractFileTest extends AbstractFileModel
{
    use FileManagement;

    protected $path;

    /**
     * Create all the files and folders required for the test
     * @param AbstractFileModel $model
     */
    protected function createTestFiles(AbstractFileModel $model)
    {
        if ($model->type !== $model::TYPE_FILE) {
            return;
        }

        $brokenPath = str_replace("$model->moduleRootDir/", "", $model->getPath());
        $splitPath = explode("/", $brokenPath);
        $splitPathCount = count($splitPath);
        $fileName = $splitPath[$splitPathCount - 1];
        $folderPath = implode("/", array_slice($splitPath, 0, $splitPathCount - 1));
        $this->path = "$this->testDir/$folderPath/$fileName";

        $this->createFile($this->path, "");

        if (!is_dir($this->testDir)) {
            mkdir($this->testDir);
        }
        if (!is_dir("$this->testDir/$folderPath")) {
            mkdir("$this->testDir/$folderPath", 0755, true);
        }
    }
}