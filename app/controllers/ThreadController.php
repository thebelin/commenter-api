<?php

class ThreadController extends BaseController {

    /**
     * Respond with all the messages from the thread matching criteria
     *
     * @param $threadId unsigned The thread identifier
     * @param $start    integer  (optional) Where to start the return
     * @param $howMany  integer  (optional) How many items to return
     * @param $reverse  boolean  (optional) Whether to reverse the order of return (latest first)
     * 
     * @return JSONP Response
     */
    public function all ($threadId, $start = 0, $howMany = 5, $reverse = false)
    {        
        $messages = Message::where(
            'thread_id',
            '=',
            $threadId
        )->skip($start)->take($howMany);

        if ($reverse) {
            $messages = $messages->orderBy('updated_at', 'DESC', 'id', 'DESC');
        }
        
        $messages = $messages->get();

        //Log::info(__METHOD__ . "messages:", $messages);

        // Load up a keyed object with the messages from the database
        //$messages = array('messages' => Message::all()->skip($start)->take($howMany));

        // Send those messages to the JSON render of the Response engine
        return Response::json(array('messages' => $messages))->setCallback(Input::get('callback'));
    }

    /**
     * Create a new message
     * 
     * @return JSONP Response
     */
    public function add ()
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
