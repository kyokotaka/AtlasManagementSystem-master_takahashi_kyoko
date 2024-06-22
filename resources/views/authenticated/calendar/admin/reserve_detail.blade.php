@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{$date}}日</span><span class="ml-3">{{$part}}部</span></p>
    <div class="h-auto  border detail_back">
      <table class="reserve_users">
        <tr class="reserve_detail_title text-center">
          <th class="w-5">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        @foreach($reservePersons as $reservePerson)
        <!-- データベースからReserveSettingsの情報が持ってこられている(ただし、どんなユーザーかまではわからない) -->
        @foreach($reservePerson->users as $user)
        <!-- ユーザーの情報をforeachさせたいため$reservePersonからusersのリレーションを使い持ってくる -->
        <tr class="reserve_detail text-center">
          <td class="w-25">{{$user->id}}</td>
          <td class="w-25">{{$user->over_name}}{{$user->under_name}}</td>
          <td class="w-25">リモート</td>
          @endforeach
          @endforeach
        </tr>
      </table>
    </div>
  </div>
</div>
@endsection