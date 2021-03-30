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
    Route::post('/updateuser', [AuthController::class, 'updateuser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/allusers', [AuthController::class, 'allusers']);

    //note

    Route::group(['prefix' => 'notes'], function ($router) {
        Route::get('/all', [NotesController::class, 'index']);
        Route::get('/my_notes', [NotesController::class, 'my_notes']);

        Route::get('/filter/{query?}', [NotesController::class, 'filter']);
        Route::post('/create', [NotesController::class, 'create_note']);
        Route::post('/update', [NotesController::class, 'update_note']);
        Route::get('/delete/{id?}', [NotesController::class, 'delete_note']);

        //like note
        Route::post('/like', [LikeController::class, 'like_note']);
    });

});
