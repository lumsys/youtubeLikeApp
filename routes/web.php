<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controller\YoutubeController;

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

Route::get('/','YoutubeController@index')->name('index');
Route::get('/results','YoutubeController@results')->name('result');
Route::get('/watch','YoutubeController@watch')->name('watch');

Route::post('post', 'YoutubeController@store')->name('upload.post');
Route::get('upload', 'YoutubeController@store');
