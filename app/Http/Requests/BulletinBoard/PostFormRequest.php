<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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

            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
            'comment' => 'required|string|max:2500',
        ];
    }

    public function messages(){
        return [
            'post_title.required' =>'タイトルは必ず入力してください。',
            'post_title.max' => 'タイトルは100文字以内で入力してください。',
            'post_body.required' =>'投稿内容は必ず入力してください。',
            'post_body.max' => '最大文字数は5000文字です。',
            'comment.required' => 'コメントは必ず入力してください。',
            'comment.max' => '最大文字数は2500字です。'
        ];
    }
}