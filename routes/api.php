<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    //user routes
    Route::get('/user', function (Request $request) {
        return [
            'user' => UserResource::make($request->user()),
            'currentToken' => $request->bearerToken()
        ];
    });
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::post('user/follow', [UserController::class, 'follow']);
    Route::post('user/unfollow', [UserController::class, 'unfollow']);
    Route::put('update/profile', [UserController::class, 'updateUserInfos']);
    Route::put('update/password', [UserController::class, 'updateUserPassword']);
    Route::get('user/articles', [ArticleController::class, 'fetchByUser']);

    //articles routes
    Route::get('followings/articles', [ArticleController::class, 'fetchFollowingsArticles']);
    Route::post('add/article', [ArticleController::class, 'store']);
    Route::put('update/{article}/article', [ArticleController::class, 'update']);
    Route::delete('delete/{article}/article', [ArticleController::class, 'delete']);
    Route::get('clap/{article}/article', [ArticleController::class, 'articleClap']);
});

//articles routes
Route::get('articles', [ArticleController::class, 'index']);
Route::get('articles/{article}', [ArticleController::class, 'show']);
Route::post('find/articles', [ArticleController::class, 'fetchByTerm']);
Route::get('tag/{tag}/articles', [ArticleController::class, 'fetchByTag']);
//user routes
Route::post('user/login', [UserController::class, 'auth']);
Route::post('user/register', [UserController::class, 'store']);
//tags routes
Route::get('tags', [TagController::class, 'index']);

