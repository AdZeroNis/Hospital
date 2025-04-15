<?php

use App\Http\Controllers\Api\Doctor\DoctorController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Doctor\InvoicesController;
use App\Http\Controllers\Api\Doctor\SurgeriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/doctor', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('doctor')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/surgeries-list', [SurgeriesController::class, 'getSurgeries']);
        Route::get('/surgeries/{id}', [SurgeriesController::class, 'detailsSurgery']);
        Route::get('/invoices', [InvoicesController::class, 'invoices']);
    });

});
