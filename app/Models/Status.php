<?php

namespace ChatBox\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model{

	// Table name defined
	protected $table = 'statuses';

	// Fillable fields in table that can be updated
	protected $fillable = [
		'body', 'parent_id'
	];

	/*
	 * Defines the relationship between the user table and the feild 'user_id'
	 * saying that the user_id can belong to many
	 */
	public function user(){
		return $this->belongsTo('ChatBox\Models\User', 'user_id');
	}

	/*
	 * A scope to limit the results to 'status updates'
	 * (Scope allows Query Builder to filter out unwanted things in the results)
	 */
	public function scopeNotReply($query){

		return $query->whereNull('parent_id');
	}

	/*
	 * Creates a relationship between the statuses (parent_id = NULL) and replies, using the parent_id as foreign key
	 */
	public function replies(){

		return $this->hasMany('ChatBox\Models\Status', 'parent_id');

	}

	/*
	 * Allows likes
	 */

	public function likes(){

		return $this->morphMany('ChatBox\Models\Like', 'likeable');

	}



}