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

    /**
     * Setup the module folders and files in the $root/Modules dir
     */
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

    /**
     * Create directory structure
     */
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

    /**
     * Create the default controller with {$name}Controller.php as the filename
     * @throws \Exception
     */
    private function createController()
    {
        $text = $this->getFileData($this->templateDir . "/ControllerTemplate.php");

        $text = str_replace('$module', $this->name, $text);

        $this->createFile(
            "$this->rootPath/$this->name/Controllers/{$this->name}Controller.php",
            $text
        );
    }
}