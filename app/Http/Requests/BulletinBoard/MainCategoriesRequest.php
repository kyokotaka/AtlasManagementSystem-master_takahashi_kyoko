<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoriesRequest extends FormRequest
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
            'main_category_name' =>'required|string|max:100|unique:main_categories,main_category',
        ];
    }

    public function messages(){
        return [
            'main_category_name.required' =>'必ず入力してください。',
            'main_category_name.unique' => 'すでに存在しています。',
        ];
    }
}
