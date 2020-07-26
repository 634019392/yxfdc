<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function mysql_user(Request $request)
    {
        $user = auth()->guard('api')->user();
        $data['mysql_user'] = $user->only('is_phone_auth');
        return response()->json(['status' => 1000, 'data' => $data], 200);
    }

    // 文件上传
    public function upfile(Request $request)
    {
        if ($request->hasFile('file')) {
            // 上传
            // 参数2 配置的节点名称
            $ret = $request->file('file')->store('', 'card');
            $filePath = 'uploads/cards/' . $ret;
            $file = basename($filePath);
            qiniu_update($filePath); // 上传至七牛，七牛返回一个hash和文件名称
            $url = config('qiniu.http') . $file;

            return ['static' => 0, 'url' => $url];
        } else {
            return ['status' => 10005, 'msg' => '无图片上传'];
        }

    }
}
