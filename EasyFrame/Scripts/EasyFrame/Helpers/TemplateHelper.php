<?php
/**
 * Created by PhpStorm.
 * User: sophie
 * Date: 26/04/16
 * Time: 08:59
 */

namespace EasyFrame\Scripts\EasyFrame\Helpers;


trait TemplateHelper
{
    protected function populateTemplatePlaceholders(string $template, array $data):string
    {
        foreach ($data as $placeholder => $value) {
            $template = str_replace('$' . $placeholder . '$', $value, $template);
        }

        return $template;
    }
}