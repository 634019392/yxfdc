<?php

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

function strtotime13()
{
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}

// 更好的dda函数
function dda($model)
{
    if (method_exists($model, 'toArray')) {
        dd($model->toArray());
    } else {
        dd($model);
    }
}

// 上传图片到七牛云
function qiniu_update($filePath)
{
    $accessKey = config('qiniu.accessKey');
    $secretKey = config('qiniu.secretKey');
    $auth = new Auth($accessKey, $secretKey);
    $bucket = config('qiniu.bucket');
    // 生成上传Token
    $token = $auth->uploadToken($bucket);
    //// 要上传文件的本地路径
//    $filePath = 'uploads/cards/zagvXrVVmcudQVolOw63KReoCOClsmdhBjucDyjl.jpeg';

    // 上传到七牛后保存的文件名
    $key = basename($filePath);

    // 初始化 UploadManager 对象并进行文件的上传。
    $uploadMgr = new UploadManager();

    // 调用 UploadManager 的 putFile 方法进行文件的上传。
    $qiniu_res = $uploadMgr->putFile($token, $key, $filePath);

    unlink(public_path($filePath));

    return $qiniu_res;
}

// 删除七牛云中的图片
function qiniu_del($filePath)
{
    $accessKey = config('qiniu.accessKey');
    $secretKey = config('qiniu.secretKey');
    $bucket = config('qiniu.bucket');
    $key = basename($filePath);
    $days = 1;
    $auth = new Auth($accessKey, $secretKey);
    $config = new \Qiniu\Config();
    $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
    $err = $bucketManager->deleteAfterDays($bucket, $key, $days);
    if ($err) {
        print_r($err);
    }
}

function treeLevel($data, $pid = 0, $html = '--', $level = 0)
{
    static $arr = [];

    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['html'] = str_repeat($html, $level * 2);
            $val['level'] = $level + 1;
            $arr[] = $val;
            treeLevel($data, $val['id'], $html, $val['level']);
        }
    }

    return $arr;

}

function subTree($data, $pid = 0)
{
    $arr = [];

    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['child'] = subTree($data, $val['id']);
            $arr[] = $val;
        }
    }

    return $arr;

}