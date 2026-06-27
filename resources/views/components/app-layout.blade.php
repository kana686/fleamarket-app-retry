<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'COACHTECHフリマ' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    @php
        $searchRoute = request()->routeIs('mypage') ? route('mypage') : route('items.index');
    @endphp

    <header class="header">
        <div class="header-left">
            <div class="header-logo">
                <a href="{{ route('items.index') }}">
                    <img src="{{ asset('images/coachtech-logo-header.png') }}" alt="COACHTECH">
                </a>
            </div>
        </div>

        @if (!request()->routeIs('register.create', 'login.create'))
            <div class="header-center">
                <x-search-form action="{{ $searchRoute }}" />
            </div>

            <div class="header-right">
                <x-header-nav />
            </div>

            <button class="menu-toggle" aria-label="メニュー開閉">
                <span></span><span></span><span></span>
            </button>

            <nav class="mobile-nav">
                <div class="mobile-nav-inner">
                    <x-search-form action="{{ $searchRoute }}" />
                    <x-header-nav />
                </div>
            </nav>
        @endif
    </header>

    <main>
        <x-flash-message />
        {{ $slot }}
    </main>

</body>
</html>