<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ProductController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\UserCollectionController;

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

/////bayan
Route::prefix("collection")->group(function () {

    Route::group(['middleware' => ['auth:sanctum',  'logroute']], function () {

        Route::post('creat', [App\Http\Controllers\CollectionController::class, 'store']);
        Route::get('show_my_collection', [App\Http\Controllers\CollectionController::class, 'show_my_collection']);
        Route::get('show_my_collection_file/{collection_id}', [App\Http\Controllers\CollectionController::class, 'show_my_collection_file']);
        Route::get('show_all_users_not_in_collection/{collection_id}', [App\Http\Controllers\CollectionController::class, 'show_all_users_not_in_collection']);
        Route::get('show_all_users_in_collection/{collection_id}', [App\Http\Controllers\CollectionController::class, 'show_all_users_in_collection']);
        Route::get('show_all_collection', [App\Http\Controllers\CollectionController::class, 'show_all_collection']);
        Route::get('all_file_not_in_collection/{collection_id}', [App\Http\Controllers\CollectionController::class, 'all_file_not_in_collection']);
        Route::get('all_file_to_reserve', [App\Http\Controllers\CollectionController::class, 'all_file_to_reserve']);
    });

    Route::group(['middleware' => ['public_collection', 'logroute']], function () {

        Route::post('add_file_to_collection', [App\Http\Controllers\CollectionController::class, 'add_file_to_collection']);
        Route::post('delete_file_from_collection', [App\Http\Controllers\CollectionController::class, 'delete_file_from_collection']);
    });


    Route::group(['middleware' => ['Collection_owner', 'logroute']], function () {

        Route::post('add_user_to_collection', [App\Http\Controllers\CollectionController::class, 'add_user_to_collection']);
        Route::post('delete_user_from_collection', [App\Http\Controllers\CollectionController::class, 'delete_user_from_collection']);
        Route::post('destroy', [App\Http\Controllers\CollectionController::class, 'destroy']);
    });
});

/////batool
Route::get('logout', [
    'middleware' => 'auth:sanctum',
    'uses' => 'App\Http\Controllers\UserController@logout'
]);

Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('logout', [
    'middleware' => 'auth:sanctum',
    'uses' => 'App\Http\Controllers\UserController@logout'
]);

Route::post('register', [
    'uses' => 'App\Http\Controllers\UserController@register'
]);

Route::get('OwnerToCollection', [
    'middleware' => 'Role:owner',
    'uses' => 'App\Http\Controllers\UserCollectionController@OwnerToCollection'
]);

/////boshra
//create && delete && display file && check_in && check_out
Route::group(['middleware' => ['auth:sanctum', 'logroute']], function () {
    Route::get('mycollection', [FileController::class, 'myCollection']);
    Route::post('file/check_many_files', [FileController::class, 'check_many_files']);
    Route::post('file/update/{id}', [FileController::class, 'update']);
    Route::delete('file/{id}/{user_id}', [FileController::class, 'destroy']);
    Route::get('file', [FileController::class, 'index']);
    Route::post('file', [FileController::class, 'store']);
    Route::get('admin/files', [FileController::class, 'admin_files'])->middleware('Admin');
    Route::get('admin/collection', [FileController::class, 'admin_collections'])->Middleware('Admin');
});
Route::post('file/check_in/{id}/{user_id}', [FileController::class, 'check_in']);
Route::post('file/check_out/{id}/{user_id}', [FileController::class, 'check_out']);



////test multi data base
Route::get('product', [ProductController::class, 'allProduct']);
