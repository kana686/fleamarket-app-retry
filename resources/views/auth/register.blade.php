@extends('layouts.app')

@section('content')
<div class="register-container">
    <h1>会員登録</h1>

    <form action="/register" method="POST">
        @csrf

        {{-- コンポーネントを呼び出し --}}
        <x-input-field name="name" label="ユーザー名" type="text" />
        <x-input-field name="email" label="メールアドレス" type="email" />
        <x-input-field name="password" label="パスワード" type="password" />
        <x-input-field name="password_confirmation" label="確認用パスワード" type="password" />

        <x-primary-button>登録する</x-primary-button>
    </form>

    <a href="/login">ログインはこちら</a>
</div>
@endsection