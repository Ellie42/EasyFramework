<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 10:26
 */

namespace EasyFrame\View\Engines;


use EasyFrame\Model\AbstractObject;
use EasyFrame\View\Models\AbstractViewModel;

abstract class ViewRenderEngine extends AbstractObject
{
    /**
     * @param AbstractViewModel $viewModel
     * @return mixed
     */
    public abstract function render(AbstractViewModel $viewModel) : string;
}