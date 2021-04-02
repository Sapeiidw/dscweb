<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');

Route::resource('user', UserController::class)->shallow();

require __DIR__.'/auth.php';
