<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ApplicationController;

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
    // Route::post('insert-application-data',[ApplicationController::class,'index']);
});
