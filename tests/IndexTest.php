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

//    public function testTest()
//    {
//        $this->makeRequest('POST','/index/index/test', ['zane' => ['index'=>1]])->seeJsonStructure(['zane' => ['index']]);
//    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $this->makeRequest('POST','/index/index/read');
    }

    public function testCreate()
    {
//        $this->makeRequest('GET','/index/index/create')->seeJson(['createResult' => false]);
//        $this->makeRequest('POST','/index/index/create')->seeJson(['createResult' => false]);
//        $this->makeRequest('POST','/index/index/create',['dir'=>''])->seeJson(['createResult' => false]);
//        $this->makeRequest('POST','/index/index/create',['name'=>''])->seeJson(['createResult' => false]);
//        $this->makeRequest('POST','/index/index/create',['dir'=>'', 'name'=>''])->seeJson(['createResult' => false]);
//        $this->makeRequest('POST','/index/index/create',['dir'=>'1', 'name'=>''])->seeJson(['createResult' => false]);
//        $this->makeRequest('POST','/index/index/create',['dir'=>'1', 'name'=>'2'])->seeJson(['createResult' => false]);
//        $this->makeRequest('POST','/index/index/create',['dir'=>'//"?*|<>:', 'name'=>'//"?*|<>:'])->seeJson(['createResult' => false]);
        //创建文件夹的单元测试 必要时候才进行。
//        $this->makeRequest('POST','/index/index/create',['dir'=>'', 'name'=>'2'])->seeJson(['createResult' => true]);
//        $this->makeRequest('POST','/index/index/create',['dir'=>'qrmaster', 'name'=>'2'])->seeJson(['createResult' => true]);
    }

    public function testRead()
    {
        $this->makeRequest('GET','/index/index/read', ['path' => ''])->seeJsonStructure(['dir','file']);
        $this->makeRequest('GET','/index/index/read', ['path' => '//"?*|<>:'])->seeJsonStructure(['dir','file']);
    }
}