<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{APIsController};


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

// APIs
Route::post('/update-request',  [APIsController::class, 'RequestUpdate']);
Route::post('/category-list',  [APIsController::class, 'CategoryList']);
Route::post('/content-list',  [APIsController::class, 'ContentList']);
Route::post('/sub-content-list',  [APIsController::class, 'SubContentList']);
Route::post('/get-content-list',  [APIsController::class, 'GetContentList']);
