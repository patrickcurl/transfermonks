<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//this is for the main default domain that I host my main site/CMS
Route::group(['domain' => 'transfer.dev'], function(){
    //Route::get('/', function(){ return 'this is transfer.dev'; });
    Route::get('/', function(){ 
    	return view('transfer.home'); 
    });

    // Authentication routes...
	Route::get('auth/login', 'Auth\AuthController@getLogin');
	Route::post('auth/login', 'Auth\AuthController@postLogin');
	Route::get('auth/logout', 'Auth\AuthController@getLogout');

	// Registration routes...
	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');
	// Password reset link request routes...
	Route::get('password/email', 'Auth\PasswordController@getEmail');
	Route::post('password/email', 'Auth\PasswordController@postEmail');

	// Password reset routes...
	Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
	Route::post('password/reset', 'Auth\PasswordController@postReset');

	//Social Login
	Route::get('auth/login/{provider}', 'Auth\AuthController@getSocialAuth');
	Route::get('auth/login/callback/{provider}', 'Auth\AuthController@getSocialAuthCallback');
	// Route::get('auth/login/{provider}', function($provider){
	// 	return $provider;
	// });
	// Route::get('auth/login/{provider}',[
	//     'uses' => 'Auth\AuthController@getSocialAuth',
	//     'as'   => 'auth.getSocialAuth'
	// ]);


	// Route::get('auth/login/callback/{provider}',[
	//     'uses' => 'Auth\AuthController@getSocialAuthCallback',
	//     'as'   => 'auth.getSocialAuthCallback'
	// ]);
});

Route::group(['domain' => 'gadget.dev'], function(){
	Route::get('/', function(){ return 'this is gadget.dev'; });
});

//this catches the rest of the domains and all their pages:
// Route::any('{all}', 'SitesPublicController@index')->where('all', '.*');
// Route::any('{all}', function(){
// 	return view('welcome');
// });
Route::get('/', function () {
    return view('transfer.home');
});
