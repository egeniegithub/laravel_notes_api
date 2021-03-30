<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function ($router) {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/update-user', [AuthController::class, 'update_user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/all-users', [AuthController::class, 'all_users']);

    //note

    Route::group(['prefix' => 'notes'], function () {
        Route::get('/all', [NotesController::class, 'index']);
        Route::get('/my_notes', [NotesController::class, 'my_notes']);

        Route::post('/filter_notes', [NotesController::class, 'filter_notes']);
        Route::post('/create', [NotesController::class, 'create_note']);
        Route::post('/update', [NotesController::class, 'update_note']);
        Route::put('/delete', [NotesController::class, 'delete_note']);
    });

    Route::group(['prefix' => 'likes'], function () {
        //like note
        Route::post('/like', [LikeController::class, 'like_note']);
    });

});
