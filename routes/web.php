<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return '登録成功！';
});

Route::get('/', function () {
    return 'ログイン成功！';
});

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register.create');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login.create');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
