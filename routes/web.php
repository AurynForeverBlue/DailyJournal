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


Route::group(['middleware' => ['guest']], function () { 
    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/authenticate', [UserController::class, 'authenticate'])->name("authenticateUser");
    Route::get('/register', [UserController::class, 'showRegister']);
    Route::post('/create/user', [UserController::class, 'store'])->name("createUser");
});

Route::group(['middleware' => ['auth']], function () { 
    Route::get('/create/journal', [JournalController::class, 'create']);
    Route::post('/store/journal', [JournalController::class, 'store'])->name("storeJournal");

    Route::get('/{slug}/journal', [JournalController::class, 'show']);

    Route::get('/{slug}/edit/journal', [JournalController::class, 'edit']);
    Route::post('/update/journal', [JournalController::class, 'update'])->name("updateJournal");

    Route::get('/{slug}/delete/journal', [JournalController::class, 'destroy']);

    Route::get('/logout',  [UserController::class, 'logout'])->name("logout");
});