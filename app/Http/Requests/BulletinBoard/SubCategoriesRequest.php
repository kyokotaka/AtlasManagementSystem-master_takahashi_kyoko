<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoriesRequest extends FormRequest
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
            'main_category_id' => 'required|present',
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category'//今回はネーム属性とカラム名が異なるため、第二引数にカラム名を指定する必要がある。
        ];
    }

    public function messages(){
        return [
            'sub_category_name.required' =>'必ず入力してください。',
            'sub_category_name.unique' =>'すでに存在しています。'
        ];
    }
}
