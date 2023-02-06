@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')

  <h1>{{ $title }}</h1>
  <a href="{{route('items.create')}}">新規出品</a>
    @forelse($items as $item)
        <p>{{ $item->orders->count() > 0 ? '売り切れ' : '販売中' }}</p>
        
        <p>{{ $item->description }}</p>
        <p>商品名: {{ $item->name }} {{ $item->price }}円</p>
        <p>カテゴリ:{{ $item->category->name }}{{ $item->created_at }}</p>
        <div class="item_body_main">
          <div class="item_body_main_img">
            @if($item->image !== '')
              <a href="{{ route('items.show', $item->id) }}">
                <img src="{{ asset('storage/' . $item->image) }}">
              </a>
            @else
              <img src="{{ asset('images/no_image.png') }}">
            @endif
            
          </div>
        </div>
        <a class="like_button">{{ $item->isLikedBy(Auth::user()) ? '★' : '☆' }}</a>
          <form method="post" class="like" action="{{ route('items.toggle_like', $item) }}">
            @csrf
            @method('patch')
        </form>
        
    @empty
        <p>出品している商品はありません。</p>
    @endforelse
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      /* global $ */
      $('.like_button').each(function(){
        $(this).on('click', function(){
          $(this).next().submit();
        });
      });
    </script>
  
@endsection
 
