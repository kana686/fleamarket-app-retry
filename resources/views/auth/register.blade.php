<x-app-layout>
    <x-slot name="title">会員登録</x-slot>

    <div class="register-container">
        <h1>会員登録</h1>

        <form action="{{ route('register.store') }}" method="POST" novalidate>
            @csrf

            <x-input-field name="name" label="ユーザー名" type="text" />
            <x-input-field name="email" label="メールアドレス" type="email" />
            <x-input-field name="password" label="パスワード" type="password" />
            <x-input-field name="password_confirmation" label="確認用パスワード" type="password" />

            <x-primary-button>登録する</x-primary-button>
        </form>

        <div class="link-wrapper">
            <a href="{{ route('login.create') }}">ログインはこちら</a>
        </div>
    </div>
</x-app-layout>