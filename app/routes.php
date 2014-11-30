<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
Route::any('/', function () {
	return View::make('comments');
});

// All messages routes
Route::controller('messages', 'MessageController');
