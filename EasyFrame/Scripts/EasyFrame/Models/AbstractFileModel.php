<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 14/04/16
 * Time: 18:58
 */

namespace EasyFrame\Scripts\EasyFrame\Models;


use EasyFrame\Scripts\AbstractScript;

class AbstractFileModel extends AbstractScript
{
    const TYPE_FILE = 1;
    const TYPE_FOLDER = 2;
    protected $moduleRootDir;
    protected $rootPath;
    protected $testDir;
    protected $path;
    protected $type;
    public $name;
    protected $templateDir;

    public function __construct($name, $rootPath, $templateDirectory)
    {
        $this->moduleRootDir = $rootPath . "/Modules";
        $this->testDir = $rootPath . "/Tests";
        $this->templateDir = $templateDirectory;
        $this->name = $name;
        $this->rootPath = $rootPath;
    }

    /**
     * @return mixed
     */
    public function getPath() : string
    {
        return $this->path ?? "";
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }


    protected function setType(int $type)
    {
        $this->type = $type;
    }

    /**
     * @param $text
     * @return string
     */
    protected function populatePlaceholder(&$text) : string
    {
        $text = str_replace('$module$', $this->name, $text);
        $text = str_replace('$lcmodule$', strtolower($this->name), $text);

        return $text;
    }
}