@php
    $mode = $mode ?? 'edit';
@endphp

@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <h2>プロフィール設定</h2>

    <form action="{{ $mode === 'setup' ? '/register/profile' : '/mypage/profile' }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group image-upload-group">
            <div class="image-preview">
                @if (Auth::user()->profile_image)
                <img src="{{ asset('storage/profile/' . Auth::user()->profile_image) }}" alt="プロフィール画像">
                @else
                <img src="{{ asset('images/noimage.jpg') }}" alt="デフォルト画像">
                @endif
            </div>
            <div class="image-upload-button">
                <label for="profile_image">画像を選択する</label>
                <input type="file" name="profile_image" id="profile_image">
                @error('profile_image')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}">
            @error('name')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="zipcode">郵便番号</label>
            <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode', Auth::user()->zipcode) }}">
            @error('zipcode')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', Auth::user()->address) }}">
            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', Auth::user()->building) }}">
            @error('building')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group center">
            <button type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection