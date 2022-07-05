<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Auth\RegisterController;

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
    Route::get('email-verification', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('checkToken', [AuthController::class, 'checkToken'])->name('user.checkToken');
});


Route::group(['middleware' => ['jwt']], function() {
    Route::post('logout', [AuthController::class, 'logout'])->name('user.logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('user.refresh');
    Route::post('authenticatedUser', [AuthController::class, 'authenticatedUser'])->name('user.authenticated');
    Route::post('dashboard', [DashboardController::class, 'index'])->name('user.dashboard')->middleware('verified');;
});



