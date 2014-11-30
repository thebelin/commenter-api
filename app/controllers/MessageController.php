<?php

class MessageController extends BaseController {

	/**
	 * Respond with all the messages matching criteria
	 * 
	 * @param $start   integer (optional) Where to start the return
	 * @param $howMany integer (optional) How many items to return
	 * 
	 * @return JSONP Response
	 */
	public function anyList ($start = 0, $howMany = 5)
	{
		Log::info(__METHOD__ . "start: {$start} howMany {$howMany}");
		
		$messages = array('messages' => DB::table('messages')->skip($start)->take($howMany)->get());

		// Load up a keyed object with the messages from the database
		//$messages = array('messages' => Message::all()->skip($start)->take($howMany));

		// Send those messages to the JSON render of the Response engine
		return Response::json($messages)->setCallback(Input::get('callback'));
	}

	/**
	 * Create a new message
	 * 
	 * @return JSONP Response
	 */
	public function anyAdd()
	{
		// Get the "data" Post item
		$args = Input::get('data', array());

		// Examine the args and make sure all the required data is intact
		if (!isset($args['email'])) {
			return "ERROR - NO EMAIL". json_encode($args);
		}

		if (!isset($args['message'])) {
			return "ERROR - NO MESSAGE";
		}

		if (! isset($args['url'])) {
			return "ERROR - NO URL";
		}

		// Set the gravatar field to the user email signature
		$args['gravatar'] = md5($args['email']);

		// Set the hosturl value
		$args['hostUrl'] = $args['url'];
		unset($args['url']);

		Log::info(__METHOD__ . "args:".json_encode($args));
		// Add this message to the database and return it
		return Response::json(Message::create($args));
	}

}
