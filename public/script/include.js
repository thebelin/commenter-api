/**
 * include.js
 * 
 * A widget injector class for remote inclusion of scripts and page content in pure javascript
 *
 * @author Belin Fieldson <thebelin@gmail.com>
 * @copyright MIT
 * 
 * @param Object d      A reference to the document object
 * @param Object config An object literal containing config data for the includer using these keys:
 *                      .sources Array    Scripts to include as strings which are the src attribute
 *                      .styles  Array    The stylesheet href attributes
 *                      .widgets Object   The html dom elements listed by id to insert or fill with html as value
 *                      .init    Function A function to run after all the classes are included
 */
(function (d, config) {
  // @type array An array of the javascript src files to load for this app
  config.sources = (config.sources instanceof Array) ? config.sources : [];

  // @type array An array of the src locations for styles to load for this app
  config.styles = (config.styles instanceof Array) ? config.styles : [];

  // @type object Each key is an id of a div on the page to inject content
  //              into, and the value is the content
  config.widgets = (typeof config.widgets === 'object') ? config.widgets : {};

  // @type function A function to run after the scripts have all been included
  config.init = (typeof config.init === 'function') ? config.init : function () {};

  // @type integer What index of the sources array is currently being processed
  config._scriptId = 0;

  // @type integer What index of the styles array is currently being processed
  config._styleId = 0;
  
  // @type function Check if a script with the specified src already exists
  config._scriptExists = function (newSrc) {
    // @type array All script elements
    config._scripts = d.getElementsByTagName("script");
    for (var i = 0; i < config._scripts.length; i++) {
      if (config._scripts.src === newSrc) {
        return true;
      }
    }
    return false;
  };

  // @type function Check if the style with the specified src already exists
  config._styleExists = function (newSrc) {
    // @type array All script elements
    config._styles = d.getElementsByTagName("style");
    for (var i = 0; i < config._styles.length; i++) {
      if (config._styles[i].href === newSrc) {
        return true;
      }
    }
    return false;
  };

  // @type function Add an element and fill it in the page body
  // @param {string} elemId  The id attribute of the element which houses the content
  // @param {string} html    The html to fill the element with
 config._appendToBody = function (elemId, html) {
    // Check if the target div(s) exist
    var elem = d.getElementById(elemId);
    if (elem === null) {
      // If there's a document body, add to it, otherwise wait for it
      if (d.body) {
        // create divs which don't exist
        elem = d.createElement('div');
        elem.setAttribute('id', elemId);
        elem.innerHTML = html;
        d.body.appendChild(elem);
      } else {
        setTimeout(function () {
          config._appendToBody(elemId, html);
        }, 100);
      }
    } else {      
      // Add the content html to the anchor divs
      elem.innerHTML = html;
    }
  };

  // @type function Do an injection on the head element
  // @param {string}   elemType The type of element to add script|style
  // @param {string}   src      The location of the source content
  // @param {Function} callback A function to call after loading
  // @param {bool}     doAsync  Whether to load async
  // @param {object}   node     An object to be replaced in the function body
  // @return {void}
  config._inject = function (elemType, src, callback, doAsync, node) {
    if (src) {
      // handle style or script injections
      if (elemType === 'style') {
        node       = d.createElement('link');
        node.type  = 'text/css';
        node.rel   = 'stylesheet';
        node.href  = src;
        node.media = 'screen';
      } else {
        node       = d.createElement(elemType || 'script');
        node.type  = 'text/javascript';
        node.src   = src;
      }
      node.async  = doAsync || false;
      // Set the callback for the load event of the element if it's been provided
      if (typeof callback === 'function') {
        node.onload = callback;
      }
      // Append the node element to the head
      d.getElementsByTagName('head')[0].appendChild(node);
    }
  };

  // @type function Load the scripts, using the previously defined values
  config._loadScripts = function () {
    // If the script is within the boudaries of the array
    // and the script doesn't already exist in the page
    if (config._scriptId < config.sources.length
      && !config._scriptExists(config.sources[config._scriptId])
      ) {
      // inject it as a script with the src specified.
      config._inject(
        'script',
        config.sources[config._scriptId],
        // callback function to do after inject completes
        function () {
          // iterate the scriptId
          config._scriptId ++;
          // only run init after the loads are complete 
          if (config._scriptId === config.sources.length) {
            config.init();
          } else {
            config._loadScripts();
          }
        },
        true
      );
    }
  };

  // @type function Load the styles
  config._loadStyles = function () {
    // If the style is within the boudaries of the array
    // and the style doesn't already exist in the page
    if (config._styleId < config.styles.length
      && !config._styleExists(config.styles[config._styleId])
      ) {
      config._inject(
        'style',
        config.styles[config._styleId],
        function () {
          // iterate the styleId on completion and call the loader again
          config._styleId ++;
          if (config._styleId < config.styles.length) {
            config._loadStyles();
          }
        }
      );
    }
  };

  // Inject the styles into the head
  config._loadStyles();

  // Inject the scripts into the head
  config._loadScripts();

  // Add the widget elements to the html dom of the source page
  for (var widgetId in config.widgets) {
    config._appendToBody(widgetId, config.widgets[widgetId]);
  }

}(document, {
  // Script Sources to be used in the page
  sources : [
    "//ajax.googleapis.com/ajax/libs/angularjs/1.3.1/angular.min.js",
    "//www.google.com/recaptcha/api/js/recaptcha_ajax.js",
    "/script/angular-recaptcha.min.js",
    "/script/commenterClient.js"
  ],

  // Style sources to be added to the page  
  styles : [
    "//netdna.bootstrapcdn.com/twitter-bootstrap/2.0.4/css/bootstrap-combined.min.css",
    "//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css"
  ],

  // widgets with the id of the element to add them to
  widgets : {
    commenter: "<div class='test' data-test-data='test'><h1><i class='fa fa-wrench'></i>&nbsp;Work in progress</h1></div>",
    article:   "<div class='testArticle' data-test-data='the real article'></div>"
  },

  // This function is run when all the things are done
  init : function () {
    console.log('running init');
  }

}));