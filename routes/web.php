<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminCarController;
use App\Http\Middleware\AdminMiddleware;


Route::get('/', [CarController::class, 'index'])->name('home');


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');





Route::middleware('auth')->group(function () {


    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::patch('/profile/update', [AuthController::class, 'update'])->name('profile.update');

   
    Route::post('/car/{car}/rent', [CarController::class, 'storeRental'])->name('rentals.store');
    Route::delete('/rentals/{rental}/cancel', [CarController::class, 'cancelRental'])->name('rentals.cancel');

    Route::middleware(AdminMiddleware::class)->prefix('admin')->name('admin.')->group(function () {

        Route::get('/rentals', [CarController::class, 'allRentals'])->name('rentals');

        Route::patch('/rentals/{rental}/{status}', [CarController::class, 'updateRentalStatus'])->name('rentals.update');

        Route::resource('cars', AdminCarController::class);
        Route::resource('categories', CategoryController::class);
    });
});