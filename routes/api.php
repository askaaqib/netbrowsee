<?php

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
Route::post('login', 'Api\ApiController@userAuthenticate')->name('authenticate');
Route::get('getJobCards', 'Api\ApiController@getJobCards')->name('getJobCards');
Route::get('getSettingsInfo', 'Api\ApiController@getSettingsInfo')->name('getSettingsInfo');
Route::get('getUserInfo', 'Api\ApiController@getUserInfo')->name('getUserInfo');
Route::post('updateUserInfo', 'Api\ApiController@updateUserInfo')->name('updateUserInfo');
Route::get('getJobcard', 'Api\ApiController@getJobcard')->name('getJobcard');
