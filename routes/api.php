<?php

use App\Http\Controllers\AuthSystem;
use App\Http\Controllers\ReservationSystem;
use App\Http\Controllers\TableSystem;
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
        Route::get('/show-user', [UserSystem::class, 'show_user']); // select user by id
        Route::patch('/users-update', [UserSystem::class, 'update_user']); // update data user
        Route::patch('/update-role', [UserSystem::class, 'update_role']); // update role user
    });
});

// TABLE SYSTEM
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('table')->group(function () {
        Route::get('/show-table', [TableSystem::class, 'show_table']); // show table
        Route::post('/add-table', [TableSystem::class, 'add_table']); // tambah table baru
        Route::patch('/update-table', [TableSystem::class, 'update_table']); // update current table
        Route::delete('/delete-table/{id}', [TableSystem::class, 'delete_table']); // delete table 
    });
});
