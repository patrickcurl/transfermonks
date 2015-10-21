<?php
//use Flash;
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
    Route::get('dashboard', ['middleware' => 'auth', function() {
    // Only authenticated users may enter...
    	return dd(Auth::user());
    	return "Dashboard";
	}]);

    Route::get('login', function(){
    	return "Login";
    });
    Route::get('register', function(){
    	return dd(Input::all());
    	return "register";
    });

    Route::get('oops', function(){
    	return "oops";
    });
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
	Route::get('facebook/login', 'Auth\AuthController@getFacebookAuth');
	Route::get('facebook/callback', 'Auth\AuthController@getFacebookAuthCallback');
	Route::get('facebook/register', 'Auth\AuthController@getFacebookRegister');
	// Route::get('facebook/register', function(){
	// 	if(Session::has('fbuser') || Input::get('facebook_id')){
	// 		// return dd(Session::get('fbuser'));
	// 		session(['fbuser' => Session::get('fbuser') ]);
	// 		return view('transfer.fbregister')->with('fbuser', Session::get('fbuser'));
	// 	} else {
	// 		// $request->session()->flash('message', 'Couldn\'t authenticate with Facebook');
	// 		return redirect('/register');
	// 	}
	// 	return view('transfer.fbregister');
	// });
	Route::post('facebook/register', 'Auth\AuthController@postFacebookRegister');
	// Route::post('facebook/register', function(){
	// 	if(!Input::get('email') || !Input::get('password')){
	// 		return redirect('facebook/register')->withInput(Input::except('password', 'password_confirmation'));
	// 	}

	// 	$rules = [
	// 		'email' => 'required|email|max:255|unique:users',
 //            'password' => 'required|min:8',
 //            'password_confirmation' => 'required|same:password'
	// 	];
	// 	$validator = Validator::make(Input::all(), $rules);
	// 	if ($validator->fails()) {

 //        // get the error messages from the validator
 //        $messages = $validator->messages();

 //        // redirect our user back to the form with the errors from the validator

 //        return redirect('facebook/register')
 //            ->withErrors($validator)->withInput(Input::except('password', 'password_confirmation'));

 //   		} else {
	// 		$u = new App\User;
	// 		$u->email = Input::get('email');
	// 		$u->first_name = Input::get('first_name');
	// 		$u->last_name = Input::get('last_name');
	// 		$u->facebook_id = Input::get('facebook_id');
	// 		$u->facebook_token = Input::get('facebook_token');
	// 		$u->save();
	// 		Auth::login($u);
	// 		return redirect('/dashboard');
	// 	}
	// 	// return dd(Session::get('fbuser'));
	// });
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
