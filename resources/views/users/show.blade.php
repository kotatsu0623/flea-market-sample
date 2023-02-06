@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  [<a href="{{ route('users.edit') }}">編集</a>]
  <h2>名前</h2>
  <div>{{ $user->name }}</div>
  <h2>プロフィール画像</h2>
  @if($user->image !== '')
    <img src="{{ asset('storage/' . $user->image) }}">
  @else
    <img src="{{ asset('images/no_image.png') }}">
  @endif
  <a href="{{ route('users.edit_image') }}">画像を変更</a>
  @if($user->profile !== '')
    <p>{{ $user->profile }}</p>
  @else
    <p>プロフィールが設定されていません。</p>
  @endif
  <h2>出品数</h2>
  <p>{{$items}}</p>
  
  <h2>購入履歴</h2>
  @forelse($user->orderItems as $item)
    <dl>
      <dt>商品名</dt>
      <dd><a href="{{ route('items.show', $item->id) }}">{{$item->name}}</a></dd>
      <dt>価格</dt>
      <dd>{{$item->price}}円</dd>
      <dt>出品者名</dt>
      <dd>{{$item->user->name}}</dd>
    </dl>
  @empty
    <p>購入商品はありません</p>
  @endforelse
  
 @endsection