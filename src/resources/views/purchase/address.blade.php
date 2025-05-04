@extends('layouts.app')

@section('title', '送付先の変更')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/auth.css') }}">
@endsection

@section('content')
<div class="register-container">
    <h2>住所の変更</h2>
    <form action="/purchase/address/{{ $item->id }}" method="POST">
        @csrf
        <input type="hidden" name="payment_method" value="{{ old('payment_method') ?? $payment_method ?? '' }}">

        <div class="form-group">
            <label for="zipcode">郵便番号</label>
            <input type="text" name="zipcode" id="zipcode" value="{{ old('zipcode') }}">
            @error('zipcode')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}">
            @error('address')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building') }}">
            @error('building')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection