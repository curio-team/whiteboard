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

Route::get('/', 'CategoriesController@index');

Route::resource('categories', 'CategoriesController');
Route::post('sign_up', 'CategoriesController@signUp')->name('category.signup');
Route::post('sign_off', 'CategoriesController@signOff')->name('category.signoff');