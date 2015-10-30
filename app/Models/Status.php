<?php

namespace ChatBox\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model{

	protected $table = 'statuses';

	protected $fillable = [
		'body', 'parent_id'
	];

	public function user(){
		return $this->belongsTo('ChatBox\Models\User', 'user_id');
	}

	public function scopeNotReply($query){

		return $query->whereNull('parent_id');
	}

	public function replies(){

		return $this->hasMany('ChatBox\Models\Status', 'parent_id');

	}



}