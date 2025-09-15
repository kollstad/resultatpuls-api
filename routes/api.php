<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


use App\Http\Controllers\Api\V1\{
    HealthController,
    DistrictController,
    ClubController,
    AthleteController,
    EventController,
    PerformanceController
};

Route::middleware('web')->group(function () {
    // CSRF-cookie til SPA
    Route::get('/sanctum/csrf-cookie', fn() => response()->noContent());
    // Login / Logout
    Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/auth/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
    // Returner pålogget bruker
    Route::get('/auth/me', fn(Request $r)=>$r->user())->middleware('auth:sanctum');
});

// Global ping (f.eks. /api/ping) – nyttig for en superlett helsesjekk uten prefix
Route::get('/ping', fn () => response()->json(['ok' => true, 'ts' => now()->toIso8601String()]));

Route::prefix('v1')->group(function () {
    // Lettvekts ping på /api/v1/ping
    Route::get('/ping', fn () => response()->json(['ok' => true, 'ts' => now()->toIso8601String()]));

    // Health
    Route::get('/health',       [HealthController::class, 'basic']);
    Route::get('/health/full',  [HealthController::class, 'full']);

    // Les
    Route::get('/districts',     [DistrictController::class,     'index']);
    Route::get('/clubs',         [ClubController::class,         'index']);
    Route::get('/athletes',      [AthleteController::class,      'index']);
    Route::get('/events',        [EventController::class,        'index']);
    Route::get('/performances',  [PerformanceController::class,  'index']);

    // Skriv – beskyttet
    Route::middleware(['auth:sanctum', 'throttle:write'])->group(function () {
        Route::post('/districts',     [DistrictController::class,     'store'])->middleware('abilities:districts:write');
        Route::post('/clubs',         [ClubController::class,         'store'])->middleware('abilities:clubs:write');
        Route::post('/athletes',      [AthleteController::class,      'store'])->middleware('abilities:athletes:write');
        Route::post('/events',        [EventController::class,        'store'])->middleware('abilities:events:write');
        Route::post('/performances',  [PerformanceController::class,  'store'])->middleware('abilities:performances:write');
    });
});
