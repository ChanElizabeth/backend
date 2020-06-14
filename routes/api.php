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

Route::post('login', 'User\UserController@login');

Route::post('user/logout', 'User\UserController@logout');

Route::post('admin', 'User\UserController@adminLogin');

Route::group(['middleware' => 'auth:api'], function(){
    Route::resource('user', 'User\UserController');
});

Route::resource('new', 'News\NewsController');

Route::resource('complaint', 'Complaint\ComplaintController');

Route::resource('reservation', 'Reservation\ReservationController');
