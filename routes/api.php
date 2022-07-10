<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Auth\SocialAuthController;

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

	Route::post('register', [AuthController::class, 'register'])->name('user.register');
	Route::apiResource('movies', MovieController::class);
	Route::post('login', [AuthController::class, 'login'])->name('user.login');
	Route::get('email-verification', [VerificationController::class, 'verify'])->name('verification.verify');
	Route::get('authorize/google/redirect', [SocialAuthController::class, 'redirectToProvider'])->name('user.social.register');
	Route::get('authorize/google/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('user.social.callback');

Route::group(['middleware' => ['auth:api']], function () {
	Route::post('logout', [AuthController::class, 'logout'])->name('user.logout');
	Route::post('refresh', [AuthController::class, 'refresh'])->name('user.refresh');
	Route::post('authenticatedUser', [AuthController::class, 'authenticatedUser'])->name('user.authenticated');
	Route::post('checkToken', [AuthController::class, 'checkToken'])->name('user.checkToken');
	Route::post('dashboard', [DashboardController::class, 'index'])->name('user.dashboard')->middleware('verified');
});
