<?php
class Site extends Eloquent { 
 	//
	// set the fillable or guarded properties on the model.
	// You've got to have one or the other to be able to pass information
	// directly into the model from the controller, just for the sake of data conformity
	//
	protected $fillable = array('hostUrl');

	public function thread()
	{
		return $this->belongsTo('Thread');
	}
}
