<?php
namespace Factory\File;

interface FileProperties {
    public function __construct($file);
    public function read();
}