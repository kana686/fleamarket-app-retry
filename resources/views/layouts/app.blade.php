<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECHフリマ</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <header>
        <div class="header-logo">
            <img src="{{ asset('images/coachtech-logo-header.png') }}" alt="COACHTECH">
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>