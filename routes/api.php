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

Route::prefix('/user')
    ->controller(\App\Http\Controllers\UserController::class)
    ->group(function(){
        Route::post('', 'index')->name('.index');
        Route::post('update', 'update')->name('.update');
    })
    ->name('user')
;
Route::prefix('/ostan')
    ->controller(\App\Http\Controllers\OstanController::class)
    ->group(function(){
        Route::post('', 'index')->name('.index');
        Route::post('update', 'update')->name('.update');
    })
    ->name('user')
;

Route::prefix('navigation')
    ->controller(NavigationController::class)->group(function () {
        Route::post('', 'index')->name('.index');
    })
    ->name('navigation');

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('information', 'information');
});
