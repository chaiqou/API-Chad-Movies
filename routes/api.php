<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\Auth\SocialAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group whic
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

	Route::post('register', [AuthController::class, 'register'])->name('user.register');
	Route::post('login', [AuthController::class, 'login'])->name('user.login');
	Route::get('email-verification', [VerificationController::class, 'verify'])->name('verification.verify');
	Route::get('authorize/google/redirect', [SocialAuthController::class, 'redirectToProvider'])->name('user.social.register');
	Route::get('authorize/google/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('user.social.callback');
	Route::post('forgot-password', [ForgotPasswordController::class, 'sendEmail'])->name('user.forgot-password');
	Route::post('reset-password', [UpdatePasswordController::class, 'updatePassword'])->name('user.reset-password');
	Route::get('search', [SearchController::class, 'search'])->name('search');

Route::group(['middleware' => ['auth:api']], function () {
	Route::post('logout', [AuthController::class, 'logout'])->name('user.logout');
	Route::post('refresh', [AuthController::class, 'refresh'])->name('user.refresh');
	Route::post('authenticatedUser', [AuthController::class, 'authenticatedUser'])->name('user.authenticated');
	Route::post('checkToken', [AuthController::class, 'checkToken'])->name('user.checkToken');
	Route::post('dashboard', [DashboardController::class, 'index'])->name('user.dashboard')->middleware('verified');
	Route::get('genres', [GenreController::class, 'index'])->name('genres.index');
	Route::get('movie-slug/{id}', [MovieController::class, 'showBySlug'])->name('movie.getBySlug');
	Route::apiResource('movies', MovieController::class);
	Route::apiResource('users', UserController::class);
	Route::apiResource('quotes', QuoteController::class);
	Route::apiResource('quotes/{quote}/comment', CommentController::class);
	Route::post('like/{quote}', [LikeController::class, 'like'])->name('quote.like');
	Route::delete('like/{quote}', [LikeController::class, 'unlike'])->name('quote.unlike');
	Route::post('notifications', [NotificationController::class, 'index'])->name('notification.index');
	Route::post('markAsRead', [NotificationController::class, 'read'])->name('notification.read');
	Route::post('markAllAsRead', [NotificationController::class, 'readAll'])->name('notification.readAll');
});
