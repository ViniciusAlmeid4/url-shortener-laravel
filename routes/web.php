<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\UserController;

Route::get('/login', [LoginController::class, 'create'])->name('login');

Route::post('/login', [LoginController::class, 'store'])->name('postLogin');

Route::get('/register', [UserController::class, 'create'])->name('register');

Route::post('/register', [UserController::class, 'store'])->name('postRegister');

Route::get('/', [ShortUrlController::class, 'index'])->name('home')->middleware('auth');

Route::post('/shorten/', [ShortUrlController::class, 'store'])->middleware('auth')->name('storeUrl');

Route::get('/shorten/{code}', [ShortUrlController::class, 'showByCode'])->name('showByCode');

Route::post('/shorten/{code}', [ShortUrlController::class, 'checkWithPassword'])->name('checkWithPassword');

Route::delete('/shorten/{code}', [ShortUrlController::class, 'destroy'])->name('destroyUrl');

Route::get('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');
