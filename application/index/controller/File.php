<?php

namespace app\index\controller;

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
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $path
     * @return \think\Response
     */
    public function read($path)
    {
        $dir = "./share/".$path;
        $files = scandir($dir);
        $data = [];
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($dir.$file)) {
                if (PATH_SEPARATOR === ';') {
                    $file = iconv('GBK', 'UTF-8', $file);
                }
                $data['dir'][] = $file;
            }
            if (is_file($dir.$file)) {
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
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
