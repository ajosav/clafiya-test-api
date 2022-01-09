<?php

use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\Auth\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;

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

Route::group(['prefix' => 'v1'], function () {

    // Users authentication
    Route::name('auth.')->prefix('auth')->group(function () {
        Route::post('register', [RegisterController::class, 'register'])->name('register');
        Route::post('login', [LoginController::class, 'login'])->name('login');
        Route::get('refresh-token', [LoginController::class, 'refreshToken'])->name('refresh');
        Route::get('current-user', [AuthController::class, 'authenticatedUser'])->name('current');
        Route::post('/email/verify', [VerificationController::class, 'verifyEmail'])->name('verify')->middleware('auth:api');
        Route::get('resend/verification-link', [VerificationController::class, 'resendLink'])->name('resend')->middleware('auth:api');
        Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])->name('password.request');
        Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
        Route::get('logout', [AuthController::class, 'logout']);
    });

    
});
