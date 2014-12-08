<div
    data-ng-app        = "CommenterApp"
    data-ng-controller = "CommenterController"

    class              = "commentBox">
    <div class="welcome">
        <b>Comments:</b>
    </div>
    <div class = "commentSort" data-ng-click = "toggleOrder()" alt = "Reverse">
        <i class = "fa fa-clock-o"></i>
        <i data-ng-class = "{fa:1, 'fa-arrow-down':!reverseSort,'fa-arrow-up':reverseSort}"></i>
    </div>
    <!-- This is the infinite scrolling content -->
    <div class = "commentList" id = "commentList"
        data-ng-scroll = "listScroll()">
        <!-- an indicator for scroll direction -->
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
    <!-- This is the end of the infinite scrolling content -->
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
