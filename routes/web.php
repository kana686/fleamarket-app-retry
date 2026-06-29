<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::controller(RegisteredUserController::class)->group(function () {
    Route::get('/register', 'create')->name('register.create');
    Route::post('/register', 'store')->name('register.store');
});

Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login.create');
    Route::post('/login', 'store')->name('login.store');
});

Route::controller(ItemController::class)->group(function () {
    Route::get('/', 'index')->name('items.index');
    Route::get('/items/{item}', 'show')->name('items.show');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('mypage')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('mypage');
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
    });

    Route::prefix('sell')->controller(ItemController::class)->group(function () {
        Route::get('/', 'create')->name('sell.create');
        Route::post('/', 'store')->name('sell.store');
    });

    Route::prefix('items')->controller(LikeController::class)->group(function () {
        Route::post('/{id}/like', 'store')->name('like.store');
        Route::delete('/{id}/like', 'destroy')->name('like.destroy');
    });

    Route::prefix('purchase')->controller(PurchaseController::class)->group(function () {
        Route::get('/{item}', 'show')->name('purchases.checkout');
        Route::post('/{item}', 'store')->name('purchases.store');
        Route::get('/address/{item}', 'edit')->name('address.edit');

        Route::get('/success/{item}', 'success')->name('purchases.success');
    });
});

Route::middleware('throttle:10,1')->controller(CommentController::class)->group(function () {
    Route::post('/{item}/comments', 'store')->name('comments.store');
});
