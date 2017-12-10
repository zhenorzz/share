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

}