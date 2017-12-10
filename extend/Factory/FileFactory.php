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
        $pos = strpos($file_name,'.');
        if ($pos !== false) {
            $file_extension = substr($file_name,$pos+1);
        } else {
            $file_extension = $file;
        }
        if (PATH_SEPARATOR === ';') {
            $file = iconv("utf-8", "gbk", $file);
        }
        switch ($file_extension) {
            case 'txt':
                return new Txt($file);
                break;
            case 'md':
                return new Markdown($file);
                break;
            default :
                return new NullObject($file_extension);
        }
    }
}