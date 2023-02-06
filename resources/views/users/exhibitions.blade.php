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
          <a href="{{ route('items.edit_image', $item) }}">画像編集</a>
        </div>
        
        <a href="{{ route('items.edit', $item) }}">編集</a>
        <form method="item" class="delete" action="{{ route('items.destroy', $item) }}">
          @csrf
          @method('delete')
          <input type="submit" value="削除">
        </form>
    @empty
        <p>出品している商品はありません。</p>
    @endforelse
  
@endsection