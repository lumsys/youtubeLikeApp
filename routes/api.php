<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
 });
     Route::namespace('API')->group(function () {
     Route::post('login', 'AuthController@login');
     Route::post('register', 'AuthController@register');
     Route::get('social/login', [AuthController::class, 'socialLogin']);
    
        //E-Commerce Routes Starts Here  
        Route::post('createProduct', 'ProductController@create');
        Route::get('allProducts', 'ProductController@getAllProducts');
        Route::get('getProduct/{id}', 'ProductController@getProduct');
        Route::put('UpdateProduct/{id}', 'ProductController@updateProduct');
        Route::delete('deleteProduct/{id}', 'ProductController@deleteProduct');
        //E-Commerce Routes Ends Here
     Route::middleware(['auth:api'])->group(function () {
     // User Update and related activity
        Route::get('details', 'AuthController@details');
        Route::get('logout', 'AuthController@logout');
        Route::post('updateProfile', 'AuthController@updateProfile');
        Route::post('updateProfiless', 'AuthController@updateProfiless');
        Route::post('uploadImage', 'AuthController@uploadImage');
        Route::post('edit/{id}', 'AuthController@edit');
        Route::post('updateUsertype/{id}', 'AuthController@updateUsertype');
        Route::post('uploadYoutube{id}', 'YoutubeController@uploadYoutube');

        });
    });       