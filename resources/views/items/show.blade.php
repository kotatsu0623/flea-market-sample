@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
    @if($item !== null)
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
        
        <p>説明：{{ $item->description }}</p>
        <a href="{{ route('items.confirm', $item) }}">購入する</a>
        
    @else
        <p>その商品はありません。</p>
    @endif
  
@endsection