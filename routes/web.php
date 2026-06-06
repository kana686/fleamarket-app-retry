<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;

Route::get('/home', function () {
    return '登録成功！';
});

Route::get('/login', function () {
    return 'ログイン画面へようこそ！';
});

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);