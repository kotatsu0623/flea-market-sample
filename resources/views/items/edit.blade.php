@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>
    <form method="POST" action="{{ route('items.update', $item) }}">
        @csrf
        @method('patch')
        <div>
            <label>
              商品名:
              <input type="text" name="name" value="{{ $item->name }}">
            </label>
        </div>
        <div>
            <label>
              商品説明:
              <textarea name="description" cols="50" rows="20">{{ $item->description }}</textarea>
            </label>
        </div>
        <div>
            <label>
              価格:
              <input type="number" name="price" value="{{ $item->price }}">
            </label>
        </div>
            <label>
              カテゴリー:
              <select name="category_id">
              @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id === $item->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
              @endforeach
              </select>
            </label>
        <input type="submit" value="出品">
    </form>
@endsection