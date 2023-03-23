<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Posts - Backend
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/post/{id}', [PostController::class, 'get']);
Route::post('/post', [PostController::class, 'post']);
Route::put('/post/{id}', [PostController::class, 'put']);
Route::delete('/post/{id}', [PostController::class, 'delete']);
