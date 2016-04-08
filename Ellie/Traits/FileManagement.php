<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 04/04/16
 * Time: 15:27
 */

namespace Ellie\Traits;

trait FileManagement
{
    /**
     * Attempt to open a file and throw exception if unable
     * @param $filePath
     * @return resource
     * @throws \Exception
     */
    protected function tryOpenFile($filePath)
    {
        $fileHandle = fopen($filePath, 'r');

        if (!$fileHandle) {
            throw new \Exception("Unable to open file " . $filePath);
        }

        return $fileHandle;
    }

    protected function closeFile($handle)
    {
        fclose($handle);
    }

    /**
     * Returns the the text within a file
     * @param $filePath
     * @return string
     */
    protected function getFileData($filePath)
    {
        return file_get_contents($filePath);
    }

    /**
     * Iterate through all lines in a file
     * @param $handle
     * @param $callback
     */
    protected function iterateLines($handle, $callback)
    {
        $index = 0;
        while (($curLine = fgets($handle)) !== false) {
            $callback($curLine, $index);
            $index++;
        }
    }

    protected function createFile($filePath, $contents)
    {
        file_put_contents($filePath, $contents);
    }
}