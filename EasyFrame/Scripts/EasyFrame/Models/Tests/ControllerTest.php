<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 14/04/16
 * Time: 18:54
 */

namespace EasyFrame\Scripts\EasyFrame\Models\Tests;


use EasyFrame\Scripts\EasyFrame\Models\Controller;

class ControllerTest extends AbstractFileTest
{
    public function create(Controller $file)
    {
        $this->createTestFiles($file);
    }
}