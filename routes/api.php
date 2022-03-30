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


Route::group(['prefix' => ''], function () {
    return response()->json([
        'status' => 'success',
        'author' => 'John Ojebode (Johnricho)',
        'message' => 'You are welcome to my TopupMama Test restful api!'
    ],200);
});
Route::group(['prefix' => 'v1'], function () {
    Route::get('', 'BooksController@index');
    Route::get('books', 'BooksController@show');
    Route::get('books/{name?}', 'BooksController@showByName');
    Route::get('books/{id}/{name}', 'BooksController@showByGender');
    Route::get('characters', 'CharactersListController@show');
    Route::get('characters/{id}', 'CharactersListController@showById');
});
Route::group(['prefix' => 'api'], function () {
    Route::get('', 'BooksController@index');
    Route::get('books', 'BooksController@show');
    Route::get('books/{name?}', 'BooksController@showByName');
    Route::get('books/{id}/{name}', 'BooksController@showByGender');
    Route::get('characters', 'CharactersListController@show');
    Route::get('characters/{id}', 'CharactersListController@showById');
});