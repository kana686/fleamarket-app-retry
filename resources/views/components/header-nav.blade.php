<nav class="header-nav">
    @auth
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link">ログアウト</button>
        </form>
    @else
        <a href="{{ route('login.create') }}" class="nav-link">ログイン</a>
    @endauth

    <a href="{{ route('mypage') }}" class="nav-link">マイページ</a>
    <a href="{{ route('sell') }}" class="nav-link">出品</a>
</nav>