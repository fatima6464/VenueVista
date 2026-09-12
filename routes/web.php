<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// ========== HOME ==========
Route::get('/', [HomeController::class, 'index'])->name('home');

// ========== AUTH ROUTES ==========
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== ADMIN ROUTES ==========
Route::prefix('admin')->middleware('is_admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/venues', [AdminController::class, 'venues'])->name('admin.venues');
    Route::get('/venues/add', [AdminController::class, 'addVenueForm'])->name('admin.venues.add');
    Route::post('/venues/add', [AdminController::class, 'addVenue']);
    Route::get('/venues/edit/{id}', [AdminController::class, 'editVenueForm'])->name('admin.venues.edit');
    Route::post('/venues/edit/{id}', [AdminController::class, 'editVenue']);
    Route::post('/venues/delete-image/{id}', [AdminController::class, 'deleteImage']);
    Route::post('/venues/delete/{id}', [AdminController::class, 'deleteVenue']);
    Route::post('/venues/toggle/{id}', [AdminController::class, 'toggleAvailability']);

    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::post('/bookings/confirm/{id}', [AdminController::class, 'confirmBooking']);
    Route::post('/bookings/cancel/{id}', [AdminController::class, 'cancelBooking']);
});

// ========== USER ROUTES ==========
Route::prefix('user')->middleware('is_user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/venues', [UserController::class, 'venues'])->name('user.venues');
    Route::get('/venues/book/{id}', [UserController::class, 'bookVenuePage'])->name('user.venues.book');
    Route::post('/venues/book/{id}', [UserController::class, 'bookVenue']);
    Route::get('/venues/{id}', [UserController::class, 'venueDetails'])->name('user.venues.show');
    Route::get('/my-bookings', [UserController::class, 'myBookings'])->name('user.bookings');
    Route::post('/bookings/cancel/{id}', [UserController::class, 'cancelBooking']);
});