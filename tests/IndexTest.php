<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
namespace tests;

class IndexTest extends TestCase
{

    public function testTest()
    {
        $this->makeRequest('POST','/index/index/test', ['zane' => ['index'=>1]])->seeJsonStructure(['zane' => ['index'],'ni']);
    }
}