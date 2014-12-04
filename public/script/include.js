/**
 * include.js
 * 
 * A widget injector class for remote inclusion of scripts in pure javascript
 *
 * @author Belin Fieldson <thebelin@gmail.com>
 *
 * @paran Object d      A reference to the document object
 * @param Object config An object literal containing config data for the includer
 *                      .sources Array    Scripts to include as strings which are the src attribute
 *                      .init    Function A function to run after all the classes are included 
 */
(function (d, config) {
  // @type array An array of the javascript src files to load for this app
  config.sources = (config.sources instanceof Array) ? config.sources : [];

  // @type array An array of the javascript src files to load for this app
  config.widgets = (typeof config.widgets === 'object') ? config.widgets : {};

  // @type function A function to run after the scripts have all been included
  config.init = (typeof(config.init) === 'function') ? config.init : function () {};

  // @type array All script elements
  config._scripts = d.getElementsByTagName("script");

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

  // @type function Load the scripts, using the previously defined values
  //
  // @param script establishes the script variable which will be replaced
  config._loadScripts = function (script) {
    if (config._scriptId < config.sources.length) {
      script = d.createElement('script');
      script.type = 'text/javascript';
      script.async = true;
      // When the script loads, it should either load the next
      // script, or run the init if all the scripts are complete
      script.onload = function () {
        config._scriptId ++;
        if (config._scriptId === config.sources.length) {
          config.init();
        } else {
          config._loadScripts();
        }
      };
      script.src = config.sources[config._scriptId];
      d.getElementsByTagName('head')[0].appendChild(script);
    }
  };
  console.log('config.widgets:', config.widgets);
  // Add the anchor elements to the html of the source page
  for (var widgetId in config.widgets) {
    // Check if the target div(s) exist
    var elem = d.getElementById(widgetId);
    if (elem === null) {
      // create divs which don't exist
      elem = d.createElement('div');
      elem.setAttribute('id', widgetId);
      elem.innerHTML = config.widgets[widgetId];
      
      // If there's a document body, add to it, otherwise wait for it
      if (d.body) {
        d.body.appendChild(elem);
      } else {
        d.setTimeout(function() {
          d.body && d.body.appendChild(elem)
        }, 500);
      }
    } else {      
      // Add the content html to the anchor divs
      elem.innerHTML = config.widgets[widgetId];
    }
  }

  // Inject the classes which don't already exist into the head
  config._loadScripts();

}(document, {
  // Script Sources to be used in the page
  sources : [
    "//ajax.googleapis.com/ajax/libs/angularjs/1.3.1/angular.min.js",
    "//www.google.com/recaptcha/api/js/recaptcha_ajax.js",
    "/script/angular-recaptcha.min.js",
    "/script/commenterClient.js"
  ],
  // widgets with the id of the element to add them to
  widgets : {
    commenter : "<div class='test'></div>"
  },
  init : function () {
    console.log('running init');
  }

}));