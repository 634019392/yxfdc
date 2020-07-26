<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function React\Promise\map;

class Buyer extends Base
{
    // 多对多 查看推荐者
    public function borkers()
    {
        return $this->belongsToMany(Apiuser::class, 'recommenders', 'buyer_id', 'apiuser_id');
    }

    // 多对多 查看被推荐到的楼盘
    public function houses()
    {
        return $this->belongsToMany(House::class, 'recommenders', 'buyer_id', 'house_id')
            // 过滤掉5过期的，此处让过期用户可以被推荐
            ->wherePivotIn('status', ['1', '2', '3', '4']);
    }


    // 检查购买者被推荐的楼盘是否存在
    public function isHouseExist($house_ids_arr)
    {
        $ret = [];
        $ret['id'] = array_map(function ($house_id) {
            if ($this->houses->contains($house_id)) {
                return false; // 楼盘id存在不让添加
            } else {
                return $house_id; // 楼盘id不存在返回id
            }
        }, $house_ids_arr);

        $ret['judge'] = array_map(function ($house_id) {
            if ($this->houses->contains($house_id)) {
                return 'stop'; // 楼盘id存在不让添加
            } else {
                return 'pass'; // 楼盘id不存在返回id
            }
        }, $house_ids_arr);
        return $ret;
    }
}
