<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fang_name' => 'required',
            'fang_xiaoqu' => 'required',
            'fang_province' => 'numeric|min:1',
            'fang_city' => 'numeric|min:1',
            'fang_region' => 'numeric|min:1',
            'fang_addr' => 'required',
            'fang_rent' => 'numeric|min:1',
            'fang_pic' => 'required',
            'fang_floor' => 'numeric|min:-1',
            'fang_shi' => 'numeric|min:1',
            'fang_ting' => 'numeric|min:1',
            'fang_wei' => 'numeric|min:1',
            'fang_direction' => 'required',
            'fang_rent_class' => 'required',
            'fang_using_area' => 'numeric|min:1',
            'fang_owner' => 'required',
            'fang_desn' => 'required',
            'fang_body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fang_name.required' => '房源名称 不能为空',
            'fang_pic.required' => '房屋图片 不能为空',
            'fang_xiaoqu.required'  => '小区名称 不能为空',
            'fang_province.min'  => '省份 必须要选择',
            'fang_city.min'  => '市 必须要选择',
            'fang_region.min'  => '区或县 必须要选择',
            'fang_addr.required'  => '详细地址 不能为空',
            'fang_rent.min'  => '租金 最小不能低于1元',
            'fang_floor.min'  => '楼层 最小不能低于-1层',
            'fang_shi.min'  => '室 最小不能低于1室',
            'fang_ting.min'  => '厅 最小不能低于1厅',
            'fang_wei.min'  => '卫 最小不能低于1卫',
            'fang_direction.required'  => '房源朝向 不能为空',
            'fang_rent_class.required'  => '租赁方式 不能为空',
            'fang_using_area.min'  => '使用面积 最小不能低于1㎡',
            'fang_owner.required'  => '房东 必须要选择',
            'fang_desn.required'  => '房源描述 必须要选择',
            'fang_body.required'  => '房源信息 必须要选择',
        ];
    }
}
