<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

// Base route handles users showing up at the url and creates an interface
// They will need to be assigned to a thread based on the site which the widget is embedded in
Route::any('/', function () {
    return View::make('hello');
});

// A route for script injection of comment widget
Route::any('/inject', function () {
    $injectObj = new InjectController;
    return $injectObj->inject();
});

// Generic route for message activities
Route::any('/api/thread/{action}/{threadid}/{arg1?}/{arg2?}/{arg3?}', function($action, $threadid, $arg1 = null, $arg2 = null, $arg3 = null)
{
    $controller = new threadController;
    if (!is_null($arg3) && !is_null($arg2) && !is_null($arg1)) {
        return $controller->$action($threadid, $arg1, $arg2, $arg3);   
    } else if (!is_null($arg2) && !is_null($arg1)) {
        return $controller->$action($threadid, $arg1, $arg2);
    } elseif (!is_null($arg1)) {
        return $controller->$action($threadid, $arg1);
    } else {
        return $controller->$action($threadid);
    }
});

/**
 * Social Authentication
 *
 * Authenticate via a social provider
 */
Route::get('auth/{provider}', [
  'uses' => 'AuthenticateController@authorise',
  'as' => 'authenticate.authorise'
]);
Route::get('auth/{provider}/callback', [
  'uses' => 'AuthenticateController@callback',
  'as' => 'authenticate.callback'
]);

// All other routes are behind auth.basic information obtained for the users
// when they request a comment interface from the above route
Route::group(array('before' => 'auth.basic'), function()
{
//
});

