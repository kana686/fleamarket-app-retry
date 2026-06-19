<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/items/{item}', function ($item) { // 遷移確認用仮ルート
    return '商品詳細画面へ遷移成功！ (受け取ったID: '.$item.')';
})->name('items.show');

Route::get('/sell', function () { // 遷移確認用仮ルート
    return '出品画面への遷移確認';
})->name('sell');

Route::controller(RegisteredUserController::class)->group(function () {
    Route::get('/register', 'create')->name('register.create');
    Route::post('/register', 'store')->name('register.store');
});

Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login.create');
    Route::post('/login', 'store')->name('login.store');
});

Route::get('/', [ItemController::class, 'index'])->name('items.index');

Route::middleware(['auth'])->group(function () {
    Route::prefix('mypage')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('mypage');
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
    });
});
