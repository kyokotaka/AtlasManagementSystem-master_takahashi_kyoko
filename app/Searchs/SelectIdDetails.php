<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectIdDetails implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($keyword)){
      $keyword = User::get('id')->toArray();//$keywordが空だったら全てのユーザーのidを返す。
    }else{
      $keyword = array($keyword);//$keywordが入っていたら$keywordと一致するものを返す。
    }
    if(is_null($gender)){
      $gender = ['1', '2', '3'];//もし$genderがセレクトされていなかったら１、２、３、全て返す。
    }else{
      $gender = array($gender);//$genderで送られてきた値を配列として返す。
    }
    if(is_null($role)){
      $role = ['1', '2', '3', '4'];//もし$roleがセレクトされていなかったら１、２、３、４全て返す。
    }else{
      $role = array($role);//$roleで送られてきた値を配列として返す。
    }
    $users = User::with('subjects')
    ->whereIn('id', $keyword)//曖昧検索
    ->where(function($q) use ($role, $gender){
      $q->whereIn('sex', $gender)//曖昧検索
      ->whereIn('role', $role);//曖昧検索
    })
    ->whereHas('subjects', function($q) use ($subjects){//リレーションが存在し、かつそのリレーションに対して特定の条件が満たされる場合にのみ、条件を追加する。subjects=リレーションメソッド名
      $q->whereIn('subjects.id', $subjects);//whereInで曖昧検索をかける
    })
    ->orderBy('id', $updown)->get();
    return $users;
  }

}
