<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\MealController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\front\AuthController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DepositeController;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        Route::get('/deposite', [DepositeController::class, 'index'])->name('deposite.index');
        Route::post('/deposite', [DepositeController::class, 'store'])->name('deposite.store');
        Route::delete('/deposite/{deposites}', [DepositeController::class, 'destroy'])->name('deposite.delete');

        //meal
        Route::get('/meal', [MealController::class, 'index'])->name('meal.index');
        Route::post('/meal', [MealController::class, 'store'])->name('meal.store');
        Route::delete('/meal/{meal}', [MealController::class, 'destroy'])->name('meal.delete');

        //users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::delete('/users/{users}', [UserController::class, 'destroy'])->name('users.delete');
        //details last month
        Route::get('/last-month-details', [HomeController::class, 'details'])->name('lastmonth.details');
    });
});
Route::get('/', [AuthController::class, 'login'])->name('account.login');
Route::group(['prefix' => '/'], function () {
    Route::group(['middleware' => 'member.guest'], function () {
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'member.auth'], function () {
        Route::get('/users-profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::get('/last-month-meal-details', [AuthController::class, 'meals'])->name('account.meals');
        Route::get('/last-month-deposite-details', [AuthController::class, 'deposite'])->name('account.deposite');
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
    });
});


