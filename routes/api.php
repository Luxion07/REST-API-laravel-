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

Route::post('get-all-users', 'Api\UserController@getAll');

Auth::routes();

Route::group(['middleware' => 'auth:api'], function(){
	Route::post('get-user', 'Api\UserController@getCurrentUser');
	Route::post('update-user', 'Api\UserController@updateCurrentUser');
	Route::get('{id}/like-user', 'Api\UserController@LikeUser');
	Route::get('get-user-by-id/{id}', 'Api\UserController@getUser');


});

Route::get('connect', function (Request $request) {
	$http = new GuzzleHttp\Client;
	$response = $http->post('http://rest-api.webdill.com/oauth/token', [
		'form_params' => [
			'grant_type' => 'password',
			'client_id' => 1,
			'client_secret' => 'UfW3BCX520pLE7isTsm2JFXT0cQqcXyTFsaiyWNb',
			'username' => $request->username,
			'password' => $request->password,
			'scope' => '',
		],
	]);

	return json_decode((string) $response->getBody(), true);

});


