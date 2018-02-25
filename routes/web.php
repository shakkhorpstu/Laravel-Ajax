<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', 'ListController@index');
Route::post('/list', 'ListController@create');
Route::post('/delete', 'ListController@delete');
Route::post('/update', 'ListController@update');
Route::get('/search', 'ListController@search');

Route::get('/products', function () {
    return view('welcome');
});
