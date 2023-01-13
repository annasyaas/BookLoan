<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MaeMapeController;
use App\Http\Controllers\SimilarityController;
use App\Http\Controllers\RecommendationController;

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

Route::delete('/bookDelete', [BookController::class, 'deleteData'])->middleware('auth')->name('bookDelete');
Route::resource('/book', BookController::class)->middleware('auth')->except('destroy');
Route::get('/getDatas', [BookController::class, 'datas'])->middleware('auth');

Route::resource('/member', MemberController::class)->middleware('auth');

Route::resource('/user', UserController::class)->middleware('auth')->except('show');

Route::resource('/loan', LoanController::class)->middleware('auth');
Route::get('/getCopy/{id}', [LoanController::class, 'copy'])->middleware('auth');
Route::post('/updateCopy', [LoanController::class, 'updateCopy'])->middleware('auth')->name('book.copy.update');

Route::get('/recommendation', [RecommendationController::class, 'recommendation'])->middleware('auth')->name('recommendation');
Route::get('/recommendation/getSimilarity', [SimilarityController::class, 'getSimilarity'])->middleware('auth')->name('getsimilarity');
Route::get('/recommendation/getPrediction', [RecommendationController::class, 'getPrediction'])->middleware('auth')->name('getprediction');

Route::get('/recommendation/maemape', [MaeMapeController::class, 'getMaeMape'])->middleware('auth')->name('getmaemape');
Route::get('/recommendation/getMatrix/{rate}', [MaeMapeController::class, 'matrix'])->middleware('auth');
