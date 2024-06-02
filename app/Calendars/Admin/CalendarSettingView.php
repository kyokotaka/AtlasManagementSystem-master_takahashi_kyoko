<?php
namespace App\Calendars\Admin;
use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarSettingView{
  private $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');//carbonクラスを通ってY年n月のフォーマットでタイトルを表示
  }

  public function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border adjust-table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border">土</th>';
    $html[] = '<th class="border">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';//ここまででHTMLの記述をしている
    $weeks = $this->getWeeks();//この表示をgetWeeksで使用する

    foreach($weeks as $week){//ループさせて１週間を表示
      $html[] = '<tr class="'.$week->getClassName().'">';//週カレンダーの処理
      $days = $week->getDays();//週カレンダーから日カレンダーのオブジェクトを取得
      foreach($days as $day){//日カレンダーオブジェクトをループさせながら、クラス名を出力し、<td>の中に日カレンダーを出力。
        $startDay = $this->carbon->format("Y-m-01");
        $toDay = $this->carbon->format("Y-m-d");

       if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<td class="past-day border">';
        }else{
          $html[] = '<td class="border '.$day->getClassName().'">';
        }
        $html[] = $day->render();
        $html[] = '<div class="adjust-area">';
        if($day->everyDay()){
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][1]" type="text" form="reserveSetting" value="'.$day->onePartFrame($day->everyDay()).'" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][2]" type="text" form="reserveSetting" value="'.$day->twoPartFrame($day->everyDay()).'" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][3]" type="text" form="reserveSetting" value="'.$day->threePartFrame($day->everyDay()).'" disabled></p>';
          }else{
            $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][1]" type="text" form="reserveSetting" value="'.$day->onePartFrame($day->everyDay()).'"></p>';
            $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][2]" type="text" form="reserveSetting" value="'.$day->twoPartFrame($day->everyDay()).'"></p>';
            $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="reserve_day['.$day->everyDay().'][3]" type="text" form="reserveSetting" value="'.$day->threePartFrame($day->everyDay()).'"></p>';
          }
        }
        $html[] = '</div>';
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="'.route('calendar.admin.update').'" method="post" id="reserveSetting">'.csrf_field().'</form>';
    return implode("", $html);
  }

  protected function getWeeks(){//ループさせる目的の$weeksの処理を決めるのが目的
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();//月初めを表示
    $lastDay = $this->carbon->copy()->lastOfMonth();//月終わりまで表示
    $week = new CalendarWeek($firstDay->copy());//１週目と1日を取得
    $weeks[] = $week;//ここまでで一週目を表示
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();//月初めから７日間を表示させ次の週の日付を取得する
    while($tmpDay->lte($lastDay)){//月末までループ
      $week = new CalendarWeek($tmpDay, count($weeks));//何週目かをカレンダーオブジェクトに伝える。オブジェクト＝メソッドをひとまとめにしたもの
      $weeks[] = $week;//viewに表示
      $tmpDay->addDay(7);//７日足す。これ翌週に移動できる
    }
    return $weeks;
  }
}