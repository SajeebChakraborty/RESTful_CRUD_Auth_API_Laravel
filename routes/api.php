<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//import the Controller
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\ProductApiController;

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
Route::post('/add-multiple-user', UserApiController::class . '@createMultipleUser');

//PUT Request
Route::put('/update-user/{id}', UserApiController::class . '@updateUser');

//PATCH Request
Route::patch('/update-user-single-record/{id}', UserApiController::class . '@updateUserSingleRecord');

//DELETE Request
Route::delete('/delete-user/{id}', UserApiController::class . '@deleteUser');
Route::delete('/delete-user-with-json', UserApiController::class . '@deleteUserWithJson');
Route::delete('/delete-multiple-user/{ids}', UserApiController::class . '@deleteMultipleUser');

//Authentication check
Route::get('/product-list', ProductApiController::class . '@productList');

/*
    Laravel Passport Installation Steps

    1. composer require laravel/passport
    2. php artisan migrate
    3. php artisan passport:install
    4. In User model,
       use Laravel\Passport\HasApiTokens;
       use HasApiTokens,HasFactory,Notifiable
    5. Update AuthServiceProvider
       use Laravel\Passport\Passport;
    6. In boot method,
       Passport::routes();
    7.Update config/auth.php
      'api'=> [
           'driver' => 'passport',
           'provider' => 'users',
      ],

*/

//Laravel Passport
Route::post('/register-user-with-passport', UserApiController::class . '@registerUserWithPassport');
Route::post('/login-user-with-passport', UserApiController::class . '@loginUserWithPassport');