<?php
namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects){
    //もし$categoryの変数がnameと一致していたら
    if($category == 'name'){
      if(is_null($subjects)){//$subjectsがセレクトされていなかったら
        $searchResults = new SelectNames();
      }else{ //$subjectsがセレクトされていたら
        $searchResults = new SelectNameDetails();
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    //もし$categoryの変数がidと一致していたら
    }else if($category == 'id'){
      if(is_null($subjects)){
        $searchResults = new SelectIds();//$subjectsがセレクトされていなかったら
      }else{
        $searchResults = new SelectIdDetails();
      }//$subjectsがセレクトされていたら
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }else{//指定がなかったら
      $allUsers = new AllUsers();
    return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
    }
  }
}