@extends('layouts.app')

@section('title', 'ログイン')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
@endsection

@section('content')
<div class="register-container">
    <h2>ログイン</h2>

    <form action="/login" method="POST" novalidate>
        @csrf

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
            @error('email')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password">
            @error('password')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit">ログインする</button>
        </div>

        <div class="form-link">
            <a href="/register">会員登録はこちら</a>
        </div>
    </form>
</div>
@endsection