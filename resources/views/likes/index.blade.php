@extends('layouts.logged_in')
 
@section('content')
  <h1>{{ $title }}</h1>
 
  <ul class="items">
      @forelse($like_items as $item)
          <li class="item like_item">
            <img src="{{ asset('storage/' . $item->image) }}">
            <p>{{ $item->description }}</p>
            <div class="item_body_main_comment">
              <p>商品名: {{ $item->name }} {{ $item->price }}円</p>
              <p>カテゴリ:{{ $item->category->name }}{{ $item->created_at }}</p>
            </div>
          </li>
      @empty
          <li>商品はありません。</li>
      @endforelse
  </ul>
@endsection