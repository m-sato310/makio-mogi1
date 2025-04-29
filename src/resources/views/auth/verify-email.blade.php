@extends('layouts.app')

@section('title', 'メール認証')

@section('css')
<link rel="stylesheet" href="{{ asset('css/pages/verify.css') }}">
@endsection

@section('content')
<div class="verify-container">

    @if (session('status'))
        <div class="status-message">
            {{ session('status') }}
        </div>
    @endif

    <p class="verify-message">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    <form action="/verify-email/check" method="POST">
        @csrf
        <button class="verify-button" type="submit">認証はこちらから</button>
    </form>

    <form class="resend-form" action="/email/verification-notification" method="POST">
        @csrf
        <button class="resend-link" type="submit">認証メールを再送する</button>
    </form>
</div>
@endsection