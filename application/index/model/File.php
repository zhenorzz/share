<?php
namespace app\index\model;

define('UTF8TOGBK',1);
define('GBKTOUTF8',2);
class File
{
    /**
     * 文件格式转换
     * window转为gbk
     * @param $file
     * @param int $direction
     * @return string
     */
    public function convert($file,$direction = UTF8TOGBK){
        if (PATH_SEPARATOR === ';') {
            if ($direction === UTF8TOGBK){
                $file = iconv("utf-8", "gbk", $file);
            } else {
                $file = iconv("gbk", "utf-8", $file);
            }
        }
        return $file;
    }

    /**
     * 文件夹不能含有 ?*\<>:"|
     * 去除左右的空白格
     * 完成正则删除左右DS，补上最后一个DS 保证程序的健壮性
     * @param $dir
     * @return mixed|string
     */
    public function pregDir($dir){
        $dir = preg_replace("/[\?\*\\<>:\"\|]/", "", trim($dir));
        $dir = trim($dir, '/');
        if (! empty($dir)) {
            $dir = $dir . DS;

        } else {
            $dir = '';
        }
        return $dir;
    }
}