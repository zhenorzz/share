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
        $qrCode->setValidateResult(false);
        try {
            $qrCode->setWriterByName('png');
            if (!empty($_FILES['qrcodeLogo']['tmp_name'])) {
                $qrCode->setLogoPath($_FILES['qrcodeLogo']['tmp_name']);
                $qrCode->setLogoWidth(50);
            } elseif (preg_match('/^(data:\s*image\/(\w+);base64,)/', $param['qrcodeLogo'], $result)) {
                $type = $result[2];
                $new_file = time(). '.' . $type;
                file_put_contents($new_file, base64_decode(str_replace($result[1], '', $param['qrcodeLogo'])));
                $qrCode->setLogoPath($new_file);
                $qrCode->setLogoWidth(50);
            }
        } catch (InvalidPathException $e) {
            return $e->getMessage();
        } catch (InvalidWriterException $e) {
            return $e->getMessage();
        }
        $qrcodeImg = $qrCode->writeDataUri();
        isset($new_file) && file_exists($new_file) && unlink($new_file);
        return $qrcodeImg;
    }

    public function logoPreview(Request $request)
    {
        $file = $request->file('file');
        $result = $this->validate(
            [
                'file' => $file,
            ],
            [
                'file'  => 'fileExt:png,jpg,jpeg',
            ]);
        if(true !== $result){
            // 验证失败 输出错误信息
            return json($result, 403);
        }
        $fileContent = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
        $fileType = $_FILES['file']['type'];
        $img= 'data:'.$fileType.';base64,'. $fileContent;
        return $img;
    }
}