<?php
namespace app\index\controller;

use think\Controller;

class Qrcode extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}