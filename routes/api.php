<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FoodCategoryController;
use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('permission', [AuthController::class, 'checkPermission']);
    Route::resource('user', UserController::class);
    Route::resource('category', FoodCategoryController::class);
    Route::resource('food', FoodController::class);
});
