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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
Route::group(['namespace' => 'Chat'], function () {
	Route::get('chat','ChatController@index')->name('api.getredis');

	Route::post('userOnline','ChatController@userOnline')->name('api.user.online');

	Route::post('roomChat','ChatController@roomChat')->name('api.redis.room');

	Route::post('privateChat','ChatController@privateChat')->name('api.redis.private');


});
