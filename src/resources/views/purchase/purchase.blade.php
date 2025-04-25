@extends('layouts.app')

@section('title', '商品購入')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <form action="/purchase/{{ $item->id }}" method="POST" id="purchase-form">
        @csrf
        <input type="hidden" name="zipcode" value="{{ $address['zipcode'] }}">
        <input type="hidden" name="address" value="{{ $address['address'] }}">
        <input type="hidden" name="building" value="{{ $address['building'] }}">
        <div class="purchase-wrapper">
            <div class="purchase-left">
                <div class="item-info-header">
                    <div class="item-image-mini">
                        <img src="{{ asset('storage/items/' . $item->image_path) }}" alt="{{ $item->name }}">
                    </div>
                    <div class="item-info-text">
                        <h2 class="item-name">{{ $item->name }}</h2>
                        <p class="item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>

                <hr class="section-divider">

                <div class="form-group">
                    <label for="payment_method">支払い方法</label>
                    <select name="payment_method" id="payment_method">
                        <option value="" disabled selected>選択してください</option>
                        <option value="コンビニ払い">コンビニ払い</option>
                        <option value="カード支払い">カード支払い</option>
                    </select>
                    @error('payment_method')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="section-divider">

                <div class="form-group delivery-group">
                    <label class="delivery-label">配送先</label>
                    <a class="change-address" href="/purchase/address/{{ $item->id }}">変更する</a>
                    <div class="delivery-info">
                        <p>〒{{ $address['zipcode'] }}</p>
                        <p>{{ $address['address'] }} {{ $address['building'] }}</p>
                    </div>
                </div>

                <hr class="section-divider">
            </div>

            <div class="purchase-right">
                <div class="summary-box">
                    <div class="summary-row">
                        <span class="summary-label">商品代金</span>
                        <span class="summary-value">¥<span id="price">{{ number_format($item->price) }}</span></span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">支払い方法</span>
                        <span class="summary-value" id="selected-method">未選択</span>
                    </div>
                </div>

                <button class="purchase-button" type="submit">購入する</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('payment_method');
        const display = document.getElementById('selected-method');

        select.addEventListener('change', function() {
            display.textContent = this.value;
        });
    });
</script>
@endpush