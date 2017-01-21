/**
 * Sets the 'is-active' class to the correct menu element.
 */
let setupIsActiveMenuClass = () => {
  (() => {
    let location = window.location.pathname;
    let anchors = document.querySelectorAll('.nav-right > .nav-item');
    anchors.forEach((el) => {
      if (location === el.getAttribute('href')) {
        el.className += ' is-active';
      }
    });

  })();
};

/**
 * Sets the mobile menu on/off toggle
 */
let setupMenuToggle = () => {
  document.querySelector('.nav-toggle').addEventListener('click', () => {
    let burger = document.querySelector('.nav-toggle');
    let menu = document.querySelector('.nav-menu');
    burger.classList.toggle('is-active');
    menu.classList.toggle('is-active');
  });
};

let setupHighlight = () => {
  let blocks = document.querySelectorAll('pre code');
  blocks.forEach((block) => {
    hljs.highlightBlock(block);
  })
};

/**
 * Closes notifications
 */
let setupNotifications = () => {
  document.querySelectorAll('.notification').forEach((el) => {
    el.addEventListener('click', (e) => {
      e.target.parentNode.parentNode.removeChild(e.target.parentNode)
    });
  });
};

let socialPopup = (url, width, height) => {
  let left = (screen.width / 2) - (width / 2);
  let top = (screen.height / 2) - (height / 2)
  window.open(
    url,
    "",
    "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=" + width + ",height=" + height + ",top=" + top + ",left=" + left
  );
};

let setupSocialShare = () => {
  let shares = document.querySelectorAll('.social-share');
  if (shares.length > 0) {
    shares.forEach((share) => {
      share.addEventListener('click', (e) => {
        e.preventDefault();
        let width = share.dataset.width || 500;
        let height = share.dataset.height || 300;
        if (share.href.includes('https://www.reddit.com/submit/?url=')) {
          share.href += '&title=' + document.title;
        }
        socialPopup(share.href, width, height);
      });
    });
  }
};

/**
 * Runs when document is ready
 */
let callback = () => {

  setupIsActiveMenuClass();
  setupMenuToggle();
  setupNotifications();
  setupHighlight();
  setupSocialShare();
};

/**
 * Our document ready function.
 * This site uses plain JavaScript on public pages
 * and Vue.js on admin pages so no jQuery...
 */
(() => {
  if (document.readyState === "complete" ||
    (document.readyState !== "loading" && !document.documentElement.doScroll)) {
    callback();
  } else {
    document.addEventListener("DOMContentLoaded", callback);
  }
})();

/**
 * Checks if a tracking ID exists in window.myapp namespace
 * and invokes Google analytics.
 */
(function (){

  if (window.myapp.trackingId !== undefined && window.myapp.trackingId !== '') {
    (function (i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function () {
          (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
      a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', window.myapp.trackingId, 'auto');
    ga('send', 'pageview');
  }

})();

//# sourceMappingURL=public.js.map
