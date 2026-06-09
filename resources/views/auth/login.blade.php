<x-app-layout>
    <x-slot name="title">ログイン</x-slot>

    <div class="login-container">
        <h1>ログイン</h1>

        <form action="{{ route('login.store') }}" method="POST" novalidate>
            @csrf

            <x-input-field name="email" label="メールアドレス" type="email" />
            <x-input-field name="password" label="パスワード" type="password" />

            <x-primary-button>ログインする</x-primary-button>
        </form>

        <div class="link-wrapper">
            <a href="{{ route('register.create') }}">会員登録はこちら</a>
        </div>
    </div>
</x-app-layout>