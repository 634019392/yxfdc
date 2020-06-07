<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddArticleRequest extends FormRequest
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
            'title' => 'required',
            'desn' => 'required',
            'body' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'desn.required' => '摘要 不能为空',
            'body.required' => '内容 不能为空'
        ];
    }
}
