<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'COACHTECHフリマ' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <header class="header">
        <div class="header-logo">
            <img src="{{ asset('images/coachtech-logo-header.png') }}" alt="COACHTECH">
        </div>

        @if (!request()->routeIs('register.create', 'login.create'))
            <div class="header-right">
                <x-search-form action="{{ route('items.index') }}" />
                <x-header-nav />
            </div>
        @endif
    </header>

    <main>
        <x-flash-message />
        {{ $slot }}
    </main>

</body>
</html>