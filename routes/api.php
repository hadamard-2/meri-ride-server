<?php

use App\Http\Controllers\DriverController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/check-driver-exists', [DriverController::class, 'checkDriverExists']);
Route::post('/login-driver', [DriverController::class, 'loginDriver']);
Route::post('/register-driver', [DriverController::class, 'registerDriver']);
