<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Provider\ProviderSettingsController;
use App\Http\Controllers\Customer\CustomerSettingsController;
use App\Http\Controllers\Auth\ForgotPasswordCodeController;
use App\Http\Controllers\Auth\ResetPasswordCodeController;
use App\Http\Controllers\PublicProviderController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
});

Route::get('/services', [ServiceController::class, 'browse'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/services/search', [ServiceController::class, 'search'])->name('services.search');

Route::get('/providers/{provider}/profile', [PublicProviderController::class, 'show'])
    ->name('providers.public-profile');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')->as('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Service Approvals
        Route::get('/services/pending', [AdminController::class, 'pendingServices'])->name('services.pending');
        Route::post('/services/{service}/approve', [AdminController::class, 'approveService'])->name('services.approve');
        Route::post('/services/{service}/reject', [AdminController::class, 'rejectService'])->name('services.reject');

        // Providers
        Route::get('/providers', [AdminController::class, 'providers'])->name('providers');
        Route::get('/providers/{provider}', [AdminController::class, 'viewProvider'])->name('providers.view');

        // Customers
        Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
        Route::get('/customers/{customer}', [AdminController::class, 'viewCustomer'])->name('customers.view');
    });

/*
|--------------------------------------------------------------------------
| Provider Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:provider'])
    ->prefix('provider')->as('provider.')
    ->group(function () {

        Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');

        // Profile
        Route::get('/profile', [ProviderController::class, 'profile'])->name('profile');
        Route::get('/edit-profile', [ProviderController::class, 'editProfile'])->name('edit-profile');
        Route::put('/profile', [ProviderController::class, 'updateProfile'])->name('updateProfile');

        // Services
        Route::get('/services', [ProviderController::class, 'services'])->name('services');
        Route::post('/services/store', [ProviderController::class, 'store'])->name('store');
        Route::get('/services/{service}/edit', [ProviderController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ProviderController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ProviderController::class, 'destroy'])->name('services.destroy');

        // Bookings
        Route::get('/bookings', [ProviderController::class, 'bookings'])->name('bookings');
        Route::get('/bookings/pending', [ProviderController::class, 'pendingBookings'])->name('pending');

        Route::post('/bookings/{booking}/approve', [ProviderController::class, 'approveBooking'])->name('bookings.approve');
        Route::post('/bookings/{booking}/reject', [ProviderController::class, 'rejectBooking'])->name('bookings.reject');

        // MESSAGING (Provider)
        Route::prefix('messages')->group(function () {
            Route::get('/', [MessageController::class, 'indexList'])->name('messages.index');
            Route::get('/{bookingId}', [MessageController::class, 'index'])->name('messages.chat');
            Route::post('/{bookingId}', [MessageController::class, 'send'])->name('messages.send');

            // 🔥 REQUIRED FOR YOUR CHAT FETCH
            Route::get('/{bookingId}/fetch', [MessageController::class, 'fetchMessages'])->name('messages.fetch');
        });

        // Settings
        Route::get('/settings', [ProviderSettingsController::class, 'index'])->name('settings');
        Route::put('/settings/update-account', [ProviderSettingsController::class, 'updateAccount'])->name('settings.updateAccount');
        Route::put('/settings/update-password', [ProviderSettingsController::class, 'updatePassword'])->name('settings.updatePassword');
        Route::delete('/settings/delete-account', [ProviderSettingsController::class, 'destroyAccount'])->name('settings.destroyAccount');
    });

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')->as('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

        // Profile
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [CustomerController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [CustomerController::class, 'updateProfile'])->name('profile.update');

        // Services & Bookings
        Route::get('/services', [CustomerController::class, 'browseServices'])->name('services');
        Route::post('/book-service/{service}', [BookingController::class, 'bookService'])->name('book.service');

        Route::get('/bookings', [CustomerController::class, 'bookings'])->name('bookings');
        Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');
        Route::patch('/bookings/{booking}/complete', [BookingController::class, 'completeBooking'])->name('bookings.complete');

        // MESSAGING (Customer)
        Route::prefix('messages')->group(function () {
            Route::get('/', [MessageController::class, 'indexList'])->name('messages.index');
            Route::get('/{bookingId}', [MessageController::class, 'index'])->name('messages.chat');
            Route::post('/{bookingId}', [MessageController::class, 'send'])->name('messages.send');

            // 🔥 REQUIRED FOR YOUR BLADE FETCH()
            Route::get('/{bookingId}/fetch', [MessageController::class, 'fetchMessages'])->name('messages.fetch');
        });

        // Settings
        Route::get('/settings', [CustomerSettingsController::class, 'index'])->name('settings');
        Route::put('/settings/update-account', [CustomerSettingsController::class, 'updateAccount'])->name('settings.updateAccount');
        Route::put('/settings/update-password', [CustomerSettingsController::class, 'updatePassword'])->name('settings.updatePassword');
        Route::delete('/settings/delete-account', [CustomerSettingsController::class, 'destroyAccount'])->name('settings.destroyAccount');
    });

/*
|--------------------------------------------------------------------------
| Authentication: Password Reset via Code
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [ForgotPasswordCodeController::class, 'showEmailForm'])->name('password.code.request');
Route::post('/forgot-password/send-code', [ForgotPasswordCodeController::class, 'sendCode'])->name('password.code.send');

Route::get('/forgot-password/verify', [ForgotPasswordCodeController::class, 'showVerifyForm'])->name('password.code.verify.form');
Route::post('/forgot-password/verify', [ForgotPasswordCodeController::class, 'verifyCode'])->name('password.code.verify');

Route::get('/reset-password-code', [ResetPasswordCodeController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password-code', [ResetPasswordCodeController::class, 'resetPassword'])->name('password.reset');

/*
|--------------------------------------------------------------------------
| Google Auth
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/choose-role', fn () => view('auth.choose-role'))->name('choose.role')->middleware('auth');
Route::post('/choose-role', [GoogleController::class, 'saveRole'])->name('choose.role.save');
Route::get('/set-role/{role}', [GoogleController::class, 'setRole'])->name('setRole');

/*
|--------------------------------------------------------------------------
| Reviews
|--------------------------------------------------------------------------
*/
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');


require __DIR__ . '/auth.php';
