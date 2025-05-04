<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthSystem;
use Illuminate\Support\Facades\Route;

// AUTH PROSES
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthSystem::class, 'register']);
    Route::post('/login', [AuthSystem::class, 'login']);
    Route::get('/logout', [AuthSystem::class, 'logout'])->middleware('auth:sanctum');
});
