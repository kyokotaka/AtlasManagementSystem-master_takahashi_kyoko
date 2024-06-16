@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>
<div class="modal js-modal" id="modal" >
    <div class="modal__bg js-modal-close"></div>
    <div class="modal-content">
      <form method="POST" action="{{ route('deleteParts') }}">
        <div class="w-100">
          <div class="modal-body">
            <div class="modal-body-day w-50 m-auto">
              
              <input type="text" name="day" class="form-control w-100" readonly>
            </div>
            <div class="modal-body-part w-50 m-auto">
              <input type="text" name="part" class="form-control w-100" readonly>
            </div>
          </div>
          <div class="w-50 m-auto cancel-modal-btn d-flex">
            <button type="button" class="btn btn-primary js-modal-close" data-dismiss="modal">閉じる</button>
            <button type="submit" class="btn btn-danger">キャンセル</button>
          </div>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
@endsection