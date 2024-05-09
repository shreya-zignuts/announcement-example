<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\UserAnnouncementController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest');

Route::middleware(['auth:sanctum','admin'])
    ->prefix('admin')
    ->group(function () {
        // Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name(
        //   'auth-register-basic'
        // );

        Route::prefix('announcements')->group(function () {
            Route::get('/', [AnnouncementController::class, 'index']);
            Route::post('/store', [AnnouncementController::class, 'store']);
            Route::get('/show/{id}', [AnnouncementController::class, 'show']);
            Route::post('/update/{id}', [AnnouncementController::class, 'update']);
            Route::post('/delete/{id}', [AnnouncementController::class, 'delete']);

        });
    });

    Route::middleware(['auth:sanctum','user'])
    ->prefix('users')
    ->group(function () {
        // Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name(
        //   'auth-register-basic'
        // );

        Route::prefix('announcements')->group(function () {
            Route::get('/', [UserAnnouncementController::class, 'index']);
            Route::get('/show/{id}', [UserAnnouncementController::class, 'show']);

        });
    });