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
Route::get('/journal/{slug}', [JournalController::class, 'show']);

Route::group(['middleware' => ['guest']], function () { 
    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/authenticate', [UserController::class, 'authenticate'])->name("authenticateUser");
    Route::get('/register', [UserController::class, 'showRegister']);
    Route::post('/createUser', [UserController::class, 'store'])->name("createUser");
});

Route::group(['middleware' => ['auth']], function () { 
    Route::get('/write', [JournalController::class, 'create']);
    Route::post('/storeJournal', [JournalController::class, 'store'])->name("storeJournal");

    Route::get('/update/{slug}', [JournalController::class, 'edit']);
    Route::post('/updateJournal', [JournalController::class, 'update'])->name("updateJournal");

    Route::get('/burninfire/{slug}', [JournalController::class, 'destroy']);

    Route::get('/settings', [UserController::class, 'settings']);
    Route::post('/update/user/email', [UserController::class, 'updateEmail'])->name("updateEmail");
    Route::post('/update/user/username', [UserController::class, 'updateUsername'])->name("updateUsername");
    Route::post('/update/user/password', [UserController::class, 'updatePassword'])->name("updatePassword");
    Route::post('/update/user/pfphoto', [UserController::class, 'updatePfphoto'])->name("updatePfphoto");
    Route::get('/delete/user/pfphoto', [UserController::class, 'deletePfphoto']);

    Route::get('/logout',  [UserController::class, 'logout'])->name("logout");
});