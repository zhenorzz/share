<?php
namespace Factory\File;

use cebe\markdown\GithubMarkdown;

class Markdown implements FileProperties
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
        $markdown = file_get_contents($this->file);
        $parser = new GithubMarkdown();
        $parser->html5 = true;
        $parser->enableNewlines = true;
        return $parser->parse($markdown);
    }


}