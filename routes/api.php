<?php

use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\UserCollectionController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('file' , FileController::class)->except('edit' , 'create') ;
Route::post(  '/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('logout',['middleware' => 'auth:sanctum',
    'uses' => 'App\Http\Controllers\UserController@logout'
]);

Route::post('register',[
    'uses' => 'App\Http\Controllers\UserController@register'
]);

Route::get('OwnerToCollection',[
    'middleware' => 'Role:owner',
    'uses' => 'App\Http\Controllers\UserCollectionController@OwnerToCollection'
]);
//
//Route::get('index',[
//    'middleware' => 'Role:owner',
//    'uses' => 'App\Http\Controllers\UserCollectionController@index'
//]);
