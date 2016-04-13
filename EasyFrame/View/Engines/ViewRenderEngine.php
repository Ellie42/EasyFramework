<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 10:26
 */

namespace EasyFrame\View\Engines;


abstract class ViewRenderEngine
{
    public abstract function render($template);
}