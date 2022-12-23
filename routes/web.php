<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;

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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', function(){
    return view('dashboard.index');
})->middleware('auth')->name('dashboard');

Route::delete('/book/delete/{id}', [BookController::class, 'destroy'])->middleware('auth')->name('book.delete');
Route::resource('/book', BookController::class)->middleware('auth')->except('destroy');
Route::get('/getDatas', [BookController::class, 'datas'])->middleware('auth');

Route::resource('/member', MemberController::class)->middleware('auth')->except('show');

Route::resource('/user', UserController::class)->middleware('auth')->except('show');

Route::resource('/loan', LoanController::class)->middleware('auth');