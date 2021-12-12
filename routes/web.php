<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/comments/{thread}',[CommentController::class, 'store']);
Route::get('/threads/create',[ThreadController::class, 'create']);
Route::post('/threads',[ThreadController::class, 'store']);
Route::get('/threads',[ThreadController::class, 'index']); 
Route::get('/threads/{thread:id}',[ThreadController::class, 'show']);