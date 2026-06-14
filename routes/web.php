<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return '登録成功！';
});

Route::get('/', function () { // 遷移確認用仮ルート
    $items = [
        (object) ['id' => 1, 'name' => '商品名1', 'img_url' => 'sample1.jpg'],
        (object) ['id' => 2, 'name' => '商品名2', 'img_url' => 'sample2.jpg'],
    ];

    return view('items.index', compact('items'));
})->name('items.index');

Route::get('/items/{item}', function ($item) { // 遷移確認用仮ルート
    return '商品詳細画面へ遷移成功！ (受け取ったID: '.$item.')';
})->name('items.show');

Route::get('/mypage', function () { // 遷移確認用仮ルート
    return 'マイページ画面へ遷移確認用';
})->name('mypage');

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
