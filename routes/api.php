<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

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

// Auth routes
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);
Route::post('/reset-password', [NewPasswordController::class, 'store']);

// Public routes 
// Route::resource('/products',  ProductController::class);
Route::get('/products',  [ProductController::class, 'index']);
Route::get('/products/{id}',  [ProductController::class, 'show']);

// Protected routes 
Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::get('/profile/{userId}',  [AuthController::class, 'profile']);

    Route::post('/products',  [ProductController::class, 'store']);
    Route::put('/products/{id}',  [ProductController::class, 'update']);
    Route::delete('/products/{id}',  [ProductController::class, 'destroy']);

    Route::get('/verify-email/{id}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['throttle:6,1']);

    Route::post('/resend-verify-email', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['throttle:6,1']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
