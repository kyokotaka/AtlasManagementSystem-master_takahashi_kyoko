@extends('layouts.sidebar')

@section('content')
<div class="w-75 m-auto">
  <div class="w-100">
    <!-- カレンダーのタイトルを表示 -->
    <p>{{ $calendar->getTitle() }}</p>
    <!-- カレンダーの本体を表示 -->
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>
@endsection