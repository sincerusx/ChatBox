<?php
/**
 * Created by PhpStorm.
 * User: lmjnels
 */

namespace ChatBox\Http\Controllers;

use Auth;
use ChatBox\Models\User;
use Illuminate\Http\Request;


class FriendController extends Controller{
	public function getIndex(){
		$friends = Auth::user()->friends();
		return view('friends.index')
			->with('friends', $friends);
	}
}