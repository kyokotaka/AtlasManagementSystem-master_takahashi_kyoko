<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    //const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
        'created_at'
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories(){
        return $this->belongsToMany('App\Models\Categories\SubCategory','post_sub_categories','post_id','sub_category_id');// リレーションの定義
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}