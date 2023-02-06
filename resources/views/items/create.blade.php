@extends('layouts.logged_in')
 
@section('title', $title)
 
@section('content')
  <h1>{{ $title }}</h1>
  <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
      @csrf
      <div>
          <label>
            商品名:
            <input type="text" name="name">
          </label>
      </div>
      <div>
          <label>
              商品説明:
              <textarea name="description" cols="50" rows="20"></textarea>
          </label>
      </div>
      <div>
          <label>
            価格:
            <input type="number" name="price">
          </label>
      </div>
          <label>
            カテゴリー:
            <select name="category_id">
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
            </select>
          </label>
      <div>
          <label>
            画像を選択:
            <input type="file" name="image">
          </label>
      </div>
      <input type="submit" value="出品">
  </form>
@endsection