<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

//Login Route
Route::get('login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('action-login', [\App\Http\Controllers\LoginController::class, 'actionLogin'])->name('action-login');

Route::resource('timeline', \App\Http\Controllers\TimelineController::class);
