<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNames implements DisplayUsers{//implements=実装する

  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(empty($gender)){
      $gender = ['1', '2', '3'];//もし$genderがセレクトされていなかったら１、２、３、全て返す。
    }else{
      $gender = array($gender);//$genderで送られてきた値を配列として返す。
    }
    if(empty($role)){
      $role = ['1', '2', '3', '4'];//もし$roleがセレクトされていなかったら１、２、３、４全て返す。
    }else{
      $role = array($role);//$roleで送られてきた値を配列として返す。
    }
    $users = User::with('subjects')//Userテーブルと一緒にsubjectsでリレーションしたモデルを持ってくる。
    ->where(function($q) use ($keyword){
      $q->where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
      //部分一致検索
    })->whereIn('sex', $gender)//曖昧検索
    ->whereIn('role', $role)//曖昧検索
    ->orderBy('over_name_kana', $updown)->get();//$updownで送られてきた順に並び替えて表示する。

    return $users;
  }
}
