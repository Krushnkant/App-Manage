<?php

use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\{UserController, ApplicationController, CategoryController, ContentController, AppDataController, SettingsController, UserAjaxController};

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

Route::get('/', [UserController::class, 'loginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);
Route::get('register', [UserController::class, 'registerForm']);
Route::post('/register', [UserController::class, 'register']);

Route::group(['middleware' => 'auth'], function () {
    // Route::resource('application',[ApplicationController::class]);
    Route::resource('/application',  ApplicationController::class);
    Route::post('application-list',  [ApplicationController::class, 'ApplicationList']);
    Route::get('dashboard',  [ApplicationController::class, 'Dashboard']);
    Route::get('add-application/{is_new}',  [ApplicationController::class, 'AddApplication']);
    Route::get('/application/{id}/delete', [ApplicationController::class, 'destroy']);
    Route::get('chageapplicationstatus/{id}', [ApplicationController::class, 'chageapplicationstatus']);
    // Route::post('insert-application-data',[ApplicationController::class,'index']);
    Route::get('check-applicationId/{id}', [ApplicationController::class, 'CheckAppId']);

    // category
    Route::resource('/category',  CategoryController::class);
    Route::get('/category-add/{id}',  [CategoryController::class, 'AddCategory']);
    Route::post('category-list',  [CategoryController::class, 'CategoryList']);
    Route::post('/category-update/{id}',  [CategoryController::class, 'update']);
    Route::get('/category/{id}/delete', [CategoryController::class, 'destroy']);
    Route::get('/category/{id}/{catid}/copy', [CategoryController::class, 'copy']);
    Route::get('chageacategorystatus/{id}', [CategoryController::class, 'ChageCategoryStatus']);

    // content
    Route::resource('/content',  ContentController::class);
    // Route::get('addcontent/{id}',[ContentController::class,'addcontent']);
    Route::get('add-structure/{id}', [ContentController::class, 'addstructure']);
    Route::get('content-form/{id}', [ContentController::class, 'ContentForm']); // content app data add
    Route::get('content-edit/{app_id}/{uuid}', [ContentController::class, 'edit']); // content app data edit
    Route::post('/content-update/{id}',  [ContentController::class, 'update']);
    Route::get('content-list/{id}', [ContentController::class, 'ContentList']); // content app data list
    Route::post('content-get-list/{id}', [ContentController::class, 'ContentGetList']); // content data table
    Route::get('/content/{id}/delete', [ContentController::class, 'destroy']);
    Route::get('/content_image_delete/{id}', [ContentController::class, 'DeleteContent']);
    Route::get('chageaContentstatus/{id}', [ContentController::class, 'ChageContentStatus']);
    Route::get('chageaContentstatusNew/{id}', [ContentController::class, 'ChageContentStatusNew']);

    // application content data
    Route::resource('/app-data',  AppDataController::class);
    Route::post('contentt-update/{app_id}', [AppDataController::class, 'update']);
    Route::post('application-list-dashboard',  [ApplicationController::class, 'ApplicationListDashboard']);

    // application data table
    Route::post('application-has-category', [AppDataController::class, 'ApplicationHasCategory']);

    // settings
    Route::resource('/settings', SettingsController::class);
    Route::post('/change-password', [SettingsController::class, 'ChangePassword']);

    // match same value
    Route::post('same_value_match', [AppDataController::class, 'SameValueMatch']);

    Route::get('application-new',  [ApplicationController::class, 'NewApplication']);
    Route::post('application-list-new',  [ApplicationController::class, 'NewApplicationList']);

    Route::get('/category-add-new/{id}',  [CategoryController::class, 'AddCategoryNew']);
    Route::post('category-insert-new',  [CategoryController::class, 'InsertCategoryNew']);
    Route::get('category-edit-new/{id}',  [CategoryController::class, 'EditCategoryNew']);
    Route::post('category-update-new/{id}',  [CategoryController::class, 'UpdateCategoryNew']);
    Route::get('category-image-delete/{id}',  [CategoryController::class, 'ImageDelete']);

    Route::get('/sub-content/{cat_id}/{app_id}/{parent_id}',  [CategoryController::class, 'SubContent']);
    Route::get('/add-content/{cat_id}/{app_id}/{parent_id}',  [CategoryController::class, 'AddContent']);
    Route::get('/sub-form-structure/{cat_id}/{app_id}/{parent_id}',  [CategoryController::class, 'SubFormStructure']);

    Route::get('application-new-design/{cat_id}/{app_id}/{parent_id}',  [ApplicationController::class, 'NewApplicationDesign']);

    Route::post('sub-content-store/{cat_id}/{app_id}/{parent_id}',  [CategoryController::class, 'SubContentStore']);


    Route::get('/sub-content-form/{cat_id}/{app_id}/{parent_id}',  [CategoryController::class, 'SubContentAdd']);
    Route::post('sub-content-submit/{cat_id}/{app_id}/{parent_id}',  [CategoryController::class, 'SubContentInsert']);
    Route::post('content-list-get/{cat_id}/{app_id}/{parent_id}',  [CategoryController::class, 'SubContentListGet']);
    Route::post('content-list-get-new/{cat_id}/{app_id}/{parent_id}',  [CategoryController::class, 'SubContentListGetNew']);
    Route::get('show-only-content-new/{cat_id}/{app_id}/{parent_id}/{content_id}',  [CategoryController::class, 'ShowOnlyContent']);

    Route::get('/sub_form/{id}/{catid}/copy', [CategoryController::class, 'SubContentCopy']);

    Route::get('sub-content-edit/{cat_id}/{app_id}/{parent_id}/{content_id}',  [CategoryController::class, 'SubContentEdit']);
    Route::post('sub-content-update/{cat_id}/{app_id}/{parent_id}/{structure_id}',  [CategoryController::class, 'SubContentUpdate']);

    Route::get('/content_image_delete_new/{id}/{type}', [CategoryController::class, 'DeleteContentNew']);
    Route::get('/sub_content_delete_new/{id}', [CategoryController::class, 'DeleteSubContentNew']);








    Route::get('/new-user', [AppDataController::class, 'index']);  //karan
    Route::post('userslist',  [AppDataController::class, 'ApplicationList']);  //karan
    Route::post('userdd', [AppDataController::class, 'NewUser']);  //karan
    Route::get('edit-student/{id}', [AppDataController::class, 'edit']);  //karan

    Route::post('update-student/{id}', [AppDataController::class, 'updateuser']);  //karan
    Route::delete('delete-student/{id}', [AppDataController::class, 'destroy']);  //karan


    Route::post('/searching/{cat_id}/{app_id}/{parent_id}', [CategoryController::class, 'SearchingApi']); //pooja


    Route::get('/user-add-new/{id}',  [CategoryController::class, 'AdduserNew']);  //karan
    Route::post('user-insert-new',  [CategoryController::class, 'InsertUserNew']);  //karan
    Route::post('user-list',  [CategoryController::class, 'userList']);  //karan
    Route::get('changeuserstatus/{id}', [CategoryController::class, 'chageuserstatus']);  //karan
    Route::get('/deleteuser/{id}/delete', [CategoryController::class, 'userdestroy']);  //karan


    Route::get('/user-add-old/{id}',  [UserController::class, 'AdduserOld']);  //pooja

});
