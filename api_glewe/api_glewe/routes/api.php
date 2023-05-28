<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OperationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\RoleController;

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

Route::group(['prefix' => 'auth'], function () {
    //login and register
    Route::post('/register', [AuthController::class,'registerUser']);
    Route::post('/login',  [AuthController::class,'authenticateUser']);

});//end auth

Route::group(['prefix' => 'params'], function () {
    //login and register
    Route::get('/languages', [LanguageController::class,'listingLanguage']);
    Route::get('/countries',  [CountryController::class,'listingCountry']);
    Route::get('/roles', [RoleController::class,'listingRole']);
    Route::post('/delete-category',  [CategoryController::class,'deleteCategory']);
    Route::post('/update-category', [CategoryController::class,'updateCategory']);
    Route::get('/categories',  [CategoryController::class,'listingCategory']);
    Route::post('/new-category',  [CategoryController::class,'createCategory']);

});//end auth



