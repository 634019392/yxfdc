<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Recommender extends Base
{
    const STATUS_IS_CHECK = '0';
    const STATUS_NOT_VISIT = '1';
    const STATUS_VISITED = '2';
    const STATUS_SUBSCRIBED = '3';
    const STATUS_SUCCESS = '4';
    const STATUS_EXPIRED = '5';
    public static $statusMap = [
        self::STATUS_IS_CHECK => '待审核',
        self::STATUS_NOT_VISIT => '未到访',
        self::STATUS_VISITED => '已到访',
        self::STATUS_SUBSCRIBED => '已认购',
        self::STATUS_SUCCESS => '已签约',
        self::STATUS_EXPIRED => '已过期',
    ];

    public function house()
    {
        return $this->belongsTo(House::class, 'house_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'id');
    }

    public function apiuser()
    {
        return $this->belongsTo(Apiuser::class, 'apiuser_id', 'id');
    }

    // 改装状态为数组
    protected $appends = ['status_arr'];
    public function getStatusArrAttribute()
    {
        foreach (self::$statusMap as $status => $val) {
            if ($this->attributes['status'] == $status) {
                return [$status, $val];
            }
        }
    }

    // 审核更新
    protected static function boot()
    {
        parent::boot();
        // 监听模型更新事件，在写入数据库之前触发
        static::updating(function ($model) {
            // 更新状态为1未来访(审核通过)的情况，当前时间加30保护期
            if ($model->status[0] == 1) {
                $model->protect_time = Carbon::now()->addDays(30);
            }
            // 更新状态为2已来访的情况，当前时间加30保护期
            if ($model->status[0] == 2) {
                $model->protect_time = Carbon::now()->addDays(30);
            }
            if ($model->status[0] == 3 || $model->status[0] == 4 || $model->status[0] == 5) {
                $model->protect_time = null;
            }
        });
    }
}
