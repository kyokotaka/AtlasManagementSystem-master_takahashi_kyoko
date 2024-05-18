<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
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
        'over_name' => 'required|string|max:10',
        'under_name' => 'required|string|max:10',
        'over_name_kana' => 'required|string|regex:/\A[ァ-ヶー]+\z/|max:30',
        'under_name_kana' => 'required|string|regex:/\A[ァ-ヶー]+\z/|max:30',
        'mail_address' => 'required|email|unique:users|max:100',
        'sex' => 'required|in:1,2,3',
        'old_year' => 'required|date_format:Y',
        'old_month' => 'required|integer|between:1,12',
        'old_day' => 'required|integer|between:1,31',
        'role' => 'required|in:1,2,3,4',
        'password' => 'required|string|min:8|max:30|confirmed',
        'password_confirmation' => 'required|string|min:8|max:30',
        
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attributeは必須です。',
            'max' => '最大:max字で入力してください。',
            
        ];
  }

    public function attributes(): array
    {
        return [
            'over_name' => '姓',
            'under_name' => '名',
            'over_name_kana' => 'セイ',
            'under_name_kana' => 'メイ',
            'mail_address' => 'メールアドレス',
            'sex' => '性別',
            'old_year' =>'年',
            'old_month' => '月',
            'old_day' => '日',
        ];
    }
}
