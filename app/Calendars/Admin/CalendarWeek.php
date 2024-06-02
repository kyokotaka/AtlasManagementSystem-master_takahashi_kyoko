<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;

class CalendarWeek{//その週のカレンダーの出力
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0){
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  function getClassName(){
    return "week-" . $this->index;
  }

  function getDays(){
    $days = [];
    $startDay = $this->carbon->copy()->startOfWeek();//週の開始日
    $lastDay = $this->carbon->copy()->endOfWeek();//週の終わり
    $tmpDay = $startDay->copy();//週の開始日を取得できる

    while($tmpDay->lte($lastDay)){//月〜日までをループ
      if($tmpDay->month != $this->carbon->month){//月の初めと終わりに日付がなかったら(違う月になっていたら)ブランクを表示させる
        $day = new CalendarWeekBlankDay($tmpDay->copy());
        $days[] = $day;
        $tmpDay->addDay(1);
        continue;
       }
       $day = new CalendarWeekDay($tmpDay->copy());//同じ月の中だったら日付を表示
       $days[] = $day;
       $tmpDay->addDay(1);
    }
    return $days;
  }
}