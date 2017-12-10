<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use Endroid\QrCode\Exception\InvalidPathException;
use Endroid\QrCode\Exception\InvalidWriterException;

class Qrcode extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    public function create(Request $request)
    {
        $param = $request->post();
        $result = $this->validate($param,
            [
                'qrcodeContent' => 'require',
            ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            return $result;
        }
        $qrcodeContent = $param['qrcodeContent'];
        $qrCode = new \Endroid\QrCode\QrCode($qrcodeContent);
        $qrCode->setSize(256);
        $qrCode->setEncoding('UTF-8');
        $qrCode->setValidateResult(true);
        try {
            $qrCode->setWriterByName('png');
            if (!empty($_FILES['qrcodeLogo']['tmp_name'])) {
                $qrCode->setLogoPath($_FILES['qrcodeLogo']['tmp_name']);
                $qrCode->setLogoWidth(50);
            }
        } catch (InvalidPathException $e) {
            return $e->getMessage();
        } catch (InvalidWriterException $e) {
            return $e->getMessage();
        }
        return $qrCode->writeDataUri();
    }
}