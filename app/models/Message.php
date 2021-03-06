<?php
// This makes the Messages object available as an Elequent object
// It will have all sorts of default properties and attributes due to that
class Message extends Eloquent {

	protected $fillable = array('email','message');

	public function thread()
	{
		return $this->belongsTo('Thread');
	}
	public function user()
	{
		return $this->hasOne('User');
	}
	public function upvote()
	{
		return $this->hasMany('upvote');
	}

	public function downvote()
	{
		return $this->hasMany('downvote');
	}

}
