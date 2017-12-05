<?php

use Illuminate\Http\Request;

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

Route::post('register', 'Api\PassportController@register');

Route::post('login', 'Api\PassportController@login');
Route::post('logout', 'Api\PassportController@logout');

Route::post('get-all-users', 'Api\UserController@getAll');



Route::group(['middleware' => 'auth:api'], function(){
	Route::post('get-user', 'Api\UserController@getCurrentUser');
	Route::post('update-user', 'Api\UserController@updateCurrentUser');
	Route::get('{id}/like-user', 'Api\UserController@LikeUser');
	Route::get('get-user-by-id/{id}', 'Api\UserController@getUser');

});



