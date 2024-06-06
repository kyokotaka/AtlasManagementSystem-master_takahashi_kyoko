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

        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){//$startDay <= $day->everyDay()では月初めから今日まで、$toDay >= $day->everyDay()では今日から後の日を取得。$day->everyDayが範囲内にあるかを調べる
          $html[] = '<td class="calendar-td gray">';//今日からみて過去の日付だったら
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        $html[] = $day->render();

       if (in_array($day->everyDay(), $day->authReserveDay())) {
    // もしログインしているユーザーが予約をしていたら
    $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
    if ($reservePart == 1) { //$reservePartに入っている数値が1と一致していたら
        $reservePart = "リモ1部";
    } else if ($reservePart == 2) { //$reservePartに入っている数値が2と一致していたら
        $reservePart = "リモ2部";
    } else if ($reservePart == 3) { //$reservePartに入っている数値が3と一致していたら
        $reservePart = "リモ3部";
    }
    if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) { // 過去日の場合
        $html[] = '<p class="" style="font-size:12px;">' . $reservePart . '</p>';
        $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
      } else { // 未来日
        $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">' . $reservePart . '</button>';
        $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
      }
    } else if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) { // 過去日の場合
      $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
      } else { // 未来日
      $html[] = $day->selectPart($day->everyDay());
    }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

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