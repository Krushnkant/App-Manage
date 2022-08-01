<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\{UserController, ApplicationController, CategoryController,ContentController, AppDataController};

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

Route::get('/',[UserController::class,'loginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);
Route::get('register',[UserController::class,'registerForm']);
Route::post('/register', [UserController::class, 'register']);

Route::group(['middleware'=>'auth'],function (){
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
    Route::resource('/content',  ContentController::class);
    Route::get('addcontent/{id}',[ContentController::class,'addcontent']);
    Route::get('content-form/{id}',[ContentController::class,'ContentForm']); // content app data add
    Route::post('/content-update/{id}',  [ContentController::class, 'update']);

    // application content data
    Route::resource('/app-data',  AppDataController::class);
    Route::get('content-edit/{app_id}',[AppDataController::class,'edit']);
    Route::post('contentt-update/{app_id}',[AppDataController::class,'update']);
    Route::post('application-list-dashboard',  [ApplicationController::class, 'ApplicationListDashboard']);

    // application data table
    Route::post('application-has-category',[AppDataController::class,'ApplicationHasCategory']);

});


