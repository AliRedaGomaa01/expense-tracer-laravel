<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\Auth\PasswordController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::match(['put', 'patch'], '/profile-password', [PasswordController::class, 'update'])->name('profile.password.update');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth:sanctum' , 'verified']], function () {
  Route::delete('expenses/delete-all', [ExpensesController::class , 'deleteAll'])->name('expenses.delete-all');
  Route::post('expenses/seed', [ExpensesController::class , 'seed'])->name('expenses.seed');
  Route::resource('expenses', ExpensesController::class)->only( 'create', 'store', 'update' , 'destroy');
  
  Route::resource('date', DateController::class)->only('index', 'show' );
});

require __DIR__.'/auth.php';