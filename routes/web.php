<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| 🌐 Public Routes
|--------------------------------------------------------------------------
*/
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
});

// 🛍 Publicly visible services (approved only)
Route::get('/services', [ServiceController::class, 'browse'])->name('services.index');

/*
|--------------------------------------------------------------------------
| 👑 Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        // 🏠 Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // 🧾 Pending Services Management
        Route::get('/services/pending', [AdminController::class, 'pendingServices'])->name('services.pending');
        Route::post('/services/{service}/approve', [AdminController::class, 'approveService'])->name('services.approve');
        Route::post('/services/{service}/reject', [AdminController::class, 'rejectService'])->name('services.reject');

        // 🧑‍🔧 Providers Management
        Route::get('/providers', [AdminController::class, 'providers'])->name('providers');
        Route::get('/providers/{provider}', [AdminController::class, 'viewProvider'])->name('providers.view');

        // 👥 Customers Management
        Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
        Route::get('/customers/{customer}', [AdminController::class, 'viewCustomer'])->name('customers.view');
    });

/*
|--------------------------------------------------------------------------
| 🧰 Provider Routes
|--------------------------------------------------------------------------
*/
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
            Route::get('/', [MessageController::class, 'indexList'])->name('messages.index');
            Route::get('/{bookingId}', [MessageController::class, 'index'])->name('messages.chat');
            Route::post('/{bookingId}', [MessageController::class, 'send'])->name('messages.send');
        });
    });

/*
|--------------------------------------------------------------------------
| 👤 Customer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->as('customer.')
    ->group(function () {
        // 🏠 Dashboard
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

        // 👤 Profile
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [CustomerController::class, 'updateProfile'])->name('profile.update');

        // 🔎 Browse & Book Services
        Route::get('/services', [CustomerController::class, 'browseServices'])->name('services');
        Route::post('/book-service/{service}', [BookingController::class, 'bookService'])->name('book.service');

        // 📅 My Bookings
        Route::get('/bookings', [CustomerController::class, 'bookings'])->name('bookings');

        // 💬 Messages
        Route::prefix('messages')->group(function () {
            Route::get('/', [MessageController::class, 'indexList'])->name('messages.index');
            Route::get('/{bookingId}', [MessageController::class, 'index'])->name('messages.chat');
            Route::post('/{bookingId}', [MessageController::class, 'send'])->name('messages.send');
        });
    });

/*
|--------------------------------------------------------------------------
| 🔐 Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
