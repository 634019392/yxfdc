<?php

namespace App\Models;

class Fang extends Base
{
    // 房东属于房源
    public function fangowner()
    {
        // 关联业主（房东）,第二个参数是本模型的外键
        return $this->belongsTo('App\Models\Fangowner', 'fang_owner');
    }

    // 房源配套修改器
    public function setFangConfigAttribute($value)
    {
        $this->attributes['fang_config'] = implode(',', $value);
    }

    // 房源图片修改器
    public function setFangPicAttribute($value)
    {
        $this->attributes['fang_pic'] = trim($value, '#');
    }

    public function relationData()
    {
        // 业主
        $fangowner_data = Fangowner::get();
        // 省份数据
        $city_data = City::where('pid', 0)->get();
        // 租期方式
        $fang_rent_type_id = Fangattr::where('field_name', 'fang_rent_type')->value('id');
        $fang_rent_type_data = Fangattr::where('pid', $fang_rent_type_id)->get();
        // 房源朝向
        $fang_direction_id = Fangattr::where('field_name', 'fang_direction')->value('id');
        $fang_direction_data = Fangattr::where('pid', $fang_direction_id)->get();
        // 租赁方式
        $fang_rent_class_id = Fangattr::where('field_name', 'fang_rent_class')->value('id');
        $fang_rent_class_data = Fangattr::where('pid', $fang_rent_class_id)->get();
        // 配套设施
        $fang_config_id = Fangattr::where('field_name', 'fang_config')->value('id');
        $fang_config_data = Fangattr::where('pid', $fang_config_id)->get();

        return [
            'fangownerData' => $fangowner_data,
            'cityData' => $city_data,
            'fang_rent_type_data' => $fang_rent_type_data,
            'fang_direction_data' => $fang_direction_data,
            'fang_rent_class_data' => $fang_rent_class_data,
            'fang_config_data' => $fang_config_data,
        ];
    }
}
