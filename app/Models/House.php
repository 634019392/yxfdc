<?php

namespace App\Models;
use App\Models\Traits\Btn;

class House extends Base
{
    use Btn;

    public function buyers()
    {
        return $this->belongsToMany(Buyer::class, 'recommenders', 'house_id', 'buyer_id');
    }

    // 1对1 周边配套户型图和楼盘其他相关信息
    public function mating()
    {
        return $this->hasOne(HouseIntroduce::class);
    }

    // 1对多 户型图
    public function houseFloors()
    {
        return $this->hasMany(HouseFloor::class);
    }


}
