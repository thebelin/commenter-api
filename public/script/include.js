/**
 * include.js
 * 
 * A widget injector class for remote inclusion of scripts in pure javascript
 *
 * @author Belin Fieldson <thebelin@gmail.com>
 *
 * @param Object config An object literal containing config data for the includer
 *                      .classes Array    Classes to include as strings which are the src attribute
 *                      .init    Function A function to run after all the classes are included 
 */
var _includer = function (config) {
  // @type array An array of the javascript src files to load for this app
  config.sources = (config.sources instanceof Array) ? config.sources : [];

  // @type function A function to run after the scripts have all been included
  config.init = (typeof(config.init) === 'function') ? config.init : function(){};

  // @type array All script elements
  config._scripts = document.getElementsByTagName("script");

  // @type integer What index of the scripts array is currently being processed
  config._scriptId = 0;
  
  // @type function Check if the script with the specified src already exists
  config._scriptExists = function (newSrc) {
    for (var i = 0; i < config._scripts.length; i++) {
      if (config._scripts[i].src === newSrc) {
        return true;
      }
    }
    return false;
  };

  config._loadScripts = function () {
    if (config._scriptId < config.sources.length) {
      script = document.createElement('script');
      script.type = 'text/javascript';
      script.async = true;
      script.onload = function () {
        config._scriptId ++;
        if (config._scriptId === config.sources.length) {
          config.init();
        } else {
          config._loadScripts();
        }
      };
      script.src = config.sources[config._scriptId];
      document.getElementsByTagName('head')[0].appendChild(script);
    }
  };

  // @type function Determine if all the scripts have finished loading
  config._scriptsDone = function () {
    return Boolean(config.sources.indexOf(false) === -1);
  }

  // Inject the classes which don't already exist into the head
  config._loadScripts();

  // When the classes exist

  // Check if the target div(s) exist

    // create divs which don't exist

  // Add the content html to the src divs

};

_includer({
  sources : [
    "//ajax.googleapis.com/ajax/libs/angularjs/1.3.1/angular.min.js",
    "//www.google.com/recaptcha/api/js/recaptcha_ajax.js",
    "/script/angular-recaptcha.min.js",
    "/script/commenterClient.js"
  ],
  init : function () {
    console.log('running init');
  }

});