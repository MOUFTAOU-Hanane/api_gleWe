<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\Module;

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
    Route::get('/categories',  [CategoryController::class,'listingCategory']);

});//end

Route::group(['prefix' => 'admin'], function () {
    Route::get('/new-course', [CourseController::class,'createCourse']);
    Route::get('/delete-course',  [CourseController::class,'deleteCourse']);
    Route::get('/courses', [CourseController::class,'getCourse']);
    Route::get('/new-module',  [ModuleController::class,'createModule']);
    Route::post('/update-module',  [ModuleController::class,'updateModule']);
    Route::get('/modules',  [ModuleController::class,'getModule']);
    Route::post('/delete-module',  [ModuleController::class,'deleteModule']);
    Route::post('/delete-category',  [CategoryController::class,'deleteCategory']);
    Route::post('/update-category', [CategoryController::class,'updateCategory']);
    Route::post('/new-category',  [CategoryController::class,'createCategory']);
});//end auth

Route::group(['prefix' => 'offer'], function () {

    Route::get('/courses', [CourseController::class,'getCourse']);
    Route::post('/search-course-by-category',  [CourseController::class,'searchCourseByCategory']);
    Route::post('/search-course', [CourseController::class,'searchCourse']);
    Route::get('/modules',  [ModuleController::class,'getModule']);
    Route::post('/course-detail',  [CourseController::class,'detailCourse']);
    Route::post('/enrolment',  [createCourseEnrolment::class,'createCourseEnrolment']);
    Route::post('/user-courses',  [createCourseEnrolment::class,'userCourse']);
    Route::post('/rating-course-by-user',  [createCourseEnrolment::class,'ratingCourse']);




    //courseFound createCourseEnrolmant
});//end auth



