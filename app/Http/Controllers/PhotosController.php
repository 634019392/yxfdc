<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseFloor;
use Illuminate\Http\Request;

class PhotosController extends Controller
{
    /**
     * 图片上传
     */
    public function upfile(Request $request)
    {
        if ($request->hasFile('file')) {
            // 上传
            // 参数2 配置的节点名称
            $ret = $request->file('file')->store('', 'images');
            $filePath = 'uploads/images/' . $ret;
            $file = basename($filePath);
            qiniu_update($filePath);
            $url = config('qiniu.http') . $file;
            if ($request->has('num')) {
                return ['status' => 0, 'url' => $url, 'num' => (int)$request->get('num')];
            }
            return ['status' => 0, 'url' => $url];
        } else {
            return ['status' => 10005, 'msg' => '无图片上传'];
        }
    }

    // 普通七牛删除
    public function delfile(Request $request)
    {
        $url = $request->get('url');
        return qiniu_del($url);
    }

    // 删除七牛图片和
    // 传入house_img：删除楼盘主信息中图片的地址
    // 传入foolr_plan_img：删除户型图的地址
    // 优化,1.传入表名称(sql_list_name),2.传入删除的id(sql_id),3.传入删除图片的列名称(sql_column)
    public function delfilesql(Request $request)
    {
        if ($request->has('del_img')) {
            if ($request->get('del_img') == 'house_img') {
                // 删除楼盘封面图片
                $house = House::find($request->get('house_id'));
                $house->img = '';
                $house->save();
            }
            if ($request->get('del_img') == 'foolr_plan_img') {
                // 删除对应的户型图图片
                $floorModel = HouseFloor::find($request->get('house_floor_id'));
                $floorModel->floor_plan = '';
                $floorModel->save();
            }
        }

        $url = $request->get('url');
        if ($request->has('sql_list_name')) {
            \DB::table($request->sql_list_name)->where('id', $request->sql_id)->update([$request->sql_column => '']);
            $str = $url;
            $first_len = stripos($str, '?imageView2');
            if ($first_len)
            $url = substr($str, 0, $first_len);
        }

        qiniu_del($url);
    }
}
