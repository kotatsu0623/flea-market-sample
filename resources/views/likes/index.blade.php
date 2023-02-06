@extends('layouts.logged_in')
 
@section('content')
  <h1>{{ $title }}</h1>
      @forelse($like_items as $item)
          <div class="item like_item">
            <img src="{{ asset('storage/' . $item->image) }}">
            <p>商品説明: {{ $item->description }}</p>
            <p>商品名: {{ $item->name }}<br>価格: {{ $item->price }}円</p>
            <p>カテゴリ:{{ $item->category->name }}<br>{{ $item->created_at }}</p>
          </div>
      @empty
          <p>商品はありません。</p>
      @endforelse
@endsection