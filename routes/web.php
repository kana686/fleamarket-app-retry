<?php

use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return '登録成功！';
});

Route::get('/login', function () {
    return 'ログイン画面へようこそ！';
});

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
