<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LoginController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth:

Route::get('/chat', [ChatController::class, 'index'])->name('chat');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::get('/user', function (Request $request) {
        return $request->user();    
    });
    
    Route::post('/logout', [LoginController::class, 'logout']);
});


Route::post('/showMessageData', [MessageController::class, 'showMessData']);
Route::post('/createMessageData', [MessageController::class, 'createMessData']);
Route::post('/showChatData', [MessageController::class, 'showChatData']);
Route::post('/showUserMess', [MessageController::class, 'showUserMess']);
// Route::post('/message', [MessageController::class, 'store'])->name('message.store');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [LoginController::class, 'register'])->name('register');
