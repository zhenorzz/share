<?php

namespace Factory;

use Factory\File\Markdown;
use Factory\File\NullObject;
use Factory\File\Txt;

class FileFactory
{
    static public function createFile($file)
    {
        $fileSplit = explode('/', $file);
        $file_name = end($fileSplit);
        $pos = strpos($file_name, '.');
        if ($pos !== false) {
            $file_extension = substr($file_name, $pos + 1);
        } else {
            $file_extension = $file;
        }
        if (PATH_SEPARATOR === ';') {
            $file = iconv("utf-8", "gbk", $file);
        }
        //首先要判断给定的文件存在与否
        if (!file_exists($file)) {
            return new NullObject($file);
        }
        switch ($file_extension) {
            case 'txt':
                return new Txt($file);
                break;
            case 'md':
                return new Markdown($file);
                break;
            default :
                $f = fopen($file, "r");
                if (feof($f)) {
                    return new NullObject($file);
                }
                $line = fgets($f);
                if (!mb_detect_encoding($line, 'UTF-8')) {
                    return new NullObject($file);
                }
                return new Txt($file);
        }
    }
}