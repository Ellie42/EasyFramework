<?php
/**
 * Controller generated with EasyFrame
 */
namespace $module$\Controllers;

use EasyFrame\Controller\EasyFrameController;use EasyFrame\View\Models\ViewModel;

class $module$Controller extends EasyFrameController
{
    /**
     * This is the default controller action
     */
    public function index()
    {
        return ViewModel::create("$lcmodule$");
    }
}