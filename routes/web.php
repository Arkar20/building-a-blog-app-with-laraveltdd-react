<?php

use App\Models\User;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ThreadLockController;
use App\Http\Controllers\BestCommentController;
use App\Http\Controllers\AvatarUploadController;
use App\Http\Controllers\NotificationThreadController;
use App\Http\Controllers\ThreadSubscriptionController;
use App\Http\Resources\ThreadResource;

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

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::delete('/comments/{comment}/delete',[CommentController::class, 'destroy'])->middleware('auth')->name('comment.delete');
Route::post('/comments/{thread}',[CommentController::class, 'store']);
Route::get('/comments/{thread}',[CommentController::class, 'show']); //! for react api

Route::post('comments/{comment:id}/favourites',[FavouriteController::class, 'store'])->middleware('auth')->name('comment.favourite');
Route::get('/threads/create',[ThreadController::class, 'create']);

Route::post('/threads',[ThreadController::class, 'store']);
Route::get('/threads',[ThreadController::class, 'index']); 
Route::delete('/threads/{thread:id}',[ThreadController::class, 'destroy'])->name('thread.delete'); 
Route::get('/threads/{channel:name}',[ThreadController::class, 'index']); 
Route::get('/threads/{thread:slug}/edit',[ThreadController::class, 'edit'])->name('thread.edit');

Route::patch('/threads/{channel:name}/{thread:slug}',[ThreadController::class, 'update'])->name('thread.update');
Route::get('/threads/{channel:name}/{thread:slug}',[ThreadController::class, 'show'])->name('thread.show');


Route::get('/profile/{user:name}',[ProfileController::class,'index'])->name('profile');

Route::post('thread/{thread:id}/subscribe',[ThreadSubscriptionController::class,'store'])->name('thread.subscribe');


Route::delete('/notifications/{notification}/markasread',[NotificationThreadController::class,'destroy'])->middleware('auth')->name('noti.mark');

Route::post('/profile/{user:name}/avatar',[AvatarUploadController::class,'store'])->name('avatar.upload')->middleware('auth');


Route::get('/api/notifications',function(){
    return auth()->user()->notifications->map(function($noti){
        return [
            'message'=>$noti->data,
            'created_at'=>$noti->created_at->diffForHumans()
        ];
    });
})->middleware('auth');

Route::get('/api/searchThreads',function(){
    return ThreadResource::collection(Thread::all());
});


Route::post('/comment/{comment:id}/bestcomment',[BestCommentController::class,'store']);


Route::post('/thread/{thread:id}/locked',[ThreadLockController::class,'store'])->middleware(['auth','admin'])->name('thread.locked');
// Route::get('/test',function(){
//     return "testing verified middleware";
// })->middleware('verified');