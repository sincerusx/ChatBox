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
		$requests = Auth::user()->friendRequests();
		return view('friends.index')
			->with('friends', $friends)
			->with('requests', $requests);
	}

	/*
	 * Send a Friend Request
	 */

	public function getAdd($username){

		// Gets requested user
		$user = User::where('username', $username)->first();

		//
		if(!$user){
			return redirect()->route('home')->with('info', 'This user could not be found');
		}

		// Prevents user from sending themselves a friend request
		if(Auth::user()->id === $user->id){
			return redirect()
				->route('home');

		}

		// Checks wether IF there is a friend request pending between the two users
		if (Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user())){
			return redirect()->route('profile.index',['username' => $user->username])
				->with('info', 'Friend request already pending');
		}

		// Checks is Auth::user is already friends with the user
		if (Auth::user()->isFriendsWith($user)){
			return redirect()
				->route('profile.index', ['username' => $user->username])
				->with('info', 'You are already friends.');
		}

		// Allows user to send a friend request
		Auth::user()->addFriend($user);

		return redirect()
			->route('profile.index', ['username' => $username])
			->with('info', 'Friend request sent');
	}

	/*
	 * Accepting a Friend Request
	 */

	public function getAccept($username){
		$user = User::where('username', $username)->first();

		// Checks if there is already a request pending
		if(!$user){
			return redirect()
				->route('home')->
				with('info', 'That user could not be found');
		}

		// Checks if thier is a friend request pending between the two
		if(!Auth::user()->hasFriendRequestReceived($user)){
			return redirect()
				->route('home');
		}

		// Checks IF users are already friends
		if ( Auth::user()->isFriendsWith($user) ) {
			return redirect()
				->route('profile.index', ['username' => $username])
				->with('info', 'You are already friends');
		}

		// Allows user to accept friend request
		Auth::user()->acceptFriendRequest($user);

		return redirect()
			->route('profile.index', ['username' => $username])
			->with('info', 'Friend request accepted.');

	}

	/*
	 * Removing a Friend
	 */

	public function postDelete($username){

		$user = User::where('username', $username)->first();

		if (!Auth::user()->isFriendsWith($user)){

			return redirect()->back();

		}

		// Delete friend
		Auth::user()->deleteFriend($user);

		return redirect()->back()->with('info', 'Friend removed.');

	}

}