<?php

use App\Http\Controllers\AuthSystem;
use App\Http\Controllers\ReservationSystem;
use App\Http\Controllers\UserSystem;
use Illuminate\Support\Facades\Route;

// AUTH PROSES
Route::prefix('auth')->group(function () { // base path
    Route::post('/register', [AuthSystem::class, 'register']); // register user baru
    Route::post('/login', [AuthSystem::class, 'login']); // login ke aplikasi
    Route::delete('/logout', [AuthSystem::class, 'logout'])->middleware('auth:sanctum'); // logout system
});

// USER SELECTION
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () { // base path
        Route::get('/users/{id}', [UserSystem::class, 'user_by_id']); // select user by id
        Route::put('/users-update/{id}', [UserSystem::class, 'update_user']); // update data user
    });
});
