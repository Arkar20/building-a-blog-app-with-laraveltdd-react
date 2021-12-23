<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavouriteController;

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

Route::delete('/comments/{comment}/delete',[CommentController::class, 'destroy'])->middleware('auth')->name('comment.delete');
Route::post('/comments/{thread}',[CommentController::class, 'store']);

Route::post('comments/{comment:id}/favourites',[FavouriteController::class, 'store'])->middleware('auth')->name('comment.favourite');
Route::get('/threads/create',[ThreadController::class, 'create']);

Route::post('/threads',[ThreadController::class, 'store']);
Route::get('/threads',[ThreadController::class, 'index']); 
Route::delete('/threads/{channel:name}/{thread:id}',[ThreadController::class, 'destroy'])->name('thread.delete'); 
Route::get('/threads/{channel:name}',[ThreadController::class, 'index']); 
Route::get('/threads/{channel:name}/{thread:id}',[ThreadController::class, 'show']);


Route::get('/profile/{user:name}',[ProfileController::class,'index'])->name('profile');