<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;
use Reserve_setting_users;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            //dd($getPart,$getDate);
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request){
//dd($request);
        $day = $request->input('day');
        $part = $request->input('part');
        if ($part == "リモ1部") { //$reservePartに入っている数値が1と一致していたら
            $part = 1;
        } else if ($part == "リモ2部") { //$reservePartに入っている数値が2と一致していたら
            $part = 2;
        } else if ($part == "リモ3部") { //$reservePartに入っている数値が3と一致していたら
            $part = 3;
        }
        //$user = Auth::user();
        //dd($part,$day);
            $reserve_settings = ReserveSettings::where('setting_reserve', $day)->where('setting_part', $part)->first();
            //dd($reserve_settings);
            $reserve_settings->increment('limit_users');
            $reserve_settings->users()->detach(Auth::id());

            return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
        }
    
}