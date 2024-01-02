<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\NavigationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('information', 'information');
});
Route::middleware(['auth:api'])
    ->group(function () {
        Route::prefix('/user')
            ->controller(\App\Http\Controllers\UserController::class)
            ->group(function () {
                Route::post('', 'index')->name('.index');
                Route::post('update', 'update')->name('.update');
                Route::post('store', 'store')->name('.store');
                Route::post('change-password', 'changePassword')->name('.change-password');
            })
            ->name('user');
        Route::prefix('/state')
            ->name('state')
            ->controller(\App\Http\Controllers\StateController::class)
            ->group(function () {
                Route::post('', 'index')->name('.index');
                Route::get('', 'indexAll')->name('.indexAll');
                Route::post('update', 'update')->name('.update');
                Route::post('store', 'store')->name('.store');
                Route::post('delete', 'delete')->name('.delete');
            });

        Route::prefix('/news')
            ->name('news')
            ->controller(\App\Http\Controllers\NewsController::class)
            ->group(function () {
                Route::post('', 'index')->name('.index');
                Route::get('', 'indexAll')->name('.indexAll');
                Route::post('update', 'update')->name('.update');
                Route::post('store', 'store')->name('.store');
                Route::post('delete', 'delete')->name('.delete');
            });
        Route::prefix('/coefficient')
            ->controller(\App\Http\Controllers\CoefficientController::class)
            ->group(function () {
                Route::post('', 'index')->name('.index');
                Route::get('', 'indexAll')->name('.indexAll');
                Route::post('update', 'update')->name('.update');
                Route::get('edit/{coefficient}', 'edit')->name('.edit');
                Route::post('store', 'store')->name('.store');
                Route::post('delete', 'delete')->name('.delete');
            })
            ->name('coefficient');

        Route::prefix('navigation')
            ->controller(NavigationController::class)->group(function () {
                Route::post('', 'index')->name('.index');
            })
            ->name('navigation');


        Route::get('time', function () {
            return now()->timestamp;
        })
            ->name('time');


        Route::prefix('/register')
            ->controller(\App\Http\Controllers\RegisterController::class)
            ->group(function () {
                Route::post('', 'index')->name('.index');
                Route::post('edit', 'edit')->name('.edit');
                Route::post('update', 'update')->name('.update');
                Route::post('store', 'store')->name('.store');
                Route::post('delete', 'delete')->name('.delete');
            })
            ->name('register');


        Route::prefix('statics')
            ->controller(\App\Http\Controllers\DashboardController::class)
            ->group(function () {
                Route::get('', 'staticsData')->name('.index');
            })
            ->name('statics');
    });
