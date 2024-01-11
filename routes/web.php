<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PostController;

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
//Only auth routes:
Route::middleware(['auth'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::get('/post/create', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/like/{slug}', [PostController::class, 'addLike'])->name('post.like');
    Route::get('/post/loadMorePosts', [PostController::class, 'loadMorePosts'])->name('post.loadMorePosts');
    
});

Route::get('/', [MainController::class, 'index'])->name('main.index');




//LOGIN

Route::middleware(['web'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.login');
    Route::get('/user/create', [UserController::class, 'storage'])->name('user.storage');
    Route::get('/user/createNew', [UserController::class, 'create'])->name('user.create');
    Route::get('/show/{slug}', [PostController::class, 'show'])->name('post.show');
    Route::post('/post/comment/{slug}', [PostController::class, 'addComment'])->name('post.comment');
    
});


