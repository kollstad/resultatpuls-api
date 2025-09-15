<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{
    DistrictController,
    ClubController,
    AthleteController,
    EventController,
    PerformanceController
};

    Route::get('/ping', fn () => response()->json(['ok' => true, 'ts' => now()->toIso8601String()]));

    Route::prefix('v1')->group(function () {
        // Enkle helse-sjekk
        Route::get('/ping', fn () => response()->json(['ok' => true, 'ts' => now()->toIso8601String()]));

        // Les
        Route::get('/districts',   [DistrictController::class, 'index']);
        Route::get('/clubs',       [ClubController::class, 'index']);
        Route::get('/athletes',    [AthleteController::class, 'index']);
        Route::get('/events',      [EventController::class, 'index']);
        Route::get('/performances',[PerformanceController::class, 'index']);

        Route::middleware(['auth:sanctum','throttle:write'])->group(function () {
            Route::post('/districts',    [DistrictController::class, 'store'])->middleware('abilities:districts:write');
            Route::post('/clubs',        [ClubController::class, 'store'])->middleware('abilities:clubs:write');
            Route::post('/athletes',     [AthleteController::class, 'store'])->middleware('abilities:athletes:write');
            Route::post('/events',       [EventController::class, 'store'])->middleware('abilities:events:write');
            Route::post('/performances', [PerformanceController::class, 'store'])->middleware('abilities:performances:write');
});

    });
