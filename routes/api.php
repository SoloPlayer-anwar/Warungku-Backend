<?php

use App\Http\Controllers\API\ProductWarungController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::get('product', [ProductWarungController::class, 'get']);
Route::post('createProduct', [ProductWarungController::class, 'create']);
Route::post('updateProduct/{id}', [ProductWarungController::class, 'update']);
Route::get('deleteProduct/{id}', [ProductWarungController::class, 'delete']);
