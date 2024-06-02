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
        'over_name_kana' => 'required|string|regex:/\A[ァ-ヶー]+\z/u|max:30',
        'under_name_kana' => 'required|string|regex:/\A[ァ-ヶー]+\z/u|max:30',
        'mail_address' => 'required|email|unique:users|max:100',
        'sex' => 'required|in:1,2,3',
        'birth' => 'required|date|before:today|after:1999-12-31',
        'old_year' => 'required',
        'old_month' => 'required',
        'old_day' => 'required',
        'role' => 'required|in:1,2,3,4',
        'password' => 'required|string|min:8|max:30|confirmed',
        'password_confirmation' => 'required|string|min:8|max:30',
        
        ];
    }

    public function getValidatorInstance()
    {
        if ($this->input('old_day') && $this->input('old_month') && $this->input('old_year'))
        //もし送られてきた情報の中に日付、月、年が入っていたら...
        {
            $birthDate = implode('-', $this->only(['old_year', 'old_month', 'old_day']));
            //$birthDateを作成する。implodeは結合させるための関数。つまり、年、月、日付を結合させて一つの文字列にしている。
            $this->merge([
                'birth' => $birthDate,
                //thisの中に付け加えている。
            ]);
        }

        return parent::getValidatorInstance();
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
            'regex' => ':attributeはカタカナで入力してください。',
            'email' => 'メールアドレスの形式で入力してください。',
            'unique' =>'すでに登録されている:attributeです。',
            'min' => '最低:min字で入力してください。',
            'confirmed' => 'パスワードが一致しません。',
            'string' => '文字で入力してください。',
            'birth.before' => '今日以前の日付を入力してください。',
            'birth.after' => '2000年1月1日以降でなければなりません。'
        ];
  }

    public function attributes()
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
            'role' => '役職',
            'password' => 'パスワード',
            'password_confirmation' => '確認用パスワード'
        ];
    }
}
