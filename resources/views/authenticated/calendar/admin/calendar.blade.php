@extends('layouts.sidebar')

@section('content')
<div class="w-75 m-auto reserve">
  <div class="w-100 ">
    <!-- カレンダーのタイトルを表示 -->
    <p style="text-align: center">{{ $calendar->getTitle() }}</p>
    <!-- カレンダーの本体を表示 -->
    <p>{!! $calendar->render() !!}</p>
    
  </div>
</div>
@endsection