"use strict";

;
(function () {
  window.console.log('[Infility Global Plugin] consent mode widget enabled');
  window.dataLayer = window.dataLayer || [];
  var gtag = function gtag() {
    window.dataLayer.push(arguments);
  };
  var options = [{
    key: 'ad_storage',
    desc: 'Enables storage, such as cookies (web) or device identifiers (apps), related to advertising.'
  }, {
    key: 'ad_user_data',
    desc: 'Sets consent for sending user data to Google for online advertising purposes.'
  }, {
    key: 'ad_personalization',
    desc: 'Sets consent for personalized advertising.'
  }, {
    key: 'analytics_storage',
    desc: 'Enables storage, such as cookies (web) or device identifiers (apps), related to analytics, for example, visit duration.'
  }, {
    key: 'functionality_storage',
    desc: 'Enables storage that supports the functionality of the website or app, for example, language settings'
  }, {
    key: 'personalization_storage',
    desc: 'Enables storage related to personalization, for example, video recommendations'
  }, {
    key: 'security_storage',
    desc: 'Enables storage related to security such as authentication functionality, fraud prevention, and other user protection'
  }];
  var dom, popup;
  var KEY = 'infility_consent';
  var appendChild = function appendChild(parent, child) {
    if (!parent) return;
    if (!child) return;
    if (!parent instanceof HTMLElement) return;
    if (typeof child === "string") {
      parent.innerHTML = child;
      return;
    }
    if (child instanceof HTMLElement) {
      parent.appendChild(child);
      return;
    }
    if (Array.isArray(child)) {
      child.forEach(function (childElement) {
        appendChild(parent, childElement);
      });
    }
  };
  /**
   *
   * @param {string} tag The tag name
   * @param {object} attributes Key value pairs
   * @param {array} children The child elements
   * @returns HTMLElement
   */
  var ce = function ce(tag, attributes, children) {
    var ele = document.createElement(tag);
    for (var name in attributes) {
      ele.setAttribute(name, attributes[name]);
    }
    appendChild(ele, children);
    return ele;
  };
  var saveSettings = function saveSettings(grantedData) {
    window.console.log('[Infility Global Plugin] consent mode - update', grantedData);
    gtag('consent', 'update', grantedData);
    window.localStorage.setItem(KEY, JSON.stringify(grantedData));
  };
  var readSettings = function readSettings() {
    var item = window.localStorage.getItem(KEY);
    if (!item) return item;
    return JSON.parse(item);
  };
  var onGranted = function onGranted() {
    var grantedData = {};
    options.forEach(function (item) {
      grantedData[item.key] = 'granted';
    });
    saveSettings(grantedData);
    if (dom) {
      dom.remove();
    }
  };
  var onSettings = function onSettings() {
    var arr = [];
    options.forEach(function (item) {
      arr.push(ce('tr', {}, [ce('td', {
        style: 'text-align: center;'
      }, [ce('input', {
        type: 'checkbox',
        name: item.key,
        checked: true
      }, [])]),
      // ce('td', {}, item.key),
      ce('td', {}, item.desc)]));
    });
    var btn = ce('input', {
      type: 'button',
      value: 'Save',
      "class": "infility-global-consent-mode-button infility-global-consent-mode-button-grant infility-global-consent-mode-button-save"
    }, []);
    btn.addEventListener("click", onSave);
    popup = ce('div', {
      "class": 'infility-global-consent-mode-popup'
    }, [ce("div", {
      "class": 'infility-global-consent-mode-popup-wrap'
    }, [ce("table", {
      "class": "infility-global-consent-mode-table"
    }, [ce('tr', {}, [ce('th', {}, 'Check'),
    // ce('th', {}, 'Item'),
    ce('th', {}, 'Description')]), arr]), btn])]);
    document.body.appendChild(popup);
  };
  var onSave = function onSave() {
    var grantedData = {};
    var popupDom = document.querySelector('.infility-global-consent-mode-popup');
    options.forEach(function (item) {
      var chk = popupDom.querySelector("input[type=checkbox][name=" + item.key + "]");
      if (chk) {
        if (chk.checked) {
          grantedData[item.key] = 'granted';
        } else {
          grantedData[item.key] = 'denied';
        }
      }
    });
    saveSettings(grantedData);
    if (popup) {
      popup.remove();
    }
    if (dom) {
      dom.remove();
    }
  };
  var initConsentBanner = function initConsentBanner() {
    var buttonGrant = ce("input", {
      type: "button",
      value: "Accept",
      "class": "infility-global-consent-mode-button infility-global-consent-mode-button-grant"
    }, []);
    var buttonSettings = ce("input", {
      type: "button",
      value: "Settings",
      "class": "infility-global-consent-mode-button infility-global-consent-mode-button-deny"
    }, []);
    var container = ce('div', {
      "class": 'infility-global-consent-mode-banner'
    }, [ce('div', {
      "class": 'infility-global-consent-mode-banner-wrap'
    }, [ce('div', {}, 'This website uses cookies to ensure you get the best exprerience on our website.'), buttonSettings, buttonGrant])]);
    buttonGrant.addEventListener('click', onGranted);
    buttonSettings.addEventListener('click', onSettings);
    document.body.appendChild(container);
    dom = container;
  };
  var init = function init() {
    if (window.infility_init_consent_mode) {
      return;
    }
    window.infility_init_consent_mode = true;
    var result = readSettings();
    if (result) {
      saveSettings(result);
    } else {
      initConsentBanner();
    }
  };
  window.addEventListener('load', function () {
    init();
  });
  document.addEventListener('DOMContentLoaded', function () {
    init();
  });

  // setDefault(deniedData);
  // init(); // only enable this line for test purpose
})();