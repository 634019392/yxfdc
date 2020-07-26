<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as AuthUser;

class Apiuser extends AuthUser
{
    use HasApiTokens, Notifiable;

    protected $guarded = [];

    // 一对多 查看购房者 被推荐的 人
    public function buyers()
    {
        return $this->belongsToMany(Buyer::class, 'recommenders', 'apiuser_id', 'buyer_id')
            ->withPivot(['house_id'])
            ->withTimestamps();
    }

    // 推荐 （可以推荐自己）
    // $buyer_arr 必须有手机号，身份证后6位
    // $house_arr 默认为0
    //  $is_filt = 0为不过滤，1为过滤（只取参与全民营销的楼盘）
    public function recommend($openid, $buyer_arr, $house_arr = 0, $is_filt = 0)
    {
        if (!is_array($buyer_arr)) {
            compact('buyer_arr');
        }
        // $buyer_arr 必然会有手机号和身份证后6位数
        if (!isset($buyer_arr['truename']) && !isset($buyer_arr['phone']) && !isset($buyer_arr['card_alert_six'])) {
            return ['status' => 412, 'msg' => '姓名、手机号、身份证后6位为必填'];
        }
        if (strlen($buyer_arr['card_alert_six']) <> 6) {
            return ['status' => 412, 'msg' => '请检查身份证是否为6位'];
        }
        $pattern = "/^((1[0-9][0-9]))\\d{8}$/";
        $string = $buyer_arr['phone'];
        if (!preg_match($pattern, $string)) {
            return ['status' => 412, 'msg' => '请输入正确手机号格式'];
        }

        if ($is_filt == 1) {
            // 过滤一波---是正在参与经纪人的楼盘,逻辑上不会出现这种问题(因为在渲染经纪人楼盘的时候已经过滤了)
            $houses = House::whereIn('id', $house_arr)->get();
            $new_house_arr = [];
            foreach ($houses as $house) {
                if ($house->is_marketing == 1) {
                    array_push($new_house_arr, $house->id);
                } else {
                    continue;
                }
            }
        }

        $buyer = Buyer::where('phone', $buyer_arr['phone'])->first();

        if (!$buyer) {
            // 不存在的情况：随意推荐不限制
            // 1.用户列表创建用户  2.纳入到推荐者门下
            if ($is_filt == 1) {
                $house_arr = $new_house_arr;
            }
            $new_user = Buyer::create($buyer_arr);
            foreach ($house_arr as $house_id) {
                $this->buyers()->attach($new_user->id, ['house_id' => $house_id]);
            }
            return ['status' => 200, 'msg' => '推荐成功!'];
        } else {
            if ($buyer->card_alert_six != $buyer_arr['card_alert_six']) {
                return ['status' => 412, 'msg' => '手机号与身份证后6位不匹配'];
            }

            if ($is_filt == 1) {
                $house_arr = $new_house_arr;
            }

            // 存在的情况：要查找购房人被推荐的楼盘中是否有这个推荐楼盘的id
            $house_params = $buyer->isHouseExist($house_arr);

            $attr = array_count_values($house_params['judge']);
            if (!isset($attr['pass']) || $attr['pass'] == 0) {
                // 所有点的楼盘都存在则给与前端提示
                return ['status' => 412, 'msg' => '所选楼盘都已经被推荐过了'];
            }

            foreach ($house_params['id'] as $house_id) {
                if ($house_id) {
                    $this->buyers()->attach($buyer->id, ['house_id' => $house_id]);
                }
            }
            return ['status' => 200, 'msg' => '推荐成功!'];
        }
    }

    // 1对多，查找当前用户在中间表的多个当前用户
    public function apiusers()
    {
        return $this->hasMany(Recommender::class, 'apiuser_id', 'id');
    }

    // 中间表信息--根据中间表的属于关系渲染
    // 调用此方法$params:1全数组模式,后期看情况改动
    public function centre_info()
    {
        foreach ($this->apiusers as $recommender) {
            $val1 = $recommender->house()->first();
            $val2 = $recommender->buyer()->first();
            if ($val1 && $val2) {
                $recommender->house_arr = $val1->toArray();
                $recommender->buyer_arr = $val2->toArray();
            }
        }
        $this->apiusers = $recommender;
        return $this->toArray();
    }

    // 取消推荐 (传入数组id)
    public function unrecommend($buyer_ids)
    {
        if (!is_array($buyer_ids)) {
            $buyer_ids = compact('buyer_ids');
        }

        $this->buyers()->detach($buyer_ids);
    }
}
