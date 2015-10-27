<?php
/**
 * Created by PhpStorm.
 * User: lmjnels
 */

namespace ChatBox\Http\Controllers;

use ChatBox\Models\User;
use Illuminate\Http\Request;


class ProfileController extends Controller{

	public function getProfile($username){
		$user = User::where('username', $username)
			->first();

		if (!$user){
			abort(404);
		} // If user isn't found a 404 page is returned
		return view('profile.index')
			->with('user', $user);
	}

}