<?php

use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostRepliesController;
use App\Http\Controllers\RepostsController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Authenticate;
use App\Http\Service\PostService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [PostsController::class, 'index']);

Auth::routes();

Route::group(['middleware' => Authenticate::class], function()
{
    Route::resource('posts', PostsController::class);
    Route::resource('postReplies', PostRepliesController::class);
    Route::post('{type}/{id}/repost', [RepostsController::class, 'repost']);
    Route::post('{type}/{id}/like', [LikesController::class, 'like']);
    Route::delete('{type}/{id}/unlike', [LikesController::class, 'unlike']);
    Route::group(['prefix' => 'users'], function() {
        Route::get('/{id}/profile', [UsersController::class, 'profile'])->name('users.profile');
        Route::put('/{id}/profile/edit', [UsersController::class, 'editProfile'])->name('users.editProfile');
        Route::post('/{id}/block', [UsersController::class, 'block'])->name('users.block');
        Route::delete('/{id}/unblock', [UsersController::class, 'unblock'])->name('users.unblock');
    });
});