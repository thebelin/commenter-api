<?php
class Thread extends Eloquent { 
 	//
	// set the fillable or guarded properties on the model.
	// You've got to have one or the other to be able to pass information
	// directly into the model from the controller, just for the sake of data conformity
	//
	protected $fillable = array('name', 'heading');


	public function user()
	{
		return $this->hasOne('User');
	}

	public function site()
	{
		return $this->hasMany('Site');
	}

	public function message()
	{
		return $this->hasMany('Message');
	}

}
