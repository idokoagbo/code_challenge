<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [PostController::class, 'welcome'])->middleware(['auth','verified']);;
Route::resource('/users',UserController::class)->middleware('auth');
Route::resource('/posts',PostController::class)->middleware('auth');
Route::get('/post/delete/{post}', [PostController::class, 'destroy'])->middleware(['auth','verified']);


Auth::routes(['verify' => true]);

Route::group(['middleware'=>['auth','verified']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});


//admin routes

Route::group(['prefix'=>'admin'],function(){
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.login');
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/members', [AdminController::class, 'members'])->name('admin.members');
    Route::get('/members/update/{user}/{status}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
    Route::get('/posts', [AdminController::class, 'posts'])->name('admin.posts');
    Route::get('/posts/update/{post}/{status}', [AdminController::class, 'postUpdate'])->name('admin.posts.update');
});