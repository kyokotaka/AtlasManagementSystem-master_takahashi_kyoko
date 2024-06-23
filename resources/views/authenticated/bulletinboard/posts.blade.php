@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        @foreach($post->subCategories as $subCategory)
          <span class="btn btn-info btn-sm">{{ $subCategory->sub_category }}</span>
        @endforeach
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{ $post->postComments->count() }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{$like->likeCounts($post->id)}}</span></p>
            <!--showメソッドの中にある$likeを使用し、それをlikeCountsに通す。引数にポストのidを持ってくることでそのidに何人いいねしているかをカウントできる。 -->
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}"></span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border">
    <div class=" m-4">
      <div class=""><a class="btn btn-info post_btn w-100" href="{{ route('post.input') }}" role="button">投稿</a></div>
      <div class="freeword_area">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <button type="submit" form="postSearchRequest" class="btn btn-info">検索</button>
      </div>
      <div class="like_mypost_btn">
      <input type="submit" name="like_posts" class="my_like_btn " value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="my_posts_btn " value="自分の投稿" form="postSearchRequest">
      </div>
      <div class="all_category">
        <p>カテゴリー検索</p>
      <ul>
        @foreach($categories as $key=>$category)
        <li class="main_categories" category_id="{{ $category->id }}">
            <div class="category">
              <!-- テェックボックスにレ点が入ったときにメニューが開く。$key+1があることで番号を変えることができidが被らない -->
              <input type="checkbox" id="{{'menu_bar' .$key+1}}">
              <label for="{{'menu_bar' .$key+1}}">{{ $category->main_category }}</label>
            <div class="sub_categories_list">
              <ul>
                @foreach($category->subCategories as $subcategory)
                <li>
                  <button type="submit" name="category_word" class="btn btn-link category_btn" value="{{ $subcategory->sub_category }}" form="postSearchRequest" >{{ $subcategory->sub_category }}</button>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
      </div>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection