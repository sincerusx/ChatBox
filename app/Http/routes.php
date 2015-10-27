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
 * User Authentication
 */

Route::get('signup', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@getSignUp',
	'as'    =>  'auth.signup',
	'middleware'    =>  ['guest'],
]);

Route::post('signup', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@postSignUp',
	'middleware'    =>  ['guest'],
]);

Route::get('signin', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@getSignIn',
	'as'    =>  'auth.signin',
	'middleware'    =>  ['guest'],
]);

Route::post('signin', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@postSignIn',
	'middleware'    =>  ['guest'],
]);

Route::get('signout', [
	'uses'  =>  '\ChatBox\Http\Controllers\AuthController@getSignOut',
	'as'    =>  'auth.signout',
]);


/*
 * Search
 */

Route::get('/search',[
	'uses'  =>  '\ChatBox\Http\Controllers\SearchController@getSearchResults',
	'as'    =>  'search.results',
]);

/*
 * User Profile
 */
Route::get('/user/{username}', [
	'uses'  =>  '\ChatBox\Http\Controllers\ProfileController@getProfile',
	'as'    =>  'profile.index'
]);