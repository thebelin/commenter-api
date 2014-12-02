angular.module('CommenterApp', ['vcRecaptcha'])
  // Declare the controller with all the required libraries
  .controller('CommenterController', ['$scope', '$http',
    function ($scope, $http) {
      // Adding to $scope is like creating new variables for the page
      $scope.comments     = [];
      $scope.commentItem  = {url: window.location.href};
      $scope.recaptchaKey = '6Lf10f0SAAAAAF1wRn6VEjGvr6YTnH_XypcTmPrs';

      // infinite scroll variables
      $scope.currentRecord = 0;
      $scope.getPerTrip    = 5;
      
      console.log('size of recordset: ' + $scope.currentRecord);
      $scope.numPages = function () {
        return Math.ceil($scope.comments.length / $scope.numPerPage);
      };

      // @type function Get the local data store from the jsonp server
      // @param start (optional) The start point to get records
      // @param count (optional) How many records to get
      $scope.getComments = function (start, count) {
        // Default the arguments
        start = start || 0;
        count = count || $scope.getPerTrip;

        // Call the list route with the limits
        $http.jsonp('/messages/list/'+ start + '/' + count + '?callback=JSON_CALLBACK').
          success(function(data, status, headers, config) {
            if (data.messages) {

              console.log('got data:', data);
              // Add the retrieved messages to the currently held data
              $scope.comments = $scope.comments.concat(data.messages);

              // record the current record for the infinite scroll
              $scope.currentRecord = $scope.comments.length;

              console.log('size of recordset: ' + $scope.currentRecord);
            }
          });
      };

      // @type function Determine if the comment is valid
      $scope.isValidComment = function () {
        // Examine the comment and make sure it's ready to send
        if (!$scope.commentItem.email || !$scope.commentItem.message) {
          return false;
        }
        return true;
      };

      // @type function Send the data for the new comment
      $scope.addComment = function () {
        if ($scope.isValidComment()) {
          // Add the captcha data to the information being posted to the server
          $http.post({
            method: 'POST',
            url:    'http://testUser:secret@localhost:8000/messages/add',
            data:   $scope.commentItem
          }).success(function(data, status, headers, config) {
              // clear the comment item
              $scope.commentItem = {url: window.location.href};
              // Do the listScroll method simulating a scroll event
              $scope.listScroll();
            });
        } else {
          // THe user attempted to add invalid content
          console.log('comment invalid', JSON.stringify($scope.commentItem));
        }
      };

      // Infinite scroll data grabber
      $scope.listScroll = function () {
        if (typeof $scope.commentElem === 'object') {          
          // If the scroller has reached the bottom of the records, get more
          if ($scope.commentElem.scrollTop + $scope.commentElem.clientHeight >= $scope.commentElem.scrollHeight) {
            console.log('infinite scroll activated');
            $scope.getComments($scope.currentRecord, $scope.getPerTrip);
          }

        }
      }
      // Actually get the comments into the local angular datastore
      $scope.getComments();

      // Attach the scroll event in the commentList to the infinte fetch routine
      $scope.commentElem = document.getElementById('commentList');
      if ($scope.commentElem !== 'undefined') {
        $scope.commentElem.onscroll = $scope.listScroll;
      }

    }
  ]);