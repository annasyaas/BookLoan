<?php

use App\Http\Controllers\BookController;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;

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

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/', function(){
    return view('dashboard.index');
})->middleware('auth');

Route::delete('/book/delete/{id}', [BookController::class, 'destroy'])->middleware('auth')->name('book.delete');
Route::resource('/book', BookController::class)->except('destroy')->middleware('auth');
Route::get('/getDatas', [BookController::class, 'datas'])->middleware('auth');

Route::resource('/member', MemberController::class)->except('show')->middleware('auth');