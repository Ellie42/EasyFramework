<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 08/04/16
 * Time: 09:02
 */

namespace EasyFrame\Scripts\EasyFrame\Models;


use EasyFrame\Scripts\AbstractScript;
use EasyFrame\Traits\FileManagement;

class Controller extends AbstractScript
{
    use FileManagement;

    protected $rootDir;
    protected $templateDir;
    protected $moduleRootDir;
    public $name;

    public function __construct($name, $root, $templateDir)
    {
        $this->templateDir = $templateDir;
        $this->name = $name;
        $this->rootDir = $root;
        $this->moduleRootDir = "$root/Modules/$name";
    }

    public function create()
    {
        $text = $this->getFileData($this->templateDir . "/ControllerTemplate.php");

        $text = str_replace('$module$', $this->name, $text);

        $this->createFile(
            $this->moduleRootDir . "/Controllers/{$this->name}Controller.php",
            $text
        );
    }
}