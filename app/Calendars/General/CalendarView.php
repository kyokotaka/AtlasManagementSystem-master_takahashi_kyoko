<?php
namespace App\Calendars\General;
//予約画面にいく
use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';
      $days = $week->getDays();

      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<td class="calendar-td gray ' . $day->pastClassName() . '">';
        } else {
          $html[] = '<td class="calendar-td ' . $day->getClassName() . '">';
        }
        $html[] = $day->render();

       if (in_array($day->everyDay(), $day->authReserveDay())) {
    // もしログインしているユーザーが予約をしていたら
    $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;//予約しているデータを持ってくる
    if ($reservePart == 1) { //$reservePartに入っている数値が1と一致していたら
        $reservePart = "リモ1部";
    } else if ($reservePart == 2) { //$reservePartに入っている数値が2と一致していたら
        $reservePart = "リモ2部";
    } else if ($reservePart == 3) { //$reservePartに入っている数値が3と一致していたら
        $reservePart = "リモ3部";
    }//部抽出のためのif文は終わり
    if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) { // 過去日の場合かつ予約をしていた場合
      $html[] = '<p class="" style="font-size:12px;">' . $reservePart . '</p>';
      $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
  } else { // 未来日且つ予約をしていた場合
      $html[] = '<button type="button" class="btn btn-danger cancel-modal-open p-0 w-75" name="delete_date" style="font-size:12px" day='.$day->everyDay().' part= '. $reservePart .'>' . $reservePart . '</button>';//data-targetとidは必ず同じ名前にする。（その名前で探すため）
      $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
  }//予約のif文はここで終わり
  } else { 
    if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
      $html[] = '<p class="" style="font-size:12px;">受付終了</p>';
      $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
    }else{
      $html[] = $day->selectPart($day->everyDay());//予約をしていない未来日だったら
  }
  }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }//foreach(day)の終わり
      $html[] = '</tr>';
    }//foreach(week)の終わり
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }//renderの終わり

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();//月初めを取得
    $lastDay = $this->carbon->copy()->lastOfMonth();//月終わりを取得
    $week = new CalendarWeek($firstDay->copy());//１週目。1日目を指定している。
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){//7日足す処理を月末まで繰り返す
      $week = new CalendarWeek($tmpDay, count($weeks));//何週目かをカレンダーに伝えている
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
  
}