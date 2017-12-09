<?php
namespace app\index\controller;

use think\Controller;

class Json extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}