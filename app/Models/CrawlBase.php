<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrawlBase extends Model
{
    //
    protected $guarded = [];

//    protected static function boot()
//    {
//        parent::boot(); // TODO: Change the autogenerated stub
//
//        static::creating(function($model) {
//            // 创建之前判断是否存在当天数据，存在则终止此次操作whereTime查找时间(文档=》数据库查询构造器中)
//            $data = $model->whereDate('created_at',date('Y-m-d',time()))->first();
//            if ($data) {
//                exit;
//            }
//        });
//    }
}
