<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TechStacksController;
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

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/list', [UserController::class, 'list'])->name('admin.users.list');
        Route::get('/{id}', [UserController::class, 'show'])->name('admin.users.show');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('admin.categories.index');
        Route::get('/list', [CategoriesController::class, 'list'])->name('admin.categories.list');
        Route::get('/{id}', [CategoriesController::class, 'show'])->name('admin.categories.show');
        Route::post('/', [CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::put('/{id}', [CategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');
    });

    Route::prefix('tech-stacks')->group(function () {
        Route::get('/', [TechStacksController::class, 'index'])->name('admin.tech-stacks.index');
        Route::get('/list', [TechStacksController::class, 'list'])->name('admin.tech-stacks.list');
        Route::get('/{id}', [TechStacksController::class, 'show'])->name('admin.tech-stacks.show');
        Route::post('/', [TechStacksController::class, 'store'])->name('admin.tech-stacks.store');
        Route::put('/{id}', [TechStacksController::class, 'update'])->name('admin.tech-stacks.update');
        Route::delete('/{id}', [TechStacksController::class, 'destroy'])->name('admin.tech-stacks.destroy');
    });
});
