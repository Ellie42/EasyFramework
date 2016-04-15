<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 15/04/16
 * Time: 09:00
 */

namespace EasyFrame\Scripts\EasyFrame\Models;


use EasyFrame\Traits\FileManagement;

class FileModel extends AbstractFileModel
{
    use FileManagement;

    public function create($contents)
    {
        $this->createFile($this->path, $contents);
    }
}