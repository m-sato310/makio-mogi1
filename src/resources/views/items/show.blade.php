@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/item_detail.css') }}">
@endsection

@section('content')
<div class="item-detail-container">
    <div class="item-detail-wrapper">
        <div class="item-image-area">
            <img src="{{ asset('storage/items/' . $item->image_path) }}" alt="{{ $item->name }}">
            @if ($isPurchased)
            <div class="sold-badge">Sold</div>
            @endif
        </div>

        <div class="item-info-area">
            <h1 class="item-name">{{ $item->name }}</h1>
            <p class="brand">{{ $item->brand }}</p>
            <p class="price">¥{{ number_format($item->price) }}（税込）</p>

            <div class="item-icons">
                <div class="icon-wrapper">
                    <form action="/item/{{ $item->id }}/{{ $liked? 'unlike' : 'like' }}" method="POST">
                        @csrf
                        <button class="like-button" type="submit">
                            <img class="icon {{ $liked ? 'liked' : '' }}" src="{{ asset('images/like.png') }}" alt="星型アイコン">
                        </button>
                        <span>{{ $item->likes()->count() }}</span>
                    </form>
                </div>
                <div class="icon-wrapper">
                    <img class="icon" src="{{ asset('images/comment.png') }}" alt="吹き出し型アイコン">
                    <span>{{ $item->comments->count() }}</span>
                </div>
            </div>

            @if (!$isPurchased)
            <a class="buy-button" href="/purchase/{{ $item->id }}">購入手続きへ</a>
            @else
            <div class="buy-button sold">Sold</div>
            @endif

            <div class="item-description-section">
                <h2>商品説明</h2>
                <p>{{ $item->description }}</p>
            </div>

            <div class="item-meta-section">
                <h2>商品の情報</h2>
                <div class="item-category">
                    <p class="category-label">カテゴリー</p>
                    <div class="category-tags">
                        @foreach ($item->categories as $category)
                        <span class="category-tag">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="item-condition">
                    <p class="condition-label">商品の状態</p>
                    <p class="condition-value">{{ $item->condition }}</p>
                </div>
            </div>

            <div class="comments-section">
                <h2>コメント({{ $comments->count() }})</h2>
                @foreach ($comments as $comment)
                <div class="comment">
                    <div class="comment-header">
                        <img class="comment-user-icon" src="{{ asset('storage/profile/' . $comment->user->profile_image) }}" alt="{{ $comment->user->name }}">
                        <p class="comment-user">{{ $comment->user->name }}</p>
                    </div>
                    <p class="comment-content">{{ $comment->content }}</p>
                </div>
                @endforeach
            </div>

            <div class="comment-form">
                <h2>商品へのコメント</h2>
                <form action="/item/{{ $item->id }}/comment" method="POST">
                    @csrf
                    <textarea name="content" rows="3" required maxlength="255"></textarea>
                    @error('content')
                    <p class="error">{{ $message }}</p>
                    @enderror
                    <button type="submit">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection