<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthSystem;
use Illuminate\Support\Facades\Route;

// AUTH PROSES
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthSystem::class, 'register']);
    Route::post('/login', [AuthSystem::class, 'login']);
});

Route::post('/test', function(Request $request){
    $data = $request->validate([
        "name" => 'string',
        "age" => 'string'
    ]);

    return response()->json([
        "message" => "Post success",
        "data" => $data
    ]);
});