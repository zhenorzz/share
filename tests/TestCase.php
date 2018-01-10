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

class TestCase extends \think\testing\TestCase
{
    protected $baseUrl = 'http://localhost:6324';

    /**
     * @param array|string|int $data 需要校验的key
     * @param array $jsonData 需要校验的json数据
     * @return bool
     */
    private function loopJsonKey($data, $jsonData) {
        if (count($data) == count($data, 1)) {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $this->assertArrayHasKey($value, $jsonData);
                }
            } else {
                $this->assertArrayHasKey($data, $jsonData);
            }

            return true;
        }
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->assertArrayHasKey($key, $jsonData);
                $this->loopJsonKey($value, $jsonData[$key]);
            } else {
                $this->assertArrayHasKey($value, $jsonData);
            }
        }
        return true;
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function seeJsonStructure(array $data)
    {
        $actual = json_decode($this->response->getContent(), true);

        if (is_null($actual) || $actual === false) {
            $this->fail('Invalid JSON was returned from the route. Perhaps an exception was thrown?');
        }
        $this->loopJsonKey($data, $actual);
        return $this;
    }
}