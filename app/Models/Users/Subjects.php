<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    public function users(){
            return $this->belongsToMany('App\Models\users','subject_users','subject_id','users_id');// リレーションの定義
    }

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }
}