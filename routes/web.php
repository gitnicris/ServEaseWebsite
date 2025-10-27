<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;

// 🌐 Public Pages
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/services', 'services')->name('services.index');
    Route::get('/messages', 'messages')->name('messages');
    Route::get('/about', 'about')->name('about');
});

// 👑 Admin Routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });

// 🧰 Provider Routes
Route::middleware(['auth', 'role:provider'])
    ->prefix('provider')
    ->as('provider.')
    ->group(function () {
        Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [ProviderController::class, 'profile'])->name('profile');
        Route::put('/profile', [ProviderController::class, 'updateProfile'])->name('updateProfile'); // ✅ FIXED
        

        // ✅ Service CRUD handled by ProviderController
        Route::get('/services', [ProviderController::class, 'services'])->name('services');
        Route::post('/services/store', [ProviderController::class, 'store'])->name('store');
        Route::get('/services/{service}/edit', [ProviderController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ProviderController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ProviderController::class, 'destroy'])->name('services.destroy');
    });


// 👤 Customer Routes
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->as('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    });

// 🔐 Authentication Routes
require __DIR__ . '/auth.php';
