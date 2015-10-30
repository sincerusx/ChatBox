<?php
/**
 * Created by PhpStorm.
 * User: lmjnels
 * Date: 26/10/2015
 * Time: 16:53
 */


namespace ChatBox\Http\Controllers;

use ChatBox\Models\User;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller{

	public function getSearchResults(Request $request){

		$query = $request->input('query');

		if (!$query){
			return redirect()->route('home');
		}

		$users = User::where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$query}%")
						->orWhere('username', 'LIKE', "%{$query}%")
						->get();


		return view ('search.results')->with('users', $users);
	}


}