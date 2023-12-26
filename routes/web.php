<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DepositeController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');

    });
    Route::group(['middleware' => 'admin.auth'], function () {

        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        Route::get('/deposite',[DepositeController::class,'index'])->name('deposite.index');

        //users
        Route::get('/users',[UserController::class,'index'])->name('users.index');
        Route::delete('/users/{users}',[UserController::class,'destroy'])->name('users.delete');



    });

});
