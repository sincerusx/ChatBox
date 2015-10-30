<?php

namespace ChatBox\Http\Controllers;

use Auth;
use ChatBox\Models\Status;

class HomeController extends Controller{
	
	public function index(){

		if (Auth::check()){

			$statuses =  Status::notReply()->where(function($query){
				return $query->where('user_id', Auth::user()->id)
					->orWhereIn('user_id', Auth::user()->friends()->lists('id'));
			})

			->orderBy('created_at', 'desc')
			->get();


			return view('timeline.index')
				->with('statuses', $statuses);
		}

		return view('home');

	}
	
}