<?php

use App\Http\Controllers\api\ExperienceController;
use App\Http\Controllers\api\TechStackController;
use App\Http\Controllers\api\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['app.client', 'throttle:60,1'])->group(function () {
    Route::prefix('project')->group(function() {
        Route::get('/', [ProjectController::class, 'getAll']);
    });

    Route::prefix('tech-stack')->group(function() {
        Route::get('/', [TechStackController::class, 'getAll']);
    });

    Route::prefix('experience')->group(function() {
        Route::get('/', [ExperienceController::class, 'getAll']);
    });
});
