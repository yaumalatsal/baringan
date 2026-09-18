<?php

use App\Http\Controllers\Api\MonitorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Liveness only, and deliberately public: the console must still be able to
// tell whether this application is up when the token is missing or wrong.
Route::get('/health', [MonitorController::class, 'health']);

// Everything that describes the inside of the install is behind the token.
Route::middleware(VerifyMonitorToken::class)->group(function () {
    Route::get('/monitor/services', [MonitorController::class, 'services']);
    Route::get('/monitor/metrics', [MonitorController::class, 'metrics']);
});
