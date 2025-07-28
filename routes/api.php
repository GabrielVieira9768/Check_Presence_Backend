<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PresenceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::get('/subjects', [StudentController::class, 'subjects']);
    Route::get('/subjects/{subject}/classes', [StudentController::class, 'classes']);
    Route::post('/presences/register', [StudentController::class, 'register']);
    Route::post('/read-qr-from-image', [StudentController::class, 'read']);
});
