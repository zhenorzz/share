<?php
namespace Factory\File;

class Txt implements FileProperties
{
    private $file;
    public function __construct($file)
    {
        $this->file = $file;
    }

    public function read()
    {
        //首先要判断给定的文件存在与否
        if (!file_exists($this->file)) {
            return "没有该文件文件";
        }
        $text = file_get_contents($this->file);
        return $text;
    }


}