<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Comments</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
		.commentBox {
			max-width: 400px;
			padding: 5px;
		}
		.welcome {
			font-weight:bold;
			width:100%;
		}
		.gravatarImage {
			height :50px;
			width: 50px;
			float: left;
			margin-right: 10px;
		}
		.commenterItem {
			min-height:50px;
			width:100%;
			margin-bottom:5px;
			float:left;
		}
		.commenterForm {
			float:left;
			background-color: #cfcfcf;
			border-radius:5px;
			padding:5px;
			color:#000;
			text-shadow: 1px 1px #fff;
			width:450px;
		}
		.commenterForm > textarea {
			height:5em;
			width:98%;
			border-radius: 5px;
		}
		.commenterComment {
			max-width:450px;
			text-align: left;
		}
		.commenterButton {
			margin-top:.5em;
			height: 3em;
			width: 10em;
			border-radius: 5px;
			text-shadow: 1px 1px #000;
			box-shadow: 1px 1px #000;
			color: #fff;
			font-size:1.2em;
		}
		.commentList {
			max-height: 10em;
			overflow-y: auto;
			border: 1px solid #000;
			border-radius: 5px;
			padding: 5px;
			width: 450px;
		}
		input[name='email'] {
			margin-bottom:.5em;
		}
	</style>
	<script type="text/javascript" src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.3.1/angular.min.js"></script>
	<script type="text/javascript" src = "//www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
	<script type="text/javascript" src = "/script/angular-recaptcha.min.js"></script>
	<script type="text/javascript" src = "/script/commenterClient.js"></script>

</head>

<body>
	<div data-ng-app = "CommenterApp" data-ng-controller = "CommenterController" class = "commentBox">
		<div class="welcome">
			<b>Comments:</b>
		</div>
		<div class = "commentList" id = "commentList"
			data-ng-scroll = "listScroll()">
			<div
				data-ng-repeat      = "comment in comments"
				data-boundary-links = "true"
				class               = "commenterItem"	
				data-message-id     = "{{comment.id}}" >
					<img 
					  class      = "gravatarImage"
					  data-ng-src = "http://www.gravatar.com/avatar/{{comment.gravatar}}.png"
					  data-email = "{{comment.email}}" >
					  <!-- THis should contain the gravatar image -->
					</img>
					<div class = "commenterComment">
						{{comment.message}}
					</div>
			</div>
		</div>
		<div class = "commenterForm">
			<label for = "commenterComment">Your Comment:</label>
			<textarea id = "commenterCommentEntry" data-ng-model = "commentItem.message"></textarea>
			<div data-ng-if = "commentItem.message">
				<label for = "commenterEmail">Your Email:</label>
				<input type = "text" name = "email" data-ng-model = "commentItem.email"/>
			</div>
			<div
				data-ng-if = "commentItem.email"
				vc-recaptcha
				theme    = "clean"
				lang     = "en"
	        	ng-model = "commentItem.captcha"
	        	key      = "'6Lf10f0SAAAAAF1wRn6VEjGvr6YTnH_XypcTmPrs'"
			></div>
			<input class = "commenterButton" type = "button"
				data-ng-if = "commentItem.captcha"
				data-ng-click = "addComment()" value = "Comment"></input>
		</div>
	</div>
</body>
</html>