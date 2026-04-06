<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AuthController, CarController, CategoryController, RentalController};


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/cars', [CarController::class, 'index']);
Route::get('/cars/{id}', [CarController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
   
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

  
    Route::post('/rentals', [RentalController::class, 'store']); // Создать
    Route::get('/my-rentals', [RentalController::class, 'myRentals']); // Свои аренды
    Route::delete('/rentals/{id}/cancel', [RentalController::class, 'cancel']); // Отмена

   
    Route::middleware('admin')->group(function () {
        
        Route::post('/admin/cars', [CarController::class, 'store']);
        Route::put('/admin/cars/{id}', [CarController::class, 'update']);
        Route::delete('/admin/cars/{id}', [CarController::class, 'destroy']);

       
        Route::post('/admin/categories', [CategoryController::class, 'store']);
        Route::put('/admin/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy']);

        
        Route::get('/admin/rentals', [RentalController::class, 'index']); // Все аренды
        Route::patch('/admin/rentals/{id}/status', [RentalController::class, 'updateStatus']); // Подтверждение/Отклонение
    });
});