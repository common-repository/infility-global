"use strict";

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }
function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor); } }
function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
(function () {
  var $, intervalId, ready;
  intervalId = setInterval(function () {
    if (window.jQuery) {
      clearInterval(intervalId);
      $ = window.jQuery;
      $(document).ready(ready);
    }
  }, 100);

  // 不会公开到全局
  var WhyUs = /*#__PURE__*/function () {
    function WhyUs() {
      _classCallCheck(this, WhyUs);
      this.$scope = $('.kwp-section.kwp-whyus');
      this.$items = this.$scope.find('.item');
      this.$scope.on('click', '.title-wrap', this.onTitleClick);
      this.show(0);
    }
    _createClass(WhyUs, [{
      key: "show",
      value: function show(index) {
        this.$items.eq(index).addClass('active');
      }
    }, {
      key: "onTitleClick",
      value: function onTitleClick() {
        var $this = $(this);
        var $item = $this.closest('.item');
        if ($item.hasClass('active')) {
          $item.toggleClass('active');
          $item.find('.content').slideToggle();
        } else {
          $item.siblings().removeClass('active');
          $item.addClass('active');
        }
      }
    }]);
    return WhyUs;
  }();
  var FooterKeywords = /*#__PURE__*/function () {
    function FooterKeywords() {
      _classCallCheck(this, FooterKeywords);
      this.$scope = $('.infility-kwp-keywords');
      this.$items = this.$scope.find('.infility-kwp-keywords-main-item');
      this.$show = this.$scope.find('.infility-kwp-keywords-show');
      var that = this;
      this.$scope.on('mouseover', '.infility-kwp-keywords-main-item', function () {
        var me = this;
        that.onMouseOver(that, me);
      });
      this.show(0);
    }
    _createClass(FooterKeywords, [{
      key: "show",
      value: function show(index) {
        this.$items.eq(index).addClass('active');
      }
    }, {
      key: "onMouseOver",
      value: function onMouseOver(footerKeywords, dom) {
        var $this = $(dom);
        var $item = footerKeywords.$scope.find('.kw-sub-for-' + $this.data('slug'));
        footerKeywords.$show.css('min-height', '120px').html($item.html());
      }
    }]);
    return FooterKeywords;
  }();
  ready = function ready() {
    if ($('body').hasClass('infility-kwp')) {
      var whyUs = new WhyUs();
      var footerKeywords = new FooterKeywords();
      $('#sh_lsft_custom_dropdown_flags').remove();
      $('#sh_lsft_custom_dropdown_flags_names').remove();
    }
  };
})();