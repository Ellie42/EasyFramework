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
        $splitFileName = explode(".", $fileName);
        $fileNameNoEx = array_slice($splitFileName, 0, -1)[0];
        $fileEx = array_slice($splitFileName, -1)[0];

        $folderPath = implode("/", array_slice($splitPath, 0, $splitPathCount - 1));
        $this->path = "$this->testDir/$folderPath/{$fileNameNoEx}Test.$fileEx";

        $this->createFile($this->path, $this->getTestTemplate());

        if (!is_dir("$this->testDir/$folderPath")) {
            mkdir("$this->testDir/$folderPath", 0755, true);
        }
    }

    private function getTestTemplate() : string
    {

    }
}