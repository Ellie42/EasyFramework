<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 10:43
 */

namespace EasyFrame\View\Engines;


use EasyFrame\View\Engines\ViewRenderEngine;
use EasyFrame\View\Models\AbstractViewModel;

class EasyFrameRenderEngine extends ViewRenderEngine
{
    public function render(AbstractViewModel $viewModel) : string
    {
        foreach ($viewModel->getVariables() as $varName => $varVal) {
            $$varName = $varVal;
        }

        foreach ($viewModel->getHelpers() as $alias => $helper) {
            $$alias = $helper;
        }

        if ($viewModel->getTemplatePath() !== "") {
            ob_start();
            include $viewModel->getTemplatePath();
            $html = ob_get_clean();
        } else {
            //TODO render plain content as html and add tags
            $html = $viewModel->getContent();
        }

        return $html ?? "";
    }
}