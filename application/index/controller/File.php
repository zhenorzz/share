<?php

namespace app\index\controller;

use cebe\markdown\GithubMarkdown;
use think\Request;

class File
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {

    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int $path
     * @return \think\Response
     */
    public function read($path)
    {
        $dir = "./share/" . $path;
        $files = scandir($dir);
        $data = [];
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($dir . $file)) {
                if (PATH_SEPARATOR === ';') {
                    $file = iconv('GBK', 'UTF-8', $file);
                }
                $data['dir'][] = $file;
            }
            if (is_file($dir . $file)) {
                if (PATH_SEPARATOR === ';') {
                    $file = iconv('GBK', 'UTF-8', $file);
                }
                $data['file'][] = $file;
            }
        }
        return json($data);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

    /**
     * 下载指定资源
     *
     * @param  int $file
     */
    public function preview($file)
    {
        //用以解决中文不能显示出来的问题
        $file_name = "./share/" . $file;
        $file_name = iconv("utf-8", "gb2312", $file_name);
        //首先要判断给定的文件存在与否
        if (!file_exists($file_name)) {
            echo "没有该文件文件";
            return;
        }
        $markdown = file_get_contents($file_name);
        $parser = new GithubMarkdown();
        $parser->html5 = true;
        $parser->enableNewlines = true;
        echo $parser->parse($markdown);
    }

    /**
     * 下载指定资源
     *
     * @param  int $file
     */
    public function download($file)
    {
        header("Content-type:text/html;charset=utf-8");
        //用以解决中文不能显示出来的问题
        $file_name = "./share/" . $file;
        $file_name = iconv("utf-8", "gb2312", $file_name);
        //首先要判断给定的文件存在与否
        if (!file_exists($file_name)) {
            echo "没有该文件文件";
            return;
        }
        $fp = fopen($file_name, "r");
        $file_size = filesize($file_name);
        //下载文件需要用到的头
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length:" . $file_size);
        header("Content-Disposition: attachment; filename=" . basename($file_name));
        $buffer = 1024;
        $file_count = 0;
        //向浏览器返回数据
        while (!feof($fp) && $file_count < $file_size) {
            $file_con = fread($fp, $buffer);
            $file_count += $buffer;
            echo $file_con;
        }
        fclose($fp);
    }

    /**
     * 下载指定资源
     *
     * @param  string $path
     * @return \think\response\Json
     */
    public function upload($path)
    {
        $file = $_FILES['file'];
        $path = "./share/" . $path;
        $name = $path . $_FILES["file"]["name"];
        move_uploaded_file($file["tmp_name"], $name);
        return json($file);
    }
}
