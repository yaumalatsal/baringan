<?php

use App\Http\Controllers\Api\MonitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Monitoring endpoints — public, no auth required
Route::get('/health', [MonitorController::class, 'health']);
Route::get('/monitor/services', [MonitorController::class, 'services']);
Route::get('/monitor/metrics', [MonitorController::class, 'metrics']);
