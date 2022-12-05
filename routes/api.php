<?php

use App\Http\Controllers\FileController;
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

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('creat', [App\Http\Controllers\CollectionController::class, 'store']);
        Route::get('show_my_collection', [App\Http\Controllers\CollectionController::class, 'show_my_collection']);
        Route::post('show_my_collection_file', [App\Http\Controllers\CollectionController::class, 'show_my_collection_file']);
        Route::post('show_all_users_not_in_collection', [App\Http\Controllers\CollectionController::class, 'show_all_users_not_in_collection']);


    });

    Route::group(['middleware' => ['public_collection']], function () {

        Route::post('add_file_to_collection', [App\Http\Controllers\CollectionController::class, 'add_file_to_collection']);
        Route::post('delete_file_from_collection', [App\Http\Controllers\CollectionController::class, 'delete_file_from_collection']);

    });


    Route::group(['middleware' => ['Collection_owner']], function () {

        Route::post('add_user_to_collection', [App\Http\Controllers\CollectionController::class, 'add_user_to_collection']);
        Route::post('delete_user_from_collection', [App\Http\Controllers\CollectionController::class, 'delete_user_from_collection']);
        Route::post('destroy', [App\Http\Controllers\CollectionController::class, 'destroy']);

    });




});

/////batool
Route::get('logout', ['middleware' => 'auth:sanctum',
    'uses' => 'App\Http\Controllers\UserController@logout'
]);

Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('logout', ['middleware' => 'auth:sanctum',
    'uses' => 'App\Http\Controllers\UserController@logout'
]);

Route::post('register', [
    'uses' => 'App\Http\Controllers\UserController@register'
]);

Route::get('OwnerToCollection', [
    'middleware' => 'Role:owner',
    'uses' => 'App\Http\Controllers\UserCollectionController@OwnerToCollection'
]);
//
//Route::get('index',[
//    'middleware' => 'Role:owner',
//    'uses' => 'App\Http\Controllers\UserCollectionController@index'
//]);

/////boshra
//create && delete && display file && check_in && check_out
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('file/check_in/{id}' , [FileController::class , 'check_in']) ;
    Route::post('file/check_out/{id}' , [FileController::class , 'check_out']) ;
    Route::resource('file' , FileController::class)->except('edit' , 'create') ;
    Route::get('mycollection', [FileController::class ,'myCollection']);

});
