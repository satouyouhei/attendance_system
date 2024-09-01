<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\TimestampsController;
use App\Http\Controllers\RegisteredUserController;
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

Route::post('/login',[AuthenticatedSessionController::class,'store'])->name('login');
Route::post('/register',[RegisteredUserController::class,'store'])->name('register');
Route::get('/',[TimestampsController::class,'index'])->middleware('verified');
Route::get('/logout',[AuthenticatedSessionController::class,'destroy'])->middleware('auth')->name('logout');

Route::post('/',[TimestampsController::class,'punch'])->name('punch');
