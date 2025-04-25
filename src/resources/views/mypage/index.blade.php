@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">

    <div class="profile-header">
        <div class="profile-left">
            @if ($user->profile_image)
            <img class="profile-image" src="{{ asset('storage/profile/' . $user->profile_image) }}" alt="プロフィール画像">
            @else
            <img class="profile-image" src="{{ asset('images/noimage.jpg') }}" alt="デフォルト画像">
            @endif
        </div>
        <div class="profile-center">
            <h2 class="user-name">{{ $user->name }}</h2>
        </div>
        <div class="profile-right">
            <a class="edit-button" href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>

    <div class="item-tab-wrapper">
        <div class="item-tab-nav">
            <a class="{{ $tab === 'sell' ? 'active' : '' }}" href="/mypage?tab=sell">出品した商品</a>
            <a class="{{ $tab === 'buy' ? 'active' : '' }}" href="/mypage?tab=buy">購入した商品</a>
        </div>
    </div>

    <hr class="item-tab-divider">

    <div class="item-list-container">
        <div class="item-grid">
            @foreach ($items as $item)
            <a class="item-card-link" href="/item/{{ $item->id }}">
                <div class="item-card">
                    <div class="item-image-wrapper">
                        <img src="{{ asset('storage/items/' . $item->image_path) }}" alt="{{ $item->name }}">
                        @if (isset($item->purchase))
                        <div class="sold-overlay">Sold</div>
                        @endif
                    </div>
                    <div class="item-name">{{ $item->name }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

</div>
@endsection