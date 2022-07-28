<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\{UserController, ApplicationController, CategoryController,ContentController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[UserController::class,'loginForm']);
Route::get('/dashboard',[UserController::class,'index']);
Route::post('/login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);
Route::get('register',[UserController::class,'registerForm']);
Route::post('/register', [UserController::class, 'register']);

Route::group(['middleware'=>'auth'],function (){
    // Route::get('dashboard',[\App\Http\Controllers\DashboardController::class,'index']);
    // Route::resource('application',[ApplicationController::class]);
    Route::resource('/application',  ApplicationController::class);
    Route::post('application-list',  [ApplicationController::class, 'ApplicationList']);
    Route::get('dashboard',  [ApplicationController::class, 'Dashboard']);
    Route::get('add-application',  [ApplicationController::class, 'AddApplication']);
    Route::get('/application/{id}/delete',[ApplicationController::class, 'destroy']);
    // Route::post('insert-application-data',[ApplicationController::class,'index']);

    // category
    Route::resource('/category',  CategoryController::class);
    Route::get('/category-add/{id}',  [CategoryController::class, 'AddCategory']);
    Route::post('category-list',  [CategoryController::class, 'CategoryList']);
    Route::post('/category-update/{id}',  [CategoryController::class, 'update']);
    Route::get('/category/{id}/delete',[CategoryController::class, 'destroy']);
    // content
    //Route::resource('/content',  ContentController::class);
    Route::get('addcontent/{id}',[ContentController::class,'addcontent']);


});
