<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:20
 */

namespace EasyFrame\View;


use EasyFrame\View\Engines\ViewRenderEngine;

class ViewRenderer
{
    protected $renderEngine;

    public function __construct(ViewRenderEngine $engine){
        $this->renderEngine = $engine;
    }

    /**
     * Render a view model into plain html
     * @param AbstractViewModel $viewModel
     */
    public function render(AbstractViewModel $viewModel)
    {
        die(include $viewModel->getTemplatePath());
    }
}