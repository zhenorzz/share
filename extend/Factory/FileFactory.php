<?php

namespace Factory;

use Factory\File\Markdown;
use Factory\File\NullObject;
use Factory\File\Txt;
use Factory\File\Image;

class FileFactory
{
    static public function createFile($file)
    {
        if (PATH_SEPARATOR === ';') {
            $file = iconv("utf-8", "gbk", $file);
        }

        //首先要判断给定的文件存在与否
        if (!file_exists($file)) {
            return new NullObject($file);
        }
        $contentType = mime_content_type($file);
        list($content, $type) = explode('/', $contentType);
        if ($content !== 'text' && $content !== 'image') {
            return new NullObject($file);
        }

        if ($content === 'image') {
            return new Image($file);
        }

        $fileSplit = explode('/', $file);
        $file_name = end($fileSplit);
        $pos = strpos($file_name, '.');
        if ($pos !== false) {
            $file_extension = substr($file_name, $pos + 1);
        } else {
            $file_extension = $file;
        }
        if ($content === 'text' && ($file_extension === 'md' || $file_extension === 'markdown')) {
            return new Markdown($file);
        }  else if ($type === 'plain') {
            return new Txt($file);
        } else {
            return new NullObject($file);
        }
    }
}