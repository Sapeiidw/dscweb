<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::view('/', 'welcome');
Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');

Route::middleware(['auth','verified'])->group(function () {
    Route::resource('user', UserController::class)->shallow();
    Route::resource('role', RoleController::class)->shallow();
    Route::resource('permission', PermissionController::class)->shallow();
    Route::resource('playlist', PlaylistController::class)->parameters(['playlist'=>'playlist:slug'])->shallow();
    Route::get('playlist/{playlist:slug}/episode-{video:episode}', [PlaylistController::class, "video"])->name('playlist.video');
    Route::resource('tag', TagController::class)->shallow();
    Route::resource('video', VideoController::class)->shallow();
});


