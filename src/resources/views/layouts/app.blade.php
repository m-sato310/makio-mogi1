<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'フリマアプリ')</title>

    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/base/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout/app.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <a href="/"><img class="logo-img" src="{{ asset('images/logo.svg') }}" alt="ロゴ"></a>
            </div>

            @if (!(Request::is('login') || Request::is('register') || Request::is('verify-email')))
                <div class="header-center">
                    <form action="/" method="GET">
                        <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                    </form>
                </div>
            @endif

            <div class="header-right">
                @if (Request::is('login') || Request::is('register') || Request::is('verify-email'))

                @else
                    @auth
                        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                        <a href="/mypage">マイページ</a>
                        <a class="sell-link" href="/sell">出品</a>
                        <form class="hidden" id="logout-form" action="/logout" method="POST">
                            @csrf
                        </form>
                    @endauth

                    @guest
                        <a href="/login">ログイン</a>
                        <a href="/mypage">マイページ</a>
                        <a class="sell-link" href="/sell">出品</a>
                    @endguest
                @endif
            </div>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>