<?php

namespace ChatBox\Http\Controllers;

use ChatBox\Models\User;
use ChatBox\Models\Status;
use Illuminate\Http\Request;
use Auth;


class StatusController extends Controller{

	// Add a new status
	public function postStatus(Request $request){

		$this->validate($request,[
			'status'    =>  'required|max:1000',
		]);

		Auth::user()->statuses()->create([
			'body'  =>  $request->input('status'),
		]);

		return redirect()
			->route('home')
			->with('info', 'Status posted');
	}

	// Add a new reply to a status
	public function postReply(Request $request, $statusId){

		$this->validate($request, ["reply-{$statusId}" => 'required|max:1000',
		], [
			'required'  =>  'The reply body is required'
		]);

		// Find the status that the reply belongs to
		$status = Status::notReply()->find($statusId);


		// Fail if the status doesn't exist
		if (!$status){
			return redirect()
				->route('home');
		}

		// Check if the currently authenticated user is friends with the owner of this status and not his own status
		if (!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id){
			return redirect()
				->route('home');
		}

		// Get the reply
		$reply = Status::create([
			'body'  =>  $request->input("reply-{$statusId}"),
		])->user()->associate(Auth::user());

		// Reply is saved using the REPLiES method
		$status->replies()->save($reply);

		return redirect()->back();

	}

}