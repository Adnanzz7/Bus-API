<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\CorridorController;
use App\Http\Controllers\DriverController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1/')->group(function(){
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::prefix('bus')->group( function (){
        Route::get('/', [BusController::class, 'index']);
        Route::post('/', [BusController::class, 'store']);
        Route::get('/{id}', [BusController::class, 'show']);
        Route::put('/{id}', [BusController::class, 'update']);
        Route::delete('/{id}', [BusController::class, 'destroy']);
    });

    Route::prefix('driver')->group( function (){
        Route::get('/', [DriverController::class, 'index']);
        Route::post('/', [DriverController::class, 'store']);
        Route::get('/{driver_id}', [DriverController::class, 'show']);
        Route::put('/{driver_id}', [DriverController::class, 'update']);
        Route::delete('/{driver_id}', [DriverController::class, 'destroy']);
    });

    Route::prefix('corridor')->group( function (){
        Route::get('/', [CorridorController::class, 'index']);
        Route::post('/', [CorridorController::class, 'store']);
        Route::get('/{id}', [CorridorController::class, 'show']);
        Route::delete('/{id}', [CorridorController::class, 'destroy']);
    });
});