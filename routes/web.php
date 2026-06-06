<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return '登録成功！';
});

Route::get('/login', function () {
    return 'ログイン画面へようこそ！';
});
