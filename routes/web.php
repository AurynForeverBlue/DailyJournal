<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JournalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [JournalController::class, 'index']);

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/authenticate', [UserController::class, 'authenticateUser'])->name("authenticateUser");
Route::get('/register', [UserController::class, 'showRegister']);
Route::post('/create/user', [UserController::class, 'createUser'])->name("createUser");
Route::post('/logout',  [UserController::class, 'logout'])->name("logout");