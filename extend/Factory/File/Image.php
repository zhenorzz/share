<?php
namespace Factory\File;

class Image implements FileProperties
{
    private $file;
    public function __construct($file)
    {
        $this->file = $file;
    }

    public function read()
    {
        $img_info = getimagesize($this->file);
        $img_src = "data:{$img_info['mime']};base64," . base64_encode(file_get_contents($this->file));
        return '<img src="' . $img_src . '" alt="' . $this->file . '" width="100%">';
    }
}