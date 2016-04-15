<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 06/04/16
 * Time: 14:08
 */

namespace EasyFrame\Scripts\EasyFrame\Models;


use EasyFrame\Traits\FileManagement;
use EasyFrame\Scripts\AbstractScript;

class Module extends AbstractFileModel
{
    use FileManagement;

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

        $this->moduleRootDir = "$this->rootPath/Modules/$this->name";

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
//        mkdir("$moduleRoot/Services");
        mkdir("$moduleRoot/Views");
    }

    private function createModuleFiles()
    {
        $controller =
            new Controller($this->name, $this->rootPath, $this->templateDir);
        $controller->create(true);

        $routeText = $this->getFileData("$this->templateDir/routes.php");

        $this->populatePlaceholder($routeText);

        $this->createFile("$this->moduleRootDir/routes.php", $routeText);

        $this->createViewFile();
    }

    private function createViewFile()
    {
        $template = $this->getFileData("$this->templateDir/view.phtml");
        $view = new FileModel($this->name, $this->rootPath, $this->templateDir);
        $view->setType(FileModel::TYPE_FILE);
        $view->setPath("$this->moduleRootDir/Views/" . strtolower($this->name) . ".phtml");
        $view->create($this->populatePlaceholder($template));
    }


}