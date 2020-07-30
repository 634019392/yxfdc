<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HouseRequest extends FormRequest
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
            'name' => 'required',
            'address' => 'required',
            'image_pic' => 'required',
            'phone' => 'required',
            'mating.open_time' => 'required|max:100',
            'mating.feature' => 'required',
            'mating.type' => 'required|max:20',
            'mating.decor' => 'required|max:255',
            'mating.floor_space' => 'required|max:11',
            'mating.property_right' => 'required|integer|between:1,100',
            'mating.greening' => 'required|integer|between:1,100',
            'mating.plot' => 'required|numeric|between:1,100',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '项目名称 不能为空',
            'address.required' => '项目地址 不能为空',
            'image_pic.required'  => '项目封面图 不能为空',
            'phone.required'  => '项目热线 不能为空',
            'mating.open_time.required'  => '开盘日期 不能为空',
            'mating.open_time.max'  => '开盘日期 长度不能超过:size',
            'mating.type.required'  => '产品类型 不能为空',
            'mating.type.max'  => '产品类型 长度不能超过:size',
            'mating.decor.required'  => '装修情况 不能为空',
            'mating.decor.max'  => '装修情况 长度不能超过:size',
            'mating.feature.required'  => '项目特色 不能为空',
            'mating.floor_space.required'  => '占地面积 不能为空',
            'mating.floor_space.max'  => '占地面积 长度不能超过:max',
            'mating.property_right.required'  => '产权 不能为空',
            'mating.property_right.between'  => '产权 数值在:min-:max',
            'mating.greening.required'  => '绿化率 不能为空',
            'mating.greening.between'  => '绿化率 数值在:min-:max',
            'mating.plot.required'  => '容积率 不能为空',
            'mating.plot.between'  => '容积率 数值在:min-:max',
        ];
    }
}
