// Bellow are two versions of all functions, the commented out is ES6
// because I am missing something, webpack does not transpile to ES6
// this file for some reason resulting breakage to gulp-uglify...
// Either way the comments are stripped in production files.

/**
 * Sets the 'is-active' class to the correct menu element.
 */
// let setupIsActiveMenuClass = () => {
//   (() => {
//     let location = window.location.pathname;
//     let anchors = document.querySelectorAll('.nav-right > .nav-item');
//     anchors.forEach((el) => {
//       if (location === el.getAttribute('href')) {
//         el.className += ' is-active';
//       }
//     });
//
//   })();
// };

var setupIsActiveMenuClass = function () {
  var location = window.location.pathname;
  var anchors = document.querySelectorAll('.nav-right > .nav-item');

  anchors.forEach(function(el) {
    if (location === el.getAttribute('href')) {
      el.className += ' is-active';
    }
  });

};

/**
 * Sets the mobile menu on/off toggle
 */
// let setupMenuToggle = () => {
//   document.querySelector('.nav-toggle').addEventListener('click', () => {
//     let burger = document.querySelector('.nav-toggle');
//     let menu = document.querySelector('.nav-menu');
//     burger.classList.toggle('is-active');
//     menu.classList.toggle('is-active');
//   });
// };

var setupMenuToggle = function () {
  document.querySelector('.nav-toggle').addEventListener('click', function() {
    var burger = document.querySelector('.nav-toggle');
    var menu = document.querySelector('.nav-menu');
    burger.classList.toggle('is-active');
    menu.classList.toggle('is-active');
  });
};

// let setupHighlight = () => {
//   let blocks = document.querySelectorAll('pre code');
//   blocks.forEach((block) => {
//     hljs.highlightBlock(block);
//   })
// };

var setupHighlight = function () {
  var blocks = document.querySelectorAll('pre code');
  blocks.forEach(function(block) {
    hljs.highlightBlock(block);
  });
};

/**
 * Closes notifications
 */
// let setupNotifications = () => {
//   document.querySelectorAll('.notification').forEach((el) => {
//     el.addEventListener('click', (e) => {
//       e.target.parentNode.parentNode.removeChild(e.target.parentNode)
//     });
//   });
// };

var setupNotifications = function () {
  document.querySelectorAll('.notification').forEach(function(el) {
    el.addEventListener('click', function(e) {
      e.target.parentNode.parentNode.removeChild(e.target.parentNode)
    });
  });
};

/**
 * Pop up social shares
 */
// let socialPopup = (url, width, height) => {
//   let left = (screen.width / 2) - (width / 2);
//   let top = (screen.height / 2) - (height / 2)
//   window.open(
//     url,
//     "",
//     "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
//   );
// };

var socialPopup = function (url, width, height) {
  var left = (screen.width / 2) - (width / 2);
  var top = (screen.height / 2) - (height / 2)
  window.open(
    url,
    "",
    "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
  );
};

// let setupSocialShare = () => {
//   let shares = document.querySelectorAll('.social-share');
//   if (shares.length > 0) {
//     shares.forEach((share) => {
//       share.addEventListener('click', (e) => {
//         e.preventDefault();
//         let width = share.dataset.width || 500;
//         let height = share.dataset.height || 300;
//         if (share.href.includes('https://www.reddit.com/submit/?url=')) {
//           share.href += '&title=' + document.title;
//         }
//         socialPopup(share.href, width, height);
//       });
//     });
//   }
// };

/**
 *
 */
var setupSocialShare = function () {
  var shares = document.querySelectorAll('.social-share');
  if (shares.length > 0) {
    shares.forEach(function(share) {
      share.addEventListener('click', function(e) {
        e.preventDefault();
        var width = share.dataset.width || 500;
        var height = share.dataset.height || 300;
        if (share.href.includes('https://www.reddit.com/submit/?url=')) {
          share.href += '&title=' + document.title;
          socialPopup(share.href, 850, height);
        } else {
          socialPopup(share.href, width, height);
        }
      });
    });
  }
};

var setupEnlargeImage = function() {
  var magnify = document.querySelector('.magnify');

  if (magnify === null) {
    return;
  }

  var images = document.querySelector('.entry');
  var container = document.querySelector('.container');

  if (images !== null) {
    images = images.querySelectorAll('img:not(.noseen)');

    images.forEach(function(img) {
      var clone = img.cloneNode();

      var span = document.createElement('span');
      var txt = document.createTextNode('click on image to zoom');
      span.classList.add('light-notice', 'font-normal');
      span.appendChild(txt);

      img.parentNode.appendChild(span);
      // listen for click and zoom
      img.addEventListener('click', function(e){
        container.classList.add('is-hidden');
        magnify.appendChild(clone);
        magnify.classList.toggle('is-hidden');
      });

      // listen for click to zoom out back to normal
      magnify.addEventListener('click', function (e) {
        if (magnify.contains(clone)) {
          container.classList.remove('is-hidden');
          magnify.classList.toggle('is-hidden');
          magnify.removeChild(clone);
        }
      })
    });
  }
};


/**
 * Runs when document is ready
 */
// let callback = () => {
//
//   setupIsActiveMenuClass();
//   setupMenuToggle();
//   setupNotifications();
//   setupHighlight();
//   setupSocialShare();
// };

var callback = function () {
  setupIsActiveMenuClass();
  setupMenuToggle();
  setupNotifications();
  setupHighlight();
  setupSocialShare();
  setupEnlargeImage();
};

/**
 * Our document ready function.
 * This site uses plain JavaScript on public pages
 * and Vue.js on admin pages so no jQuery...
 */
(function() {
  if (document.readyState === "complete" ||
    (document.readyState !== "loading" && !document.documentElement.doScroll)) {
    callback();
  } else {
    document.addEventListener("DOMContentLoaded", callback);
  }
})();
