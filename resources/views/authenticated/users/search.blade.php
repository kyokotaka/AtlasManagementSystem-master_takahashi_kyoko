@extends('layouts.sidebar')

@section('content')
<!-- <p>ユーザー検索</p> -->
<div class="search_content w-100 d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class=" one_person">
      <div>
        <span class="tag">ID : </span><span>{{ $user->id }}</span>
      </div>
      <div><span class="tag">名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span class="tag">カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span class="tag">性別 : </span><span>男</span>
        @elseif($user->sex == 2)
        <span class="tag">性別 : </span><span>女</span>
        @else
        <span class="tag">性別 : </span><span>その他</span>
        @endif
      </div>
      <div>
        <span class="tag">生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span class="tag">権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span class="tag">権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span class="tag">権限 : </span><span>講師(英語)</span>
        @else
        <span class="tag">権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        @if($user->role == 4)
        <span class="tag">選択科目 :{{ $user->subjects->pluck('subject')->join(', ') }}</span>
        @endif
      </div>
    </div>
    @endforeach
  </div>
  <div class="search_area w-25 ">
    <div class="user_src">
      <div class="src_label">
        <span>検索</span>
      </div>
      <div>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div>
        <label>カテゴリ</label>
        <select form="userSearchRequest" name="category" class="name_id">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div>
        <label>並び替え</label>
        <select name="updown" form="userSearchRequest" class="change">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="search_sort">
        <label class="search_conditions">検索条件の追加</label>
        <div class="arrow_down"></div>
        <div class="search_conditions_inner">
          <div class="select_sex">
            <label>性別</label>
            <div class="sex_options">
            <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
            <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
            <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
          </div>
          </div>
          <div>
            <label>権限</label>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer">
            <label>選択科目</label>
            <div class="engineer_option">
            <!-- []をつけることで複数の値を送ることができる -->
            <div class="checkbox-item">
    <p>国語</p>
    <input type="checkbox" name="subject[]" form="userSearchRequest" value="1">
  </div>
  <div class="checkbox-item">
    <p>数学</p>
    <input type="checkbox" name="subject[]" form="userSearchRequest" value="2">
  </div>
  <div class="checkbox-item">
    <p>英語</p>
    <input type="checkbox" name="subject[]" form="userSearchRequest" value="3">
  </div>
          </div>
          </div>
        </div>
      </div>
      <div class="search_button">
           <input type="submit" name="search_btn" value="検索" form="userSearchRequest">
      </div>
      <div class="reset_btn">
        <input type="reset" value="リセット" form="userSearchRequest">
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
