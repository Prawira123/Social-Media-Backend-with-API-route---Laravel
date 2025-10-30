<?php

use Dom\Comment;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\MessagesController;
use App\Http\Middleware\JWTMiddleware;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    //Handle auth..
    Route::post('/register', [JWTAuthController::class, 'register']);
    Route::post('/login', [JWTAuthController::class, 'login']);

    //menghandle posts
    Route::middleware(JWTMiddleware::class)->prefix('posts')->group(function () {
    Route::get('/', [PostsController::class, 'index']); // mengambil semua data
    Route::post('/', [PostsController::class, 'store']); // menyimpan semua data
    Route::get('/{id}', [PostsController::class, 'show']); // menampilkan data spesifik
    Route::put('/{id}', [PostsController::class, 'update']); // mengupdate data
    Route::delete('/{id}', [PostsController::class, 'destroy']); // menghapus data
    });

    //menghandle comments
    Route::middleware(JWTMiddleware::class)->prefix('comments')->group(function () {
    Route::get('/', [CommentsController::class, 'index']); // mengambil semua data
    Route::post('/', [CommentsController::class, 'store']); // menyimpan semua data
    // Route::get('/{id}', [PostsController::class, 'show']); // menampilkan data spesifik
    // Route::put('/{id}', [PostsController::class, 'update']); // mengupdate data
    Route::delete('/{id}', [CommentsController::class, 'destroy']); // menghapus data
    });

    //menhandle likes
    Route::middleware(JWTMiddleware::class)->prefix('likes')->group(function(){
        Route::get('/', [LikesController::class, 'index']);
        Route::post('/', [LikesController::class, 'store']);
        Route::delete('/{id}', [LikesController::class, 'destroy']);
    });
    Route::middleware(JWTMiddleware::class)->prefix('messages')->group(function(){
        Route::get('/getMessages/{user_id}', [MessagesController::class, 'getMessages']);
        Route::get('/{id}', [MessagesController::class, 'show']);
        Route::post('/', [MessagesController::class, 'store']);
        Route::delete('/{id}', [MessagesController::class, 'destroy']);
    });
});
