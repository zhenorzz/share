<?php
namespace app\index\controller;

use think\Controller;
use think\Request;

class Http extends Controller
{
    public function show(Request $request)
    {
        $param = $request->param();
        $url = $param['url'];
        if (! empty($param['urlParam'])) {
            $url .= '?' . http_build_query($param['urlParam']);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($param['method'] === 'POST' && ! empty($param['bodyParam'])) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param['bodyParam']);
        }
        $body = curl_exec($ch);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        return json([
                'contentType' => explode(';', $contentType)[0],
                'body' => $body,
            ]);
    }
}