<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\NoAccessController;
use App\Http\Controllers\UserAuthorizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserCreatedController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [Controller::class, 'index'])
    ->name('index')
    ->middleware('telegramAuth');
Route::post('/user', [UserCreatedController::class, 'newUser'])
    ->name('user');
Route::get('/auth/{authorization_token}', [UserAuthorizationController::class, 'authorizeUser'])
    ->name('authorize');
Route::get('/no_access', [NoAccessController::class, 'noAccess'])
    ->name('no_access');