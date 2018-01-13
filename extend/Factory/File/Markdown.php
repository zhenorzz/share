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
        $markdown = file_get_contents($this->file);
        $parser = new GithubMarkdown();
        $parser->html5 = true;
        $parser->enableNewlines = true;
        return $parser->parse($markdown);
    }


}