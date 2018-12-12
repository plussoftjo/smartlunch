<?php

use Illuminate\Http\Request;



////////// AITH

Route::post('/user/login','API\userController@login');

Route::post('/user/reg','API\userController@reg');

		



Route::group(['middleware' => 'auth:api'], function(){
		Route::get('user/details','API\userController@details');
		Route::post('/meal/store','API\mealController@store');
		Route::get('/meal/index','API\mealController@index');

		Route::post('/order/store','API\orderController@store');
		Route::get('/order/index','API\orderController@index');
		Route::get('/order/today/index','API\orderController@today');
		Route::get('/order/approve/{id}','API\orderController@approve');
	});