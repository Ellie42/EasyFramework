<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 15/04/16
 * Time: 11:36
 */

namespace EasyFrame\Config;


class AppConfig
{
    protected $defaultRenderEngine;

    /**
     * @return mixed
     */
    public function getDefaultRenderEngine()
    {
        return $this->defaultRenderEngine;
    }

    /**
     * @param mixed $defaultRenderEngine
     */
    public function setDefaultRenderEngine(string $defaultRenderEngine)
    {
        $this->defaultRenderEngine = $defaultRenderEngine;
    }
}