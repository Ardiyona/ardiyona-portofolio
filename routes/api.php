<?php

use App\Http\Controllers\api\ExperienceController;
use App\Http\Controllers\api\TechStackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('project')->group(function() {
    Route::get('/', [ExperienceController::class, 'getAll']);
});

Route::prefix('tech-stack')->group(function() {
    Route::get('/', [TechStackController::class, 'getAll']);
});

Route::prefix('experience')->group(function() {
    Route::get('/', [ExperienceController::class, 'getAll']);
});
