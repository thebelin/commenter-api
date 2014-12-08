<?php

class InjectController extends BaseController {
	public function inject () {
	    $configObj = new ConfigController;
	    $response = Response::make(
	        View::make('includer')->with('config', $configObj->getConfig())
	    );
	    $response->header('Content-Type', 'application/javascript');
	    return $response;
	}
}
