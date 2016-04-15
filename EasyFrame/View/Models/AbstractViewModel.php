<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 13/04/16
 * Time: 09:20
 */

namespace EasyFrame\View\Models;


use EasyFrame\Config\ViewConfig;
use EasyFrame\Http\Request;
use EasyFrame\Model\AbstractObject;
use EasyFrame\Object;
use EasyFrame\View\Helpers\IViewHelper;

class AbstractViewModel extends AbstractObject
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var string
     */
    protected $module;
    /**
     * @var ViewConfig
     */
    protected $templatePath;
    protected $content;
    protected $viewDirectories;
    /**
     * @var IViewHelper[]
     */
    protected $helpers;
    /**
     * @var array
     */
    protected $variables = [];

    public function __construct(Request $request, $config = null)
    {
        $this->request = $request;
        $this->module = $request->getModule();

        if ($config === null || is_string($config)) {
            return;
        }
        $this->templatePath = $config->templatePath;
    }

    /**
     * Add a class to be used in the view
     * @param $helper
     * @param string $alias
     * @throws \Exception
     */
    public function useHelper($helper, string $alias = null)
    {
        if (!is_object($helper) && class_exists($helper)) {
            $helper = Object::create($helper);
        }

        if (!($helper instanceof IViewHelper)) {
            throw new \Exception("View helpers must implement the IViewHelper interface");
        }

        $this->helpers[$alias ?? get_class($helper)] = $helper;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }


    /**
     * @return \EasyFrame\View\Helpers\IViewHelper[]
     */
    public function getHelpers() : array
    {
        return $this->helpers ?? [];
    }

    /**
     * Add a variable to be accessed in the view
     * @param $name
     * @param $value
     */
    public function setVariable(string $name, $value)
    {
        $this->variables[$name] = $value;
    }

    /**
     * @return array
     */
    public function getVariables() : array
    {
        return $this->variables;
    }

    /**
     * @return string
     */
    public function getTemplatePath() : string
    {
        return $this->templatePath ?? "";
    }

    /**
     * @param string $templatePath
     */
    public function setTemplatePath(string $templatePath)
    {
        $this->templatePath = $templatePath;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return array
     */
    public function getViewDirectories() : array
    {
        return $this->viewDirectories ?? [];
    }

    public function setViewDirectories($viewDirectories)
    {
        $this->viewDirectories = $viewDirectories;
    }

    public function getPathInView()
    {
        return explode("Views/", $this->templatePath)[1];
    }
}