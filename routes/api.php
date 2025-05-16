<?php

use App\Http\Controllers\AuthSystem;
use App\Http\Controllers\MenuSystem;
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
        Route::get('/show-history-reserve', [ReservationSystem::class, 'show_histori_reservation']); // show history reservation user
    });


    // TABLE SYSTEM
    Route::prefix('table')->group(function () {
        Route::get('/show-table', [TableSystem::class, 'show_table']); // show table
        Route::post('/add-table', [TableSystem::class, 'add_table']); // tambah table baru
        Route::patch('/update-table', [TableSystem::class, 'update_table']); // update current table
        Route::delete('/delete-table', [TableSystem::class, 'delete_table']); // delete table 
    });

    // RESERVATION SYSTEM
    Route::prefix('reserve')->group(function () {
        Route::post('/add-reserve', [ReservationSystem::class, 'add_reserve']); // user booking table
        Route::get('/check-user', [ReservationSystem::class, 'check_in_reserve']); // check-in user by pelayan
        Route::get('/show-reservation', [ReservationSystem::class, 'show_user_reserve']); // show all active reservation
        Route::post('/done-reserve', [ReservationSystem::class, 'done_reservation']); // change status and close menu
        Route::post('/cancel-reserve', [ReservationSystem::class, 'cancel_reservation']); // cancel reservation
    });

    // MENU SYSTEM
   Route::prefix('menu')->group(function () {
        Route::get('/show-menu', [MenuSystem::class, 'show_menu']); // menampilkan menu
        Route::post('/add-menu', [MenuSystem::class, 'added_menu']); // menambahkan menu
        Route::patch('/update-menu/{id}', [MenuSystem::class, 'update_menu']); // update menu
        Route::delete('/delete-menu', [MenuSystem::class, 'delete_menu']); // hapus menu
    }); 
});