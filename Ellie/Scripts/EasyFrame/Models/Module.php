<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 06/04/16
 * Time: 14:08
 */

namespace Ellie\Scripts\EasyFrame\Models;


use Ellie\Traits\FileManagement;
use Ellie\Scripts\AbstractScript;

class Module extends AbstractScript
{
    use FileManagement;

    public $name;
    protected $rootPath;
    protected $templateDir;

    public function __construct($name, $rootPath, $templateDirectory)
    {
        $this->templateDir = $templateDirectory;
        $this->name = $name;
        $this->rootPath = $rootPath;
    }

    public function create()
    {
        if (!in_array("Modules", scandir($this->rootPath))) {
            self::showError("Error: Cannot locate Modules directory.\nPlease run this command from the project root.\n");
        }
        if (in_array($this->name, scandir("$this->rootPath/Modules/"))) {
            self::showError("Error: Module already exists in Modules directory\n");
        }

        $this->createModuleStructure();
        $this->createModuleFiles();
    }

    private function createModuleStructure()
    {
        $moduleRoot = "$this->rootPath/Modules/$this->name";
        mkdir($moduleRoot);
        mkdir("$moduleRoot/Controllers");
        mkdir("$moduleRoot/Models");
        mkdir("$moduleRoot/Services");
        mkdir("$moduleRoot/Views");
    }

    private function createModuleFiles()
    {
        $this->createController();
    }

    private function createController()
    {
        $controllerFile = $this->tryOpenFile($this->templateDir . "/ControllerTemplate.php");

        $lines = "";

        $this->iterateLines($controllerFile, function ($line, $index) use (&$lines) {
            $newLine = str_replace('$module', $this->name, $line);
            $lines .= $newLine;
        });

        $this->closeFile($controllerFile);

        $this->createFile(
            "$this->rootPath/$this->name/Controllers/{$this->name}Controller.php",
            $lines
        );
    }
}