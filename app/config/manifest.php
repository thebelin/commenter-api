<?php
/**
 * A manifest for the client side requirements of the app
 */
return [
	/**
	 * The javascript sources of files required by the injector routine of
	 * the app, in order of requirement
	 */
	'sources' => [
	    "//ajax.googleapis.com/ajax/libs/angularjs/1.3.1/angular.min.js",
	    "//www.google.com/recaptcha/api/js/recaptcha_ajax.js",
	    "/script/angular-recaptcha.min.js",
	    "/script/commenterClient.js"
	],

	/**
	 * The style resources used by the app, for inclusion in the head
	 */
	'styles' => [
		"/style/comments.css",
	    "//netdna.bootstrapcdn.com/twitter-bootstrap/2.0.4/css/bootstrap-combined.min.css",
	    "//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css"
	]
];
