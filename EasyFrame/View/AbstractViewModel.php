<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:20
 */

namespace EasyFrame\View;


use EasyFrame\Config\ViewConfig;

class AbstractViewModel
{
    /**
     * @var ViewConfig
     */
    protected $templatePath;

    public function __construct(ViewConfig $config)
    {
        $this->templatePath = $config->templatePath;
    }

    /**
     * @return ViewConfig
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * @param ViewConfig $templatePath
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
    }
}