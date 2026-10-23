<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::post('/giris', [LoginController::class, 'login'])->middleware('throttle:10,1')->name('login');
Route::post('/cikis', [LoginController::class, 'logout'])->name('logout');
Route::resource('posts', PostController::class)->except(['index']);
Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->middleware('throttle:60,1')->name('posts.like');
