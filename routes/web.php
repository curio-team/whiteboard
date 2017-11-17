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

Route::group(['middleware' => 'auth'], function() {

	Route::get('/', 'WhiteboardController@index')->name('home');
	Route::get('signup/user/{user}/category/{category}', 'WhiteboardController@signUp');
	Route::get('signoff/user/{user}/category/{category}', 'WhiteboardController@signOff');

	Route::group(['middleware' => 'admin'], function() {

		Route::view('/admin', 'layouts.admin')->name('admin.home');
		Route::group(['prefix' => 'admin'], function(){
			Route::resource('announcements', 'AnnouncementController', ['except' => ['show']]);
			Route::resource('categories', 'CategoryController', ['except' => ['show']]);
			Route::get('categories/{category}/toggle', 'CategoryController@toggle')->name('categories.toggle');
		});

	});

});

if(env('APP_ENV') == 'production')
{
	Route::get('/amoclient/ready', function(){
		return redirect()->route('home');
	});
	Route::get('/login', function(){
		return redirect('/amoclient/redirect');
	})->name('login');
}
elseif(env('APP_ENV') == 'local')
{
	Route::view('/login', 'login.local')->name('login');
	Route::post('/login', function(){
		
		$id = request('id');
		$user = \App\User::find($id);

		if(!$user){
			$user = new \App\User();
			$user->id = $id;
			$user->name = $id;
			$user->type = 'student';
			$user->email = $id . '@rocwb.nl';
			$user->save();
		}

		\Auth::login($user);
		return redirect()->route('home');
	});

	Route::get('logout', function(){
		Auth::logout();
		return redirect()->route('login');
	});
}
