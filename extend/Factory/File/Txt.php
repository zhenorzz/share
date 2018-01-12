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
        $text = file_get_contents($this->file);
        return $text;
    }


}