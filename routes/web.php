<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\BoomLiftController as AdminBoomLiftController;
use App\Http\Controllers\BoomLiftController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('boom-lifts.index');
});

Route::get('/boom-lifts', [BoomLiftController::class, 'index'])->name('boom-lifts.index');
Route::get('/boom-lifts/{boomLift}', [BoomLiftController::class, 'show'])->name('boom-lifts.show');
Route::get('/boom-lifts/{boomLift}/quotation', [BoomLiftController::class, 'quotation'])->name('boom-lifts.quotation');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');
    
    Route::get('/boom-lifts/{boomLift}/rent', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/boom-lifts/{boomLift}/rent', [RentalController::class, 'store'])->name('rentals.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('boom-lifts', AdminBoomLiftController::class);
});
