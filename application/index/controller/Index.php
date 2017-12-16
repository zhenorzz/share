<?php

namespace app\index\controller;

use Factory\FileFactory;
use think\Request;
use think\Controller;
use app\index\model\File;
use cebe\markdown\GithubMarkdown;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 创建目录.
     *
     * @param Request $request
     * @return string|bool
     */
    public function create(Request $request)
    {
        $param = $request->post();
        $dir = "./share/" . trim($param['dir']) . trim($param['name']) . DS;
        $File = new File();
        $dir = $File->convert($dir);
        if (file_exists($dir)) {
            return json(['createResult' => false, 'errorMsg' => '已存在文件夹']);
        }
        mkdir($dir, 0777);
        return json(['createResult' => true, 'errorMsg' => '']);
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
        $File = new File();
        $dir = $File->convert($dir, UTF8TOGBK);
        $files = scandir($dir);
        $data = [];
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($dir . $file)) {
                $file = $File->convert($file, GBKTOUTF8);
                $data['dir'][] = $file;
            }
            if (is_file($dir . $file)) {
                $file = $File->convert($file, GBKTOUTF8);
                $data['file'][] = $file;
            }
        }
        return json($data);
    }


    /**
     * 删除指定资源
     *
     * @param  string $file
     * @return string
     */
    public function delete($file)
    {
        //用以解决中文不能显示出来的问题
        $file_name = "./share/" . $file;
        $File = new File();
        $file_name = $File->convert($file_name);
        if (!file_exists($file_name)) {
            return false;
        }
        unlink($file_name);
        return $file;
    }

    /**
     * 预览指定资源
     *
     * @param  string $file
     * @return string
     */
    public function preview($file)
    {
        $file_name = "./share/" . $file;
        $FileFacoty = FileFactory::createFile($file_name);
        $content = $FileFacoty->read();
        return $content;
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
        $File = new File();
        $file_name = $File->convert($file_name);
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
        $File = new File();
        $name = $File->convert($name);
        move_uploaded_file($file["tmp_name"], $name);
        return json($file);
    }
}
