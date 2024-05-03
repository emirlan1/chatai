<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('auth')->group(function () {
        Route::get('/subscribe-to-plan', [InvoiceController::class, 'subscribeToPlan']);
});


Route::get('/chat/{id?}', [ChatController::class, 'index'])->middleware('auth');;
Route::post('/chat', [ChatController::class, 'index'])->middleware('auth');;
Route::post('/context', [ChatController::class, 'context'])->middleware('auth');;
Route::post('/chatlist', [ChatController::class, 'chatList'])->middleware('auth');;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
