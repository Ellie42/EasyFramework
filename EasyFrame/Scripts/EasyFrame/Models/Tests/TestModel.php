<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 14/04/16
 * Time: 19:39
 */

namespace EasyFrame\Scripts\EasyFrame\Models\Tests;


use EasyFrame\Scripts\EasyFrame\Models\AbstractFileModel;

class TestModel extends AbstractFileTest
{
    public function create(AbstractFileModel $file)
    {
        $this->createTestFiles($file);
    }
}