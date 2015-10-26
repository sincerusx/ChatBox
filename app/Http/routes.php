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


/*
 * Home
 */

Route:: get('/', [
	'uses'	=>	'\ChatBox\Http\Controllers\HomeController@index',
	'as'	=>	'home'
]);


/*
 * Alert
 */

Route::get('/alert', function(){
	return redirect()->route('home')->with('info', 'You have signed up!');
});


/*
 * Authentication
 */

Route::get('signup', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@getSignUp',
	'as'    =>  'auth.signup',
]);

Route::post('signup', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@postSignUp',
]);

Route::get('signin', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@getSignIn',
	'as'    =>  'auth.signin',
]);

Route::post('signin', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@postSignIn',
]);

Route::get('signout', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@getSignOut',
	'as'    =>  'auth.signout',
]);
