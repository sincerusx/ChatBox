<?php
/**
 * Created by PhpStorm.
 * User: lmjnels
 * Date: 26/10/2015
 * Time: 14:43
 */


namespace ChatBox\Http\Controllers;

use Auth;
use ChatBox\Models\User;
use Illuminate\Http\Request;


class AuthController extends Controller{

	/*
	 * Sign Up
	 */


	// Get request to page
	public function getSignUp(){
		return view('auth.signup');
	}

	// Will post data to sign user up
	public function postSignUp(Request $request){
		$this->validate($request, [
			'email'     =>  'required|unique:users|email|max:255',
			'username'  =>  'required|unique:users|alpha_dash|max:20',
			'password'  =>  'required|min:6',
		]);

		User::create([
			'email'        =>  $request->input('email'),
			'username'     =>  $request->input('username'),
			'password'     =>  bcrypt($request->input('password')),
		]);

		return redirect()
			->route('home')
			->with('info', 'Your account has been created and you can now sign in.');
	}

	public function getSignIn(){
		return view('auth.signin');
	}

	/*
	 * Sign In
	 */

	public function postSignIn(Request $request){
		$this->validate($request, [
			'username'      =>  'required',
			'password'      =>  'required'
		]);

		if(!Auth::attempt($request->only(['username', 'password']), $request->has('remember'))){
			return redirect()->back()->with('info', 'Could not sign you in with those details.');
		}


		return redirect()->route('home')->with('info', 'You have sucessfully signed in!');

	}

	/*
	 * Sign Out
	 */

	public function getSignOut(){
		Auth::logout();

		return redirect()->route('home')->with('info', 'You have successfully logged out.');
	}

}