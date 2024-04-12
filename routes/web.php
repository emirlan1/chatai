<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/chat/{id?}', [ChatController::class, 'index']);
Route::post('/chat', [ChatController::class, 'index']);
Route::post('/context', [ChatController::class, 'context']);
Route::post('/chatlist', [ChatController::class, 'chatList']);
