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
        return '不支持'. $this->file .'文件类型的预览！';
    }


}