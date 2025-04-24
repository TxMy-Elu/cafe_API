<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContinentController;
use App\Http\Controllers\Api\DosetteController;
use App\Http\Controllers\Api\MarqueController;
use App\Http\Controllers\Api\PaysController;
use App\Http\Middleware\AuthenticateToken;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/marques', [MarqueController::class, 'index']);
Route::get('/continents', [ContinentController::class, 'index']);
Route::get('/pays', [PaysController::class, 'index']);
Route::get('/dosettes', [DosetteController::class, 'index']);
Route::get('/dosettes/{id}', [DosetteController::class, 'show']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/generate-token', [AuthController::class, 'generateToken']);

Route::middleware([CorsMiddleware::class])->group(function () {
    Route::middleware([AuthenticateToken::class])->group(function () {
        Route::post('/dosettes', [DosetteController::class, 'store']);
        Route::put('/dosettes/{id}', [DosetteController::class, 'update']);
        Route::delete('/dosettes/{id}', [DosetteController::class, 'destroy']);
    });
});