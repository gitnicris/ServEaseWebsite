<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;

// 🌐 Public Pages
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/services', 'services')->name('services.index');
    Route::get('/about', 'about')->name('about');
});

// 👑 Admin Routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });

// 🧰 PROVIDER ROUTES
Route::middleware(['auth', 'role:provider'])
    ->prefix('provider')
    ->as('provider.')
    ->group(function () {
        // Dashboard & Profile
        Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [ProviderController::class, 'profile'])->name('profile');
        Route::put('/profile', [ProviderController::class, 'updateProfile'])->name('updateProfile');

        // ✅ Services Management
        Route::get('/services', [ProviderController::class, 'services'])->name('services');
        Route::post('/services/store', [ProviderController::class, 'store'])->name('store');
        Route::get('/services/{service}/edit', [ProviderController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ProviderController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ProviderController::class, 'destroy'])->name('services.destroy');

        // 📅 Bookings
        Route::get('/bookings', [BookingController::class, 'providerBookings'])->name('bookings');

        // 💬 Messaging (Provider side)
        Route::prefix('messages')->group(function () {
            Route::get('/', [MessageController::class, 'indexList'])->name('messages.index'); // 🧩 list of customers
            Route::get('/{bookingId}', [MessageController::class, 'index'])->name('messages.chat'); // 🗨 open chat
            Route::post('/{bookingId}', [MessageController::class, 'send'])->name('messages.send'); // 📤 send message
        });
    });

// 👤 CUSTOMER ROUTES
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->as('customer.')
    ->group(function () {
        // Dashboard & Profile
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('updateProfile');

        // ✅ Browse & Book Services
        Route::get('/services', [CustomerController::class, 'browseServices'])->name('services');
        Route::get('/bookings', [CustomerController::class, 'bookings'])->name('bookings');
        Route::post('/book-service/{service}', [BookingController::class, 'bookService'])->name('book.service');

        // 💬 Messaging (Customer side)
        Route::prefix('messages')->group(function () {
            Route::get('/', [MessageController::class, 'indexList'])->name('messages.index'); // 🧩 list of providers
            Route::get('/{bookingId}', [MessageController::class, 'index'])->name('messages.chat'); // 🗨 open chat
            Route::post('/{bookingId}', [MessageController::class, 'send'])->name('messages.send'); // 📤 send message
        });
    });

// 🔐 Authentication Routes
require __DIR__ . '/auth.php';
