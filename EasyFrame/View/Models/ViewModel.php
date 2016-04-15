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
    /**
     * @var string
     */
    protected $page;

    /**
     * ViewModel constructor.
     * @param Request $request
     * @param string|Config\ViewConfig|null $viewConfigOrPage
     */
    public function __construct(Request $request, $viewConfigOrPage = null)
    {
        parent::__construct($request, $viewConfigOrPage);

        if (is_string($viewConfigOrPage)) {
            $this->setPage($viewConfigOrPage);
        }
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
        $pagePath = Config::$moduleDir . "/$moduleName/Views/$page";
        if (file_exists($pagePath)) {
            return $this->setTemplatePath($pagePath);
        }
        throw new ViewNotFoundException("$pagePath not found");
    }

//    private function hasExtension($page)
//    {
//        return count(explode(".", $page)) > 1;
//    }
}