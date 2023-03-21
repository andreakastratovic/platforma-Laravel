<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\API\AuthController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/genres/{id}',[GenreController::class, 'show']);
//Route::get('/genres',[GenreController::class, 'index']);

Route::resource('genres', GenreController::class);
Route::resource('books', BookController::class);
Route::resource('users', UserController::class);


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::get('books/genre/{id}',[BookController::class,'getByGenre']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::resource('books', BookController::class)->only(['update','store','destroy']);

    Route::get('my-books',[BookController::class,'myBooks']);

    Route::post('/logout', [AuthController::class, 'logout']);
    
});

