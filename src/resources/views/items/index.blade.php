@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/items.css') }}">
@endsection

@section('content')
<div class="item-tab-wrapper">
    <div class="item-tab-nav">
        <a class="{{ $tab !== 'mylist' ? 'active' : '' }}" href="/?keyword={{ request('keyword') }}">おすすめ</a>
        <a class="{{ $tab === 'mylist' ? 'active' : '' }}" href="/?tab=mylist&keyword={{ request('keyword') }}">マイリスト</a>
    </div>
</div>

<div class="item-tab-divider"></div>

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
@endsection