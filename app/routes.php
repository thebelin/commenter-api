<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// Base route handles users showing up at the url and creates an interface
Route::any('/', function () {
	return View::make('comments');
});

// @todo Create a route for script injection of comment widget

// All messages routes
Route::controller('messages', 'MessageController');


Route::get('/authtest', array('before' => 'auth.basic', function()
{
    return View::make('hello');
}));