<?php
//全名营销楼盘活动参数

namespace App\Models;

class ActParam extends Base
{
    public function house()
    {
        return $this->belongsTo(House::class, 'house_id', 'id');
    }
}
