<?php
//全名营销楼盘活动参数

namespace App\Models;

class Board extends Base
{
    protected static function boot()
    {
        parent::boot();
        // 监听模型更新事件，在写入数据库之前触发
        static::created(function ($model) {
            $url = route('board', $model->id);
            $model->url = $url;
            $model->save();
        });
    }
}
