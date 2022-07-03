<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api']], function () {
    Route::post('register' , [AuthController::class, 'register'])->name('user.register');
    Route::post('login', [AuthController::class, 'login'])->name('user.login');
    Route::post('checkToken', [AuthController::class, 'checkToken'])->name('user.checkToken');
});


Route::group(['middleware' => ['jwt']], function() {
    Route::post('logout', [AuthController::class, 'logout'])->name('user.logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('user.refresh');
    Route::post('authenticatedUser', [AuthController::class, 'authenticatedUser'])->name('user.authenticated');
    Route::post('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('user.dashboard');
});





