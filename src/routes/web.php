<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\TimestampsController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AttendanceController;
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
Route::get('/attendance/date', [AttendanceController::class, 'indexDate'])->name('attendance/date');
Route::post('/attendance/date', [AttendanceController::class, 'perDate'])->name('per/date');
Route::get('/attendance/user', [AttendanceController::class, 'indexUser'])->name('attendance/user');
Route::post('/attendance/user', [AttendanceController::class, 'perUser'])->name('per/user');
// Route::get('/attendance/user', [AttendanceController::class, 'perUser'])->name('per/user');
Route::get('/user', [AttendanceController::class, 'user'])->name('user');
Route::post('/user/scene', [AttendanceController::class, 'perScene'])->name('per/scene');
Route::get('/user/scene', [AttendanceController::class, 'perScene'])->name('per/scene');