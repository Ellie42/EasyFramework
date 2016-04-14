<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:20
 */

namespace EasyFrame\View;


use EasyFrame\View\Engines\ViewRenderEngine;
use EasyFrame\View\Models\AbstractViewModel;

class ViewRenderer
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
        echo $this->renderEngine->render($viewModel);
        die;
    }
}