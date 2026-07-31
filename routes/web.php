<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TechStackController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });

    Route::put('/profile', [ProfileController::class, 'update'])->name('admin.profile.update');

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/list', [UserController::class, 'list'])->name('admin.users.list');
        Route::get('/{id}', [UserController::class, 'show'])->name('admin.users.show');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/list', [CategoryController::class, 'list'])->name('admin.categories.list');
        Route::get('/all', [CategoryController::class, 'all'])->name('admin.categories.all');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('admin.categories.show');
        Route::post('/', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });

    Route::prefix('tech-stacks')->group(function () {
        Route::get('/', [TechStackController::class, 'index'])->name('admin.tech-stacks.index');
        Route::get('/list', [TechStackController::class, 'list'])->name('admin.tech-stacks.list');
        Route::get('/all', [TechStackController::class, 'all'])->name('admin.tech-stacks.all');
        Route::get('/{id}', [TechStackController::class, 'show'])->name('admin.tech-stacks.show');
        Route::post('/', [TechStackController::class, 'store'])->name('admin.tech-stacks.store');
        Route::put('/{id}', [TechStackController::class, 'update'])->name('admin.tech-stacks.update');
        Route::delete('/{id}', [TechStackController::class, 'destroy'])->name('admin.tech-stacks.destroy');
    });

    Route::prefix('project')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('admin.project.index');
        Route::get('/list', [ProjectController::class, 'list'])->name('admin.project.list');
        Route::get('/{id}', [ProjectController::class, 'show'])->name('admin.project.show');
        Route::post('/', [ProjectController::class, 'store'])->name('admin.project.store');
        Route::put('/{id}', [ProjectController::class, 'update'])->name('admin.project.update');
        Route::delete('/{id}', [ProjectController::class, 'destroy'])->name('admin.project.destroy');
    });

    Route::prefix('experience')->group(function () {
        Route::get('/', [ExperienceController::class, 'index'])->name('admin.experience.index');
        Route::get('/list', [ExperienceController::class, 'list'])->name('admin.experience.list');
        Route::get('/{id}', [ExperienceController::class, 'show'])->name('admin.experience.show');
        Route::post('/', [ExperienceController::class, 'store'])->name('admin.experience.store');
        Route::put('/{id}', [ExperienceController::class, 'update'])->name('admin.experience.update');
        Route::delete('/{id}', [ExperienceController::class, 'destroy'])->name('admin.experience.destroy');
    });
});
