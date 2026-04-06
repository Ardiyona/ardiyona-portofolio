<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
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
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('admin.categories.index');
        Route::post('/', [CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::put('/{id}', [CategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');
    });
});
