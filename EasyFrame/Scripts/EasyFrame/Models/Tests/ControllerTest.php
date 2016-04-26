<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 14/04/16
 * Time: 18:54
 */

namespace EasyFrame\Scripts\EasyFrame\Models\Tests;


use EasyFrame\Scripts\EasyFrame\Helpers\TemplateHelper;
use EasyFrame\Scripts\EasyFrame\Interfaces\ITestable;
use EasyFrame\Scripts\EasyFrame\Models\Controller;

class ControllerTest extends AbstractFileTest implements ITestable
{
    use TemplateHelper;

    public function create(Controller $file)
    {
        $this->createTestFiles($file);
    }

    function getTestTemplate() : string
    {
        $template = $this->getFileData($this->templateDir . "/Test/ControllerTestTemplate.php");

        return $this->populateTemplatePlaceholders($template, [
            'module' => $this->name
        ]);
    }
}