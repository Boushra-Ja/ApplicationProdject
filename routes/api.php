<?php

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
