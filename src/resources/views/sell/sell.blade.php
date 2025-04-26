@extends('layouts.app')

@section('title', '商品出品')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/sell.css') }}">
@endsection

@section('content')
<div class="sell-form-wrapper">
    <h1>商品の出品</h1>

    <form action="/sell" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="image_path">商品画像</label>
            <div class="image-upload-box">
                <label for="image_path">画像を選択する</label>
                <input type="file" name="image_path" id="image_path">
            </div>
            @error('image_path')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <h2 class="section-title">商品の詳細</h2>
        <hr>

        <div class="form-group">
            <label>カテゴリー</label>
            <div class="category-tags">
                @foreach ($categories as $category)
                    <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}" {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : ''}}>
                    <label class="category-tag" for="category-{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
            @error('categories')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="condition">商品の状態</label>
            <select name="condition" id="condition">
                <option value="" disabled selected>選択してください</option>
                <option value="良好" {{ old('condition') == '良好' ? 'selected' : ''}}>良好</option>
                <option value="目立った傷や汚れなし" {{ old('condition') == '目立った傷や汚れなし' ? 'selected' : ''}}>目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり" {{ old('condition') == 'やや傷や汚れあり' ? 'selected' : ''}}>やや傷や汚れあり</option>
                <option value="状態が悪い" {{ old('condition') == '状態が悪い' ? 'selected' : ''}}>状態が悪い</option>
            </select>
            @error('condition')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <h2 class="section-title">商品名と説明</h2>
        <hr>

        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="brand">ブランド名</label>
            <input type="text" name="brand" id="brand" value="{{ old('brand') }}">
        </div>

        <div class="form-group">
            <label for="description">商品の説明</label>
            <textarea name="description" id="description" rows="5">{{ old('description') }}</textarea>
            @error('description')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price">販売価格(¥)</label>
            <input type="text" name="price" id="price" value="{{ old('price') }}">
            @error('price')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit">出品する</button>
        </div>

    </form>

</div>
@endsection