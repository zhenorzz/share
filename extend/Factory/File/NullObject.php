<?php
namespace Factory\File;

class NullObject
{
    private $file;
    public function __construct($file)
    {
        $this->file = $file;
    }
    public function __call($method,$arg)
    {
        return '无法打开' . $this->file;
    }


}