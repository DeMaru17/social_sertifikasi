<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

//Login Route
Route::get('login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('action-login', [\App\Http\Controllers\LoginController::class, 'actionLogin'])->name('action-login');
Route::get('logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// register route
Route::get('register', [\App\Http\Controllers\RegisterController::class, 'index'])->name('register');
Route::post('register', [\App\Http\Controllers\RegisterController::class, 'store'])->name('action-register');

Route::resource('posts', \App\Http\Controllers\PostsController::class);
Route::resource('user', \App\Http\Controllers\UserController::class);
Route::resource('comments', \App\Http\Controllers\CommentsController::class);
Route::get('/profile', [\App\Http\Controllers\UserController::class, 'showProfile'])->name('user.profile');
Route::post('/search-hashtag', [\App\Http\Controllers\SearchController::class, 'searchHashtag'])->name('search.hashtag');
