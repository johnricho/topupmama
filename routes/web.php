<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {
	Route::get('', function () {
		return response()->json([
			'status' => 'success',
			'author' => 'John Ojebode (Johnricho)',
			'message' => 'You are welcome to my TopupMama Assessment restful api!'
		],200);
	});
	return response()->json([
		'status' => 'failed',
		'message' => 'Sorry, unauthorized access.'
	],401);
});

