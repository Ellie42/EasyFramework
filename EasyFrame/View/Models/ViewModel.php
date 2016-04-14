<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:20
 */

namespace EasyFrame\View\Models;


use EasyFrame\Config;
use EasyFrame\Exceptions\ViewNotFoundException;
use EasyFrame\Http\Request;

class ViewModel extends AbstractViewModel
{
    protected $request;
    /**
     * @var string
     */
    protected $page;
    /**
     * @var string
     */
    protected $module;

    public function __construct(Request $request, $viewConfig = null)
    {
        $this->request = $request;
        $this->module = $request->getModule();
        parent::__construct($viewConfig);
    }

    /**
     * Set the page template to render, defaults to the the current module folder
     * eg. $module/Views/$page.phtml
     * @param string $page
     * @param string|null $module
     * @throws ViewNotFoundException
     */
    public function setPage(string $page, string $module = null)
    {
        $moduleName = $module??$this->module;
        $pagePath = Config::$moduleDir . "/$moduleName/Views/$page.phtml";
        if (file_exists($pagePath)) {
            return $this->setTemplatePath($pagePath);
        }
        throw new ViewNotFoundException("$pagePath not found");
    }
}