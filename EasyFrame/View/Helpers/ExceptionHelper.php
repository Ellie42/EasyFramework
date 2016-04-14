<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 14/04/16
 * Time: 12:10
 */

namespace EasyFrame\View\Helpers;


class ExceptionHelper implements IViewHelper
{
    public function printFileName($path)
    {
        $splitPath = explode("/", $path);
        $pathSegmentCount = count($splitPath);

        echo $splitPath[$pathSegmentCount - 1];
    }
}