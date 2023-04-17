<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//import the Controller
use App\Http\Controllers\UserApiController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//GET Request
Route::get('/users', UserApiController::class . '@allUser');
Route::get('/users/{id}', UserApiController::class . '@userDetails');

//POST Request
Route::post('/add-user', UserApiController::class . '@createUser');