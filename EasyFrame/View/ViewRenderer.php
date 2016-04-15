<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:20
 */

namespace EasyFrame\View;


use EasyFrame\Config;
use EasyFrame\Helpers\Module\Module;
use EasyFrame\Helpers\Module\ModuleIterator;
use EasyFrame\Model\AbstractObject;
use EasyFrame\View\Engines\ViewRenderEngine;
use EasyFrame\View\Models\AbstractViewModel;

class ViewRenderer extends AbstractObject
{
    protected $renderEngine;

    public function __construct(ViewRenderEngine $engine)
    {
        $this->renderEngine = $engine;
    }

    /**
     * Render a view model into plain html
     * @param AbstractViewModel $viewModel
     */
    public function render(AbstractViewModel $viewModel)
    {
        $viewModel->setViewDirectories($this->getAllViewDirectories());
        echo $this->renderEngine->render($viewModel);
        die;
    }

    //TODO cache
    private function getAllViewDirectories() : array
    {
        $paths = [];
        $iterator = new ModuleIterator();
        $iterator->iterateModules(function (Module $module) use (&$paths) {
            $viewDir = $module->getDir() . "/Views";
            $paths[$module->name] = $viewDir;
        });
        return $paths;
    }
}