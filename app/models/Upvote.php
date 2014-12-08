<?php
class Upvote extends Eloquent { 
 	//
	// set the fillable or guarded properties on the model.
	// You've got to have one or the other to be able to pass information
	// directly into the model from the controller, just for the sake of data conformity
	//
	protected $fillable = array('thread_id', 'message_id', 'user_id');

	public function thread()
	{
		return $this->hasOne('Thread');
	}
	public function user()
	{
		return $this->hasOne('User');
	}
	public function message()
	{
		return $this->hasone('Message');
	}

}
