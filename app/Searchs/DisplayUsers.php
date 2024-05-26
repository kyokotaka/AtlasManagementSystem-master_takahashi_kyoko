<?php
namespace App\Searchs;

// 改修課題：選択科目の検索機能
interface DisplayUsers{//interface=接点・境界線
public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects);
}