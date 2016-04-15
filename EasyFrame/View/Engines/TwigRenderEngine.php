<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 15/04/16
 * Time: 10:11
 */

namespace EasyFrame\View\Engines;


use EasyFrame\View\Models\AbstractViewModel;

class TwigRenderEngine extends ViewRenderEngine
{
    /**
     * @param AbstractViewModel $viewModel
     * @return mixed
     */
    public function render(AbstractViewModel $viewModel) : string
    {
        $dirs = $viewModel->getViewDirectories();
        $loader = new \Twig_Loader_Filesystem();

        foreach ($dirs as $module => $dir) {
            $loader->addPath($dir, $module);
        }

        $twig = new \Twig_Environment($loader);

        return $twig->render(
            "@" . $viewModel->getModule() . "/" . $viewModel->getPathInView(),
            $viewModel->getVariables()
        ) ?? "";
    }
}