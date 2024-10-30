"use strict";

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw new Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw new Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }
;
(function () {
  var ajaxurl = window.ajaxurl || '/wp-admin/admin-ajax.php';
  var $, intervalId, ready;
  intervalId = setInterval(function () {
    if (window.jQuery) {
      clearInterval(intervalId);
      $ = window.jQuery;
      $(document).ready(ready);
    }
  }, 100);
  var ajaxRequest = function ajaxRequest() {
    var param = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    param.action = 'infility_global_keyword_pages_ajax';
    param.ig_ts = new Date().getTime(); // timestamp
    return new Promise(function (resolve, reject) {
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: param,
        success: function success(ret) {
          if (ret.success) {
            resolve(ret.data);
          } else {
            console.log(ret);
            reject(new Error(ret.data));
          }
        },
        error: function error(jqXHR, textStatus, errorThrown) {
          // jqXHR
          // textStatus: null, timeout, error, abort, parsererror
          // errorThrown: "", Not Found, Internal Server Error
          // console.log('[ajaxRequest] error\n    readyState:' + jqXHR.readyState + ' status:' + jqXHR.status + ' errorThrown:' + errorThrown + ' textStatus:' + textStatus, param)
          console.log('[ajaxRequest] error - action: ' + param.action + '\n\treadyState:' + jqXHR.readyState + '\n\tstatus:' + jqXHR.status + '\n\terrorThrown:' + errorThrown + '\n\ttextStatus:' + textStatus + '\n', param);
          var errmsg = 'Unknown error';
          if (jqXHR.readyState === 4 && errorThrown) errmsg = '' + jqXHR.status + ': ' + errorThrown;else if (errorThrown) errmsg = errorThrown;else if (textStatus) errmsg = textStatus;
          reject(new Error(errmsg));
        }
      });
    });
  };
  var KeywordTabs = {
    $scope: null,
    init: function init($scope) {
      KeywordTabs.$scope = $scope;
      $scope.find('.tab').on('click', function () {
        var $tab = $(this);
        var $tabs = $tab.closest('.tabs');
        var $panels = $tabs.find('.panel');
        var $panel = $panels.eq($tab.index());
        $tabs.find('.tab').removeClass('active');
        $tab.addClass('active');
        $panels.removeClass('show');
        $panel.addClass('show');
      });
      $scope.find('.tab').eq(0).click();
    }
  };
  var KeywordEditor = {
    $editor: null,
    $wrap: null,
    $loading: null,
    $iptId: null,
    $iptParent: null,
    $iptKeyword: null,
    $iptDescription: null,
    $iptDescription2: null,
    $iptOrder: null,
    $iptTemplateSelect: null,
    $q1: null,
    $q2: null,
    $q3: null,
    $a1: null,
    $a2: null,
    $a3: null,
    $slug: null,
    $btnGenerateDescription2: null,
    $btnAiGenerateFaq: null,
    $btnSave: null,
    $btnCancel: null,
    callback: null,
    mainList: [],
    desc2Templates: ['Introducing top-notch __KEYWORD__. Crafted to perfection, our __KEYWORD__ offer unmatched quality, and flexible customization options. With years of experience and supportive team members, we are obssessed with delivering perfect and tailored solutions for every client. Experience one-stop solution and 24/7 support from us.', 'Step into a world of exceptional quality and craftsmanship with our diverse range of __KEYWORD__. From manufacturing to private labeling & wholesaling, we pride ourselves on delivering products that exceed expectations. Don’t settle for ordinary – explore our __KEYWORD__collection today and indulge in the extraordinary.', 'Discover the epitome of __KEYWORD__ excellence! Our range of exquisite, high-quality __KEYWORD__ will elevate your game. Embrace the power of exceptional products and enhance your projects. Experience one-stop solution and 24/7 support from us. Discover our range now and revolutionize your product lines!', 'Unleash possibilities with our cutting-edge __KEYWORD__! Crafted with precision and ingenuity, our __KEYWORD__ blend quality, safety, and style seamlessly. Experience one-stop solution and 24/7 support from us. Empower your brand and business with our advanced  technology & craftsmanship—explore our range today and reclaim uninterrupted power!'],
    init: function init($scope) {
      KeywordEditor.$editor = $scope.find('.keyword-editor');
      KeywordEditor.$wrap = $scope.find('.keyword-editor-wrap');
      KeywordEditor.$loading = KeywordEditor.$wrap.find('.loading');
      KeywordEditor.$iptId = KeywordEditor.$wrap.find('.ipt-id');
      KeywordEditor.$iptParent = KeywordEditor.$wrap.find('.ipt-parent');
      KeywordEditor.$iptKeyword = KeywordEditor.$wrap.find('.ipt-keyword');
      KeywordEditor.$iptDescription = KeywordEditor.$wrap.find('.ipt-description');
      KeywordEditor.$iptDescription2 = KeywordEditor.$wrap.find('.ipt-description2');
      KeywordEditor.$iptOrder = KeywordEditor.$wrap.find('.ipt-order');
      KeywordEditor.$q1 = KeywordEditor.$wrap.find('.ipt-q1');
      KeywordEditor.$q2 = KeywordEditor.$wrap.find('.ipt-q2');
      KeywordEditor.$q3 = KeywordEditor.$wrap.find('.ipt-q3');
      KeywordEditor.$a1 = KeywordEditor.$wrap.find('.ipt-a1');
      KeywordEditor.$a2 = KeywordEditor.$wrap.find('.ipt-a2');
      KeywordEditor.$a3 = KeywordEditor.$wrap.find('.ipt-a3');
      KeywordEditor.$slug = KeywordEditor.$wrap.find('.slug');
      KeywordEditor.$iptTemplateSelect = KeywordEditor.$wrap.find('.ipt-template-select');
      KeywordEditor.$btnGenerateDescription2 = KeywordEditor.$wrap.find('.btn-generate-description-2');
      KeywordEditor.$btnAiGenerateFaq = KeywordEditor.$wrap.find('.btn-ai-generate-faq');
      KeywordEditor.$btnSave = KeywordEditor.$wrap.find('.btn-save');
      KeywordEditor.$btnCancel = KeywordEditor.$wrap.find('.btn-cancel');
      KeywordEditor.$iptKeyword.on('keyup', KeywordEditor.onKeywordChanged);
      KeywordEditor.$btnCancel.on('click', KeywordEditor.hide);
      KeywordEditor.$btnSave.on('click', KeywordEditor.save);
      KeywordEditor.$wrap.find('.btn-generate-what-is').on('click', KeywordEditor.generateWhatIs);
      KeywordEditor.$btnGenerateDescription2.on('click', KeywordEditor.onGenerateDescription2Clicked);
      KeywordEditor.$btnAiGenerateFaq.on('click', KeywordEditor.generateFAQ);
    },
    showLoading: function showLoading() {
      KeywordEditor.$loading.addClass('show');
    },
    hideLoading: function hideLoading() {
      KeywordEditor.$loading.removeClass('show');
    },
    recoverText: function recoverText(value) {
      return value.replace(/\\"/g, '"').replace(/\\'/g, "'");
    },
    showFaq: function showFaq(faq, index, attr) {
      if (!faq) faq = [];
      if (!faq[index]) faq[index] = {};
      if (!faq[index][attr]) faq[index][attr] = '';
      return KeywordEditor.recoverText(faq[index][attr]);
    },
    show: function show(data, callback) {
      KeywordEditor.callback = callback;
      KeywordEditor.$iptId.val(data.id || '0');
      KeywordEditor.$iptKeyword.val(data.keyword || '');
      KeywordEditor.$iptDescription.val(KeywordEditor.recoverText(data.description || ''));
      KeywordEditor.$iptDescription2.val(KeywordEditor.recoverText(data.description2 || ''));
      KeywordEditor.$iptOrder.val(data.order || '0');
      KeywordEditor.$iptTemplateSelect.val('-1');
      KeywordEditor.$q1.val(KeywordEditor.showFaq(data.faq, 0, 'question'));
      KeywordEditor.$q2.val(KeywordEditor.showFaq(data.faq, 1, 'question'));
      KeywordEditor.$q3.val(KeywordEditor.showFaq(data.faq, 2, 'question'));
      KeywordEditor.$a1.val(KeywordEditor.showFaq(data.faq, 0, 'answer'));
      KeywordEditor.$a2.val(KeywordEditor.showFaq(data.faq, 1, 'answer'));
      KeywordEditor.$a3.val(KeywordEditor.showFaq(data.faq, 2, 'answer'));
      KeywordEditor.$wrap.find('.span-loading-1').html('');
      KeywordEditor.$wrap.find('.span-loading-2').html('通常需要 30 秒以上，请耐心等待。');
      KeywordEditor.onKeywordChanged();
      KeywordEditor.updateSelect();
      KeywordEditor.$iptParent.val(data.parent || '0');
      KeywordEditor.$editor.addClass('show');
      setTimeout(function () {
        KeywordEditor.$wrap.addClass('show');
      }, 10);
    },
    hide: function hide() {
      KeywordEditor.$wrap.removeClass('show');
      setTimeout(function () {
        KeywordEditor.$editor.removeClass('show');
      }, 300);
    },
    onKeywordChanged: function onKeywordChanged() {
      KeywordEditor.$slug.html(KeywordEditor.generateSlug(KeywordEditor.$iptKeyword.val()));
      KeywordEditor.$wrap.find('span.keyword').html(KeywordEditor.$iptKeyword.val());
    },
    updateSelect: function updateSelect() {
      var html = '<option value="0">(None)</option>';
      KeywordEditor.mainList.forEach(function (item) {
        if (item.id === parseInt(KeywordEditor.$iptId.val())) return;
        html += '<option value="' + item.id + '">' + item.keyword + '</option>';
      });
      KeywordEditor.$iptParent.html(html);
    },
    generateSlug: function generateSlug(kw) {
      return kw.toLowerCase().replace(/&/g, 'and').replace(/\s/g, '-');
    },
    onGenerateDescription2Clicked: function onGenerateDescription2Clicked() {
      var value = parseInt(KeywordEditor.$iptTemplateSelect.val());
      var description = KeywordEditor.generateDescription2(value, KeywordEditor.$iptKeyword.val());
      if (KeywordEditor.$iptDescription2.val().length > 0) {
        if (!confirm('Are you sure to overwrite the description?')) return;
      }
      KeywordEditor.$iptDescription2.val(description);
    },
    generateDescription2: function generateDescription2(index, keyword) {
      index = parseInt(index);
      if (isNaN(index) || index < 0 || index >= KeywordEditor.desc2Templates.length) {
        index = Math.floor(Math.random() * KeywordEditor.desc2Templates.length);
      }
      var template = KeywordEditor.desc2Templates[index];
      return template.replace(/__KEYWORD__/g, keyword);
    },
    save: function save() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var id, parent, keyword, description, description2, order, q1, q2, q3, a1, a2, a3, kw, slug, data;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              id = KeywordEditor.$iptId.val();
              parent = parseInt(KeywordEditor.$iptParent.val());
              keyword = KeywordEditor.$iptKeyword.val();
              description = KeywordEditor.$iptDescription.val();
              description2 = KeywordEditor.$iptDescription2.val();
              order = parseInt(KeywordEditor.$iptOrder.val());
              q1 = KeywordEditor.$wrap.find('.ipt-q1').val();
              q2 = KeywordEditor.$wrap.find('.ipt-q2').val();
              q3 = KeywordEditor.$wrap.find('.ipt-q3').val();
              a1 = KeywordEditor.$wrap.find('.ipt-a1').val();
              a2 = KeywordEditor.$wrap.find('.ipt-a2').val();
              a3 = KeywordEditor.$wrap.find('.ipt-a3').val();
              if (!(keyword.length === 0)) {
                _context.next = 15;
                break;
              }
              alert('Please enter keyword');
              return _context.abrupt("return");
            case 15:
              if (!(description.length === 0)) {
                _context.next = 18;
                break;
              }
              alert('Please enter description for "what is"');
              return _context.abrupt("return");
            case 18:
              if (!(description2.length === 0)) {
                _context.next = 21;
                break;
              }
              alert('Please enter description for "' + keyword + ' by xxx"');
              return _context.abrupt("return");
            case 21:
              // only keep a-z, A-Z, 0-9, -, _, & and space
              kw = keyword.replace(/[^a-zA-Z0-9\-_& ]/g, '');
              if (!(kw !== keyword)) {
                _context.next = 25;
                break;
              }
              alert('Keyword 仅支持 a-z A-Z 0-9 中横线 下划线 & 以及空格');
              return _context.abrupt("return");
            case 25:
              if (!KeywordEditor.callback) {
                _context.next = 43;
                break;
              }
              KeywordEditor.showLoading();
              slug = KeywordEditor.generateSlug(keyword); // KeywordEditor.callback({ id, parent, keyword, slug, description, order }).then(() => {
              // 	KeywordEditor.hide()
              // }).catch(err => {
              // 	alert(err.message)
              // }).finally(() => {
              // 	KeywordEditor.hideLoading()
              // })
              _context.prev = 28;
              data = {
                id: id,
                parent: parent,
                keyword: keyword,
                slug: slug,
                description: description,
                description2: description2,
                order: order,
                faq: [{
                  question: q1,
                  answer: a1
                }, {
                  question: q2,
                  answer: a2
                }, {
                  question: q3,
                  answer: a3
                }]
              };
              _context.next = 32;
              return KeywordEditor.callback(data);
            case 32:
              KeywordEditor.hide();
              _context.next = 38;
              break;
            case 35:
              _context.prev = 35;
              _context.t0 = _context["catch"](28);
              alert(_context.t0.message);
            case 38:
              _context.prev = 38;
              KeywordEditor.hideLoading();
              return _context.finish(38);
            case 41:
              _context.next = 44;
              break;
            case 43:
              KeywordEditor.hide();
            case 44:
            case "end":
              return _context.stop();
          }
        }, _callee, null, [[28, 35, 38, 41]]);
      }))();
    },
    generateWhatIs: function generateWhatIs() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var keyword, current, time, whatIs, seconds;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              keyword = KeywordEditor.$iptKeyword.val();
              if (!(keyword.length === 0)) {
                _context2.next = 4;
                break;
              }
              alert('Please enter keyword');
              return _context2.abrupt("return");
            case 4:
              current = KeywordEditor.$iptDescription.val();
              if (!(current.length > 0)) {
                _context2.next = 8;
                break;
              }
              if (confirm('生成的内容将覆盖现有内容，是否继续?')) {
                _context2.next = 8;
                break;
              }
              return _context2.abrupt("return");
            case 8:
              // KeywordEditor.showLoading()
              time = new Date().getTime();
              KeywordEditor.$wrap.find('.span-loading-1').html('Loading...');
              _context2.prev = 10;
              _context2.next = 13;
              return KeywordEditor.generateFromAI('whatis', keyword);
            case 13:
              whatIs = _context2.sent;
              KeywordEditor.$iptDescription.val(whatIs);
              _context2.next = 20;
              break;
            case 17:
              _context2.prev = 17;
              _context2.t0 = _context2["catch"](10);
              setTimeout(function () {
                alert(_context2.t0.message);
              }, 1);
            case 20:
              _context2.prev = 20;
              seconds = Math.floor((new Date().getTime() - time) / 1000);
              KeywordEditor.$wrap.find('.span-loading-1').html('Done. 用了 ' + seconds + ' 秒');
              return _context2.finish(20);
            case 24:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[10, 17, 20, 24]]);
      }))();
    },
    generateFAQ: function generateFAQ() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var time, ret, arr, i, qa, seconds;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              /* 测试时可以用这个数据，不用每次等 AI 返回
              [
                {
                  "question": "What is a shower screen?",
                  "answer": "A shower screen is a transparent or semi-transparent panel made of glass or acrylic that separates the shower area from the rest of the bathroom. It helps to contain water within the shower space and prevents it from splashing onto the floor."
                },
                {
                  "question": "What are the benefits of using a shower screen?",
                  "answer": "Using a shower screen comes with several benefits. It helps to create a more organized and separate shower area, keeping the rest of the bathroom dry and clean. Additionally, it adds a touch of elegance to the bathroom's overall aesthetic. Shower screens also come in various designs and sizes, allowing you to choose one that suits your bathroom's style and dimensions."
                },
                {
                  "question": "How do I maintain and clean a shower screen?",
                  "answer": "Maintaining and cleaning a shower screen is relatively easy. Regularly wipe the screen with a soft cloth or sponge and mild soap or non-abrasive cleaners to remove soap scum and residue. Avoid using harsh chemicals or abrasive materials that can damage the screen's surface. Rinse it thoroughly after cleaning and wipe it dry to prevent water spots. Additionally, keep the screen's edges and seals free from mold or mildew by using an appropriate anti-fungal spray or solution."
                }
              ]
              */
              KeywordEditor.$wrap.find('.span-loading-2').html('Loading...');
              time = new Date().getTime();
              _context3.prev = 2;
              _context3.next = 5;
              return KeywordEditor.generateFromAI('faq', KeywordEditor.$iptKeyword.val());
            case 5:
              ret = _context3.sent;
              arr = JSON.parse(ret);
              for (i = 0; i < arr.length; i++) {
                qa = arr[i];
                KeywordEditor.$wrap.find('.ipt-q' + (i + 1)).val(qa.question);
                KeywordEditor.$wrap.find('.ipt-a' + (i + 1)).val(qa.answer);
              }
              _context3.next = 13;
              break;
            case 10:
              _context3.prev = 10;
              _context3.t0 = _context3["catch"](2);
              setTimeout(function () {
                alert(_context3.t0.message);
              }, 1);
            case 13:
              _context3.prev = 13;
              seconds = Math.floor((new Date().getTime() - time) / 1000);
              KeywordEditor.$wrap.find('.span-loading-2').html('Done. 用了 ' + seconds + ' 秒');
              return _context3.finish(13);
            case 17:
            case "end":
              return _context3.stop();
          }
        }, _callee3, null, [[2, 10, 13, 17]]);
      }))();
    },
    generateFromAI: function generateFromAI(type, keyword) {
      return ajaxRequest({
        do_action: 'openai_text',
        keyword: keyword,
        type: type
      });
    }
  };
  var KeywordImport = {
    $scope: null,
    $wrap: null,
    $iptParent: null,
    $domLog: null,
    $btnRefresh: null,
    $btnImport: null,
    init: function init($scope) {
      KeywordImport.$scope = $scope;
      KeywordImport.$wrap = $scope.find('.panel-import');
      KeywordImport.$iptParent = KeywordImport.$wrap.find('.ipt-parent');
      KeywordImport.$domLog = KeywordImport.$wrap.find('.div-log tbody');
      KeywordImport.$btnImport = KeywordImport.$wrap.find('.btn-import');
      KeywordImport.$btnRefresh = KeywordImport.$wrap.find('.btn-refresh-main-list');
      KeywordImport.$wrap.find('.btn-cancel').on('click', KeywordImport.hide);
      KeywordImport.$wrap.find('.btn-import').on('click', KeywordImport["import"]);
      KeywordImport.$btnRefresh.on('click', KeywordImport.refreshMainList);
    },
    "import": function _import() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        var parent, content, list, i, keyword, exists;
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              parent = KeywordImport.$iptParent.val();
              if (parent) {
                _context4.next = 4;
                break;
              }
              alert('Please select parent keyword1');
              return _context4.abrupt("return");
            case 4:
              parent = parseInt(parent);
              content = KeywordImport.$wrap.find('textarea').val();
              list = content.split('\n');
              KeywordImport.$btnImport.attr('disabled', true);
              _context4.prev = 8;
              i = 0;
            case 10:
              if (!(i < list.length)) {
                _context4.next = 29;
                break;
              }
              keyword = list[i];
              if (keyword) {
                _context4.next = 14;
                break;
              }
              return _context4.abrupt("continue", 26);
            case 14:
              keyword = keyword.trim();
              if (keyword) {
                _context4.next = 17;
                break;
              }
              return _context4.abrupt("continue", 26);
            case 17:
              _context4.next = 19;
              return KeywordImport.checkKeywordExists(keyword);
            case 19:
              exists = _context4.sent;
              if (!exists) {
                _context4.next = 23;
                break;
              }
              KeywordImport.addLog('error', 'keyword exists: ' + keyword);
              return _context4.abrupt("continue", 26);
            case 23:
              _context4.next = 25;
              return KeywordImport.importOne(keyword, parent);
            case 25:
              KeywordImport.addLog('debug', '----');
            case 26:
              i++;
              _context4.next = 10;
              break;
            case 29:
              KeywordImport.addLog('info', 'DONE');
              _context4.next = 35;
              break;
            case 32:
              _context4.prev = 32;
              _context4.t0 = _context4["catch"](8);
              alert(_context4.t0.message);
            case 35:
              KeywordImport.$btnImport.attr('disabled', false);
            case 36:
            case "end":
              return _context4.stop();
          }
        }, _callee4, null, [[8, 32]]);
      }))();
    },
    importOne: function importOne(keyword, parent) {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee5() {
        var slug, ret, description, faq, arr, description2, data;
        return _regeneratorRuntime().wrap(function _callee5$(_context5) {
          while (1) switch (_context5.prev = _context5.next) {
            case 0:
              KeywordImport.addLog('info', '* START: ' + keyword);
              KeywordImport.addLog('debug', 'parent: ' + parent);
              slug = KeywordEditor.generateSlug(keyword);
              KeywordImport.addLog('debug', 'slug: ' + slug);
              _context5.prev = 4;
              _context5.next = 7;
              return Promise.all([KeywordImport.generateWhatIs(keyword), KeywordImport.generateFAQ(keyword)]);
            case 7:
              ret = _context5.sent;
              _context5.next = 15;
              break;
            case 10:
              _context5.prev = 10;
              _context5.t0 = _context5["catch"](4);
              alert(_context5.t0.message);
              KeywordImport.addLog('error', 'ERROR: ' + _context5.t0.message);
              return _context5.abrupt("return");
            case 15:
              console.log(ret);
              description = ret[0];
              faq = ret[1];
              arr = JSON.parse(faq);
              description2 = KeywordEditor.generateDescription2(-1, keyword);
              data = {
                id: 0,
                parent: parent,
                keyword: keyword,
                slug: slug,
                description: description,
                description2: description2,
                order: 0,
                faq: [{
                  question: arr[0].question,
                  answer: arr[0].answer
                }, {
                  question: arr[1].question,
                  answer: arr[1].answer
                }, {
                  question: arr[2].question,
                  answer: arr[2].answer
                }]
              };
              console.log(data);
              _context5.prev = 22;
              KeywordImport.addLog('debug', 'adding: ' + keyword);
              _context5.next = 26;
              return KeywordPages.saveKeyword('add', data);
            case 26:
              ret = _context5.sent;
              KeywordImport.addLog('info', 'keyword added: ' + keyword);
              _context5.next = 35;
              break;
            case 30:
              _context5.prev = 30;
              _context5.t1 = _context5["catch"](22);
              alert(_context5.t1.message);
              KeywordImport.addLog('error', 'ERROR: ' + _context5.t1.message);
              return _context5.abrupt("return");
            case 35:
              console.log(ret);
            case 36:
            case "end":
              return _context5.stop();
          }
        }, _callee5, null, [[4, 10], [22, 30]]);
      }))();
    },
    refreshMainList: function refreshMainList() {
      var $select = KeywordImport.$wrap.find('select');
      $select.html('');
      var list = KeywordPages.getMainKeywordList();
      list.forEach(function (keyword) {
        $select.append('<option value="' + keyword.id + '">' + keyword.keyword + '</option>');
      });
    },
    addLog: function addLog(type, message) {
      var html = '<tr class="' + type + '">' + '<td>[' + new Date().toLocaleString() + ']</td>' + '<td>' + message + '</td>' + '</tr>';
      KeywordImport.$domLog.append(html);
    },
    generateWhatIs: function generateWhatIs(keyword) {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee6() {
        var whatIs;
        return _regeneratorRuntime().wrap(function _callee6$(_context6) {
          while (1) switch (_context6.prev = _context6.next) {
            case 0:
              KeywordImport.addLog('debug', 'AI generate - start: what is ' + keyword);
              _context6.next = 3;
              return KeywordEditor.generateFromAI('whatis', keyword);
            case 3:
              whatIs = _context6.sent;
              KeywordImport.addLog('debug', 'AI generate - done: what is ' + keyword);
              return _context6.abrupt("return", whatIs);
            case 6:
            case "end":
              return _context6.stop();
          }
        }, _callee6);
      }))();
    },
    generateFAQ: function generateFAQ(keyword) {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee7() {
        var faq;
        return _regeneratorRuntime().wrap(function _callee7$(_context7) {
          while (1) switch (_context7.prev = _context7.next) {
            case 0:
              KeywordImport.addLog('debug', 'AI generate - START: faq for ' + keyword);
              _context7.next = 3;
              return KeywordEditor.generateFromAI('faq', keyword);
            case 3:
              faq = _context7.sent;
              KeywordImport.addLog('debug', 'AI generate - DONE: faq for ' + keyword);
              return _context7.abrupt("return", faq);
            case 6:
            case "end":
              return _context7.stop();
          }
        }, _callee7);
      }))();
    },
    checkKeywordExists: function checkKeywordExists(keyword) {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee8() {
        var ret;
        return _regeneratorRuntime().wrap(function _callee8$(_context8) {
          while (1) switch (_context8.prev = _context8.next) {
            case 0:
              _context8.next = 2;
              return ajaxRequest({
                do_action: 'keyword_exists',
                keyword: keyword
              });
            case 2:
              ret = _context8.sent;
              return _context8.abrupt("return", ret);
            case 4:
            case "end":
              return _context8.stop();
          }
        }, _callee8);
      }))();
    }
  };
  var KeywordWhyus = {
    $scope: null,
    $wrap: null,
    $iptImageUrl: null,
    $iptImageAlt: null,
    $iptTitle: null,
    $iptDesc: null,
    template: '',
    list: [],
    init: function init($scope) {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee9() {
        return _regeneratorRuntime().wrap(function _callee9$(_context9) {
          while (1) switch (_context9.prev = _context9.next) {
            case 0:
              KeywordWhyus.$scope = $scope;
              KeywordWhyus.$wrap = $scope.find('.panel-whyus');
              KeywordWhyus.$iptImageUrl = KeywordWhyus.$wrap.find('.ipt-image-url');
              KeywordWhyus.$iptImageAlt = KeywordWhyus.$wrap.find('.ipt-image-alt');
              KeywordWhyus.$iptTitle = KeywordWhyus.$wrap.find('.ipt-title');
              KeywordWhyus.$iptDesc = KeywordWhyus.$wrap.find('.ipt-desc');
              KeywordWhyus.template = KeywordWhyus.$wrap.find('tbody').html();
              KeywordWhyus.$wrap.on('click', '.btn-select-image-to-add', KeywordWhyus.selectImageToAdd);
              KeywordWhyus.$wrap.on('click', '.btn-add', KeywordWhyus.add);
              KeywordWhyus.$wrap.on('click', 'td.image .btn-select-image', KeywordWhyus.selectImage);
              KeywordWhyus.$wrap.on('click', 'td.image .btn-delete-image', KeywordWhyus.deleteImage);
              KeywordWhyus.$wrap.on('click', '.btn-save', KeywordWhyus.saveItem);
              KeywordWhyus.$wrap.on('click', '.btn-delete', KeywordWhyus.deleteItem);
              _context9.next = 15;
              return KeywordWhyus.getList();
            case 15:
              KeywordWhyus.list = _context9.sent;
              KeywordWhyus.render();
            case 17:
            case "end":
              return _context9.stop();
          }
        }, _callee9);
      }))();
    },
    getList: function getList() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee10() {
        var ret;
        return _regeneratorRuntime().wrap(function _callee10$(_context10) {
          while (1) switch (_context10.prev = _context10.next) {
            case 0:
              _context10.next = 2;
              return ajaxRequest({
                do_action: 'get_whyus_list'
              });
            case 2:
              ret = _context10.sent;
              return _context10.abrupt("return", ret);
            case 4:
            case "end":
              return _context10.stop();
          }
        }, _callee10);
      }))();
    },
    save: function save() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee11() {
        var data, ret;
        return _regeneratorRuntime().wrap(function _callee11$(_context11) {
          while (1) switch (_context11.prev = _context11.next) {
            case 0:
              data = KeywordWhyus.list;
              _context11.prev = 1;
              _context11.next = 4;
              return ajaxRequest({
                do_action: 'save_whyus',
                data: data
              });
            case 4:
              ret = _context11.sent;
              KeywordWhyus.list = ret;
              KeywordWhyus.render();
              _context11.next = 12;
              break;
            case 9:
              _context11.prev = 9;
              _context11.t0 = _context11["catch"](1);
              alert(_context11.t0.message);
            case 12:
            case "end":
              return _context11.stop();
          }
        }, _callee11, null, [[1, 9]]);
      }))();
    },
    saveItem: function saveItem() {
      var _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee12() {
        var $tr, index, image, imageAlt, title, content, item;
        return _regeneratorRuntime().wrap(function _callee12$(_context12) {
          while (1) switch (_context12.prev = _context12.next) {
            case 0:
              $tr = $(_this).closest('tr');
              index = parseInt($tr.find('td.index').html()) - 1;
              image = $tr.find('td.image img').attr('src');
              imageAlt = $tr.find('td.alt input').val();
              title = $tr.find('td.title input').val();
              content = $tr.find('td.desc textarea').val();
              item = {
                image_url: image,
                image_alt: imageAlt,
                title: title,
                content: content
              };
              KeywordWhyus.list[index] = item;
              _context12.next = 10;
              return KeywordWhyus.save();
            case 10:
            case "end":
              return _context12.stop();
          }
        }, _callee12);
      }))();
    },
    deleteItem: function deleteItem() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee13() {
        var $tr, index;
        return _regeneratorRuntime().wrap(function _callee13$(_context13) {
          while (1) switch (_context13.prev = _context13.next) {
            case 0:
              $tr = $(_this2).closest('tr');
              index = parseInt($tr.find('td.index').html()) - 1;
              if (confirm('Are you sure to delete this item?')) {
                _context13.next = 4;
                break;
              }
              return _context13.abrupt("return");
            case 4:
              KeywordWhyus.list.splice(index, 1);
              _context13.next = 7;
              return KeywordWhyus.save();
            case 7:
              KeywordWhyus.render();
            case 8:
            case "end":
              return _context13.stop();
          }
        }, _callee13);
      }))();
    },
    renderOne: function renderOne(index, item) {
      var $tr = $(KeywordWhyus.template);
      $tr.find('td.index').html(index + 1);
      $tr.find('td.image img').attr('src', item.image_url);
      $tr.find('td.image img').attr('alt', item.image_alt);
      $tr.find('td.alt input').val(item.image_alt);
      $tr.find('td.title input').val(item.title);
      $tr.find('td.desc textarea').val(item.content);
      return $tr;
    },
    render: function render() {
      KeywordWhyus.$wrap.find('tbody').html('');
      KeywordWhyus.list.forEach(function (item, index) {
        KeywordWhyus.$wrap.find('tbody').append(KeywordWhyus.renderOne(index, item));
      });
    },
    selectImageToAdd: function selectImageToAdd() {
      var file = wp.media({
        title: 'Select or Upload Image',
        button: {
          text: 'Use this image'
        },
        multiple: false
      }).open().on('select', function () {
        var attachment = file.state().get('selection').first().toJSON();
        KeywordWhyus.$iptImageUrl.val(attachment.url);
        KeywordWhyus.$iptImageAlt.val(attachment.alt);
        KeywordWhyus.$wrap.find('.tr-add img').attr('src', attachment.url);
      });
    },
    add: function add() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee14() {
        var image, imageAlt, title, content, item;
        return _regeneratorRuntime().wrap(function _callee14$(_context14) {
          while (1) switch (_context14.prev = _context14.next) {
            case 0:
              image = KeywordWhyus.$iptImageUrl.val();
              imageAlt = KeywordWhyus.$iptImageAlt.val();
              title = KeywordWhyus.$iptTitle.val();
              content = KeywordWhyus.$iptDesc.val();
              item = {
                image_url: image,
                image_alt: imageAlt,
                title: title,
                content: content
              };
              KeywordWhyus.list.push(item);
              _context14.next = 8;
              return KeywordWhyus.save();
            case 8:
              KeywordWhyus.render();
              //  清空输入框
              KeywordWhyus.$iptImageUrl.val('');
              KeywordWhyus.$iptImageAlt.val('');
              KeywordWhyus.$iptTitle.val('');
              KeywordWhyus.$iptDesc.val('');
              KeywordWhyus.$wrap.find('.tr-add img').attr('src', '');
            case 14:
            case "end":
              return _context14.stop();
          }
        }, _callee14);
      }))();
    },
    selectImage: function selectImage() {
      var $tr = $(this).closest('tr');
      var index = parseInt($tr.find('td.index').html()) - 1;
      console.log(index);
      var file = wp.media({
        title: 'Select or Upload Image',
        button: {
          text: 'Use this image'
        },
        multiple: false
      }).open().on('select', function () {
        var attachment = file.state().get('selection').first().toJSON();
        KeywordWhyus.list[index].image_url = attachment.url;
        if (!KeywordWhyus.list[index].image_alt) KeywordWhyus.list[index].image_alt = attachment.alt;
        // KeywordWhyus.list[index].image_alt = attachment.alt
        KeywordWhyus.render();
      });
    },
    deleteImage: function deleteImage() {
      var $tr = $(this).closest('tr');
      var index = parseInt($tr.find('td.index').html()) - 1;
      if (!confirm('Are you sure to delete this image?')) return;
      KeywordWhyus.list[index].image_url = '';
      KeywordWhyus.list[index].image_alt = '';
      KeywordWhyus.render();
    }
  };
  var KeywordSettings = {
    $scope: null,
    $wrap: null,
    $iptPostType: null,
    $iptTaxonomy: null,
    $iptBannerImage: null,
    $iptWhatisImage: null,
    $iptWhatisImageAlt: null,
    $iptFaqImage: null,
    $iptFaqImageAlt: null,
    $iptLink: null,
    $btnSelectBannerImage: null,
    $btnSelectWhatisImage: null,
    $btnSelectFaqImage: null,
    $btnSave: null,
    settings: {},
    postTypeList: [],
    taxonomyList: [],
    init: function init($scope) {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee15() {
        return _regeneratorRuntime().wrap(function _callee15$(_context15) {
          while (1) switch (_context15.prev = _context15.next) {
            case 0:
              KeywordSettings.$scope = $scope;
              KeywordSettings.$wrap = $scope.find('.panel-settings');
              KeywordSettings.$iptPostType = KeywordSettings.$wrap.find('.ipt-post-type');
              KeywordSettings.$iptTaxonomy = KeywordSettings.$wrap.find('.ipt-taxonomy');
              KeywordSettings.$iptBannerImage = KeywordSettings.$wrap.find('.ipt-banner-image');
              KeywordSettings.$iptWhatisImage = KeywordSettings.$wrap.find('.ipt-whatis-image');
              KeywordSettings.$iptWhatisImageAlt = KeywordSettings.$wrap.find('.ipt-whatis-image-alt');
              KeywordSettings.$iptFaqImage = KeywordSettings.$wrap.find('.ipt-faq-image');
              KeywordSettings.$iptFaqImageAlt = KeywordSettings.$wrap.find('.ipt-faq-image-alt');
              KeywordSettings.$iptLink = KeywordSettings.$wrap.find('.ipt-link');
              KeywordSettings.$btnSelectBannerImage = KeywordSettings.$wrap.find('.btn-select-banner-image');
              KeywordSettings.$btnSelectWhatisImage = KeywordSettings.$wrap.find('.btn-select-whatis-image');
              KeywordSettings.$btnSelectFaqImage = KeywordSettings.$wrap.find('.btn-select-faq-image');
              KeywordSettings.$btnSave = KeywordSettings.$wrap.find('.btn-save');
              KeywordSettings.$iptPostType.on('change', KeywordSettings.onPostTypeChanged);
              KeywordSettings.$btnSelectBannerImage.on('click', KeywordSettings.selectBannerImage);
              KeywordSettings.$btnSelectWhatisImage.on('click', KeywordSettings.selectWhatisImage);
              KeywordSettings.$btnSelectFaqImage.on('click', KeywordSettings.selectFaqImage);
              KeywordSettings.$btnSave.on('click', KeywordSettings.saveSettings);
              _context15.prev = 19;
              _context15.next = 22;
              return KeywordSettings.getSettings();
            case 22:
              KeywordSettings.settings = _context15.sent;
              KeywordSettings.postTypeList = KeywordSettings.settings.post_types;
              KeywordSettings.render();
              _context15.next = 30;
              break;
            case 27:
              _context15.prev = 27;
              _context15.t0 = _context15["catch"](19);
              alert(_context15.t0.message);
            case 30:
            case "end":
              return _context15.stop();
          }
        }, _callee15, null, [[19, 27]]);
      }))();
    },
    getSettings: function getSettings() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee16() {
        var ret;
        return _regeneratorRuntime().wrap(function _callee16$(_context16) {
          while (1) switch (_context16.prev = _context16.next) {
            case 0:
              _context16.next = 2;
              return ajaxRequest({
                do_action: 'get_settings'
              });
            case 2:
              ret = _context16.sent;
              return _context16.abrupt("return", ret);
            case 4:
            case "end":
              return _context16.stop();
          }
        }, _callee16);
      }))();
    },
    saveSettings: function saveSettings() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee17() {
        var data, ret;
        return _regeneratorRuntime().wrap(function _callee17$(_context17) {
          while (1) switch (_context17.prev = _context17.next) {
            case 0:
              data = {};
              data.post_type = KeywordSettings.$iptPostType.val();
              data.taxonomy = KeywordSettings.$iptTaxonomy.val();
              data.banner_image = KeywordSettings.$iptBannerImage.val();
              data.whatis_image = KeywordSettings.$iptWhatisImage.val();
              data.whatis_image_alt = KeywordSettings.$iptWhatisImageAlt.val();
              data.faq_image = KeywordSettings.$iptFaqImage.val();
              data.faq_image_alt = KeywordSettings.$iptFaqImageAlt.val();
              data.link = KeywordSettings.$iptLink.val();
              _context17.prev = 9;
              _context17.next = 12;
              return ajaxRequest({
                do_action: 'save_settings',
                data: data
              });
            case 12:
              ret = _context17.sent;
              alert('Saved');
              KeywordSettings.settings = ret.settings;
              KeywordSettings.render();
              _context17.next = 21;
              break;
            case 18:
              _context17.prev = 18;
              _context17.t0 = _context17["catch"](9);
              alert(_context17.t0.message);
            case 21:
            case "end":
              return _context17.stop();
          }
        }, _callee17, null, [[9, 18]]);
      }))();
    },
    render: function render() {
      KeywordSettings.renderPostTypes();
      KeywordSettings.$iptPostType.val(KeywordSettings.settings.post_type || '');
      KeywordSettings.onPostTypeChanged();
      KeywordSettings.$iptTaxonomy.val(KeywordSettings.settings.taxonomy || '');
      KeywordSettings.$iptBannerImage.val(KeywordSettings.settings.banner_image || '');
      KeywordSettings.$iptWhatisImage.val(KeywordSettings.settings.whatis_image || '');
      KeywordSettings.$iptWhatisImageAlt.val(KeywordSettings.settings.whatis_image_alt || '');
      KeywordSettings.$iptFaqImage.val(KeywordSettings.settings.faq_image || '');
      KeywordSettings.$iptFaqImageAlt.val(KeywordSettings.settings.faq_image_alt || '');
      KeywordSettings.$iptLink.val(KeywordSettings.settings.link || '');
    },
    renderPostTypes: function renderPostTypes() {
      var html = '<option value="">Please select ...</option>';
      KeywordSettings.postTypeList.forEach(function (item) {
        html += '<option value="' + item.value + '">' + item.label + '</option>';
      });
      KeywordSettings.$iptPostType.html(html);
    },
    renderTaxonomies: function renderTaxonomies() {
      var html = '<option value="">Please select ...</option>';
      KeywordSettings.taxonomyList.forEach(function (item) {
        html += '<option value="' + item.value + '">' + item.label + '</option>';
      });
      KeywordSettings.$iptTaxonomy.html(html);
    },
    onPostTypeChanged: function onPostTypeChanged() {
      var postType = KeywordSettings.$iptPostType.val();
      var selected = KeywordSettings.postTypeList.find(function (item) {
        return item.value === postType;
      });
      if (selected) {
        KeywordSettings.taxonomyList = selected.taxonomies;
      } else {
        KeywordSettings.taxonomyList = [];
      }
      KeywordSettings.renderTaxonomies();
    },
    selectBannerImage: function selectBannerImage() {
      var file = wp.media({
        title: 'Select or Upload Image',
        button: {
          text: 'Use this image'
        },
        multiple: false
      }).open().on('select', function () {
        var attachment = file.state().get('selection').first().toJSON();
        KeywordSettings.$iptBannerImage.val(attachment.url);
      });
    },
    selectWhatisImage: function selectWhatisImage() {
      var file = wp.media({
        title: 'Select or Upload Image',
        button: {
          text: 'Use this image'
        },
        multiple: false
      }).open().on('select', function () {
        var attachment = file.state().get('selection').first().toJSON();
        KeywordSettings.$iptWhatisImage.val(attachment.url);
      });
    },
    selectFaqImage: function selectFaqImage() {
      var file = wp.media({
        title: 'Select or Upload Image',
        button: {
          text: 'Use this image'
        },
        multiple: false
      }).open().on('select', function () {
        var attachment = file.state().get('selection').first().toJSON();
        KeywordSettings.$iptFaqImage.val(attachment.url);
      });
    }
  };
  var KeywordPages = {
    $scope: null,
    list: [],
    $btnAddKeyWord: null,
    $trTemplate: null,
    $panels: null,
    trTemplate: '',
    init: function init($scope) {
      KeywordPages.$scope = $scope;
      KeywordPages.$btnAddKeyWord = $scope.find('.btn-add-keyword');
      KeywordPages.$btnAddKeyWord.on('click', KeywordPages.addKeyword);
      KeywordPages.$trTemplate = $scope.find('.tr-template');
      KeywordPages.$panels = $scope.find('.panel');
      KeywordPages.trTemplate = KeywordPages.$trTemplate.html();
      KeywordEditor.init($scope);
      KeywordImport.init($scope);
      KeywordTabs.init($scope);
      KeywordSettings.init($scope);
      KeywordWhyus.init($scope);
      KeywordPages.refresh();

      // show panel-list
      // $scope.find('.panel-list').addClass('show')
      // $scope.find('.btn-import').on('click', () => {
      // 	KeywordPages.$panels.removeClass('show')
      // 	$scope.find('.panel-import').addClass('show')
      // })
      // $scope.find('.panel-import .btn-import').on('click', () => {
      // 	KeywordPages.$panels.removeClass('show')
      // 	$scope.find('.panel-import').addClass('show')
      // })
    },
    refresh: function refresh() {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee18() {
        var keywordsObj, keys;
        return _regeneratorRuntime().wrap(function _callee18$(_context18) {
          while (1) switch (_context18.prev = _context18.next) {
            case 0:
              _context18.prev = 0;
              _context18.next = 3;
              return KeywordPages.getKeywordList();
            case 3:
              keywordsObj = _context18.sent;
              KeywordPages.list = [];
              keys = Object.keys(keywordsObj);
              keys.forEach(function (key) {
                KeywordPages.list.push(keywordsObj[key]);
              });
              KeywordPages.render();
              _context18.next = 16;
              break;
            case 10:
              _context18.prev = 10;
              _context18.t0 = _context18["catch"](0);
              KeywordPages.$trTemplate.html('<tr><td colspan="100">Error: ' + _context18.t0.message + '</td></tr>');
              _context18.next = 15;
              return delay(1);
            case 15:
              alert(_context18.t0.message);
            case 16:
            case "end":
              return _context18.stop();
          }
        }, _callee18, null, [[0, 10]]);
      }))();
    },
    getKeywordList: function getKeywordList() {
      return ajaxRequest({
        do_action: 'get_keyword_list'
      });
    },
    renderHtmlText: function renderHtmlText(value) {
      return value.replace(/\\"/g, '"').replace(/\\'/g, "'").replace(/</g, '&lt;').replace(/>/g, '&gt;');
    },
    renderFaq: function renderFaq(faq, index, attr) {
      if (!faq) faq = [];
      if (!faq[index]) faq[index] = {};
      if (!faq[index][attr]) faq[index][attr] = '';
      return KeywordPages.renderHtmlText(faq[index][attr]);
    },
    renderOne: function renderOne(item, index) {
      var $tr = $(KeywordPages.trTemplate);
      if (item.parent === 0) {
        $tr.addClass('main-keyword');
        $tr.find('.is_main_keyword').html('主词');
      } else {
        $tr.addClass('sub-keyword');
        var mainKeyword = KeywordPages.list.find(function (kw) {
          return kw.id === item.parent;
        });
        if (mainKeyword) {
          $tr.find('.is_main_keyword').html(mainKeyword.keyword);
        } else {
          $tr.find('.is_main_keyword').html('');
        }
        // $tr.find('.is_main_keyword').html(item.parent === 0 ? 'Yes' : 'No')
      }

      $tr.find('.keyword').html('<a href="/kwp/' + item.slug + '/" target="_blank" title="点击查看页面">' + item.keyword + '</a>');
      $tr.find('.description').html(KeywordPages.renderHtmlText(item.description || ''));
      $tr.find('.description2').html(KeywordPages.renderHtmlText(item.description2 || ''));
      $tr.find('.slug').html(item.slug);
      $tr.find('.q1').html(KeywordPages.renderFaq(item.faq, 0, 'question'));
      $tr.find('.a1').html(KeywordPages.renderFaq(item.faq, 0, 'answer'));
      $tr.find('.q2').html(KeywordPages.renderFaq(item.faq, 1, 'question'));
      $tr.find('.a2').html(KeywordPages.renderFaq(item.faq, 1, 'answer'));
      $tr.find('.q3').html(KeywordPages.renderFaq(item.faq, 2, 'question'));
      $tr.find('.a3').html(KeywordPages.renderFaq(item.faq, 2, 'answer'));
      $tr.find('.btn-edit').attr('data-index', index);
      $tr.find('.btn-edit').attr('data-id', item.id);
      $tr.find('.btn-delete').attr('data-index', index);
      $tr.find('.btn-delete').attr('data-id', item.id);
      $tr.find('.btn-edit').on('click', function () {
        KeywordPages.onStartEdit(item);
      });
      $tr.find('.btn-delete').on('click', /*#__PURE__*/function () {
        var _ref = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee19(event) {
          return _regeneratorRuntime().wrap(function _callee19$(_context19) {
            while (1) switch (_context19.prev = _context19.next) {
              case 0:
                _context19.next = 2;
                return KeywordPages.onDeleteClicked(event.target);
              case 2:
              case "end":
                return _context19.stop();
            }
          }, _callee19);
        }));
        return function (_x) {
          return _ref.apply(this, arguments);
        };
      }());
      KeywordPages.$scope.find('.panel-list table tbody').append($tr);
    },
    render: function render() {
      // sort before render
      KeywordPages.list.sort(function (a, b) {
        // if (a.parent === 0 && b.parent !== 0) return -1
        // if (a.parent !== 0 && b.parent === 0) return 1
        // if (a.parent === 0 && b.parent === 0) {
        // 	if (a.order > b.order) return 1
        // 	if (a.order < b.order) return -1
        // 	return 0
        // }
        // if (a.parent !== 0 && b.parent !== 0) {
        // 	if (a.parent > b.parent) return 1
        // 	if (a.parent < b.parent) return -1
        // 	if (a.order > b.order) return 1
        // 	if (a.order < b.order) return -1
        // 	return 0
        // }

        if (!a.order) a.order = 0;
        if (!b.order) b.order = 0;
        return b.order - a.order;
      });
      KeywordPages.$scope.find('.panel-list table tbody').html('');
      KeywordPages.list.forEach(function (item) {
        if (item.parent !== 0) return;
        KeywordPages.renderOne(item);
        KeywordPages.list.forEach(function (subItem) {
          if (subItem.parent === item.id) KeywordPages.renderOne(subItem);
        });
      });
      KeywordEditor.mainList = KeywordPages.getMainKeywordList();
    },
    getMainKeywordList: function getMainKeywordList() {
      var list = [];
      KeywordPages.list.forEach(function (item) {
        if (item.parent === 0) {
          list.push(item);
        }
      });
      return list;
    },
    addKeyword: function addKeyword() {
      KeywordEditor.show({}, /*#__PURE__*/function () {
        var _ref2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee20(data) {
          return _regeneratorRuntime().wrap(function _callee20$(_context20) {
            while (1) switch (_context20.prev = _context20.next) {
              case 0:
                _context20.next = 2;
                return KeywordPages.saveKeyword('add', data);
              case 2:
                _context20.next = 4;
                return KeywordPages.refresh();
              case 4:
              case "end":
                return _context20.stop();
            }
          }, _callee20);
        }));
        return function (_x2) {
          return _ref2.apply(this, arguments);
        };
      }());
    },
    // when edit button is clicked
    onStartEdit: function onStartEdit(item) {
      KeywordEditor.show(item, /*#__PURE__*/function () {
        var _ref3 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee21(data) {
          return _regeneratorRuntime().wrap(function _callee21$(_context21) {
            while (1) switch (_context21.prev = _context21.next) {
              case 0:
                _context21.next = 2;
                return KeywordPages.saveKeyword('one', data);
              case 2:
                _context21.next = 4;
                return KeywordPages.refresh();
              case 4:
              case "end":
                return _context21.stop();
            }
          }, _callee21);
        }));
        return function (_x3) {
          return _ref3.apply(this, arguments);
        };
      }());
    },
    onDeleteClicked: function onDeleteClicked(dom) {
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee22() {
        var id, item;
        return _regeneratorRuntime().wrap(function _callee22$(_context22) {
          while (1) switch (_context22.prev = _context22.next) {
            case 0:
              id = parseInt($(dom).attr('data-id'));
              item = KeywordPages.list.find(function (item) {
                return item.id === id;
              });
              if (item) {
                _context22.next = 5;
                break;
              }
              alert('Item not found');
              return _context22.abrupt("return");
            case 5:
              if (!confirm('Are you sure?')) {
                _context22.next = 16;
                break;
              }
              _context22.prev = 6;
              _context22.next = 9;
              return KeywordPages.saveKeyword('del', item);
            case 9:
              _context22.next = 11;
              return KeywordPages.refresh();
            case 11:
              _context22.next = 16;
              break;
            case 13:
              _context22.prev = 13;
              _context22.t0 = _context22["catch"](6);
              alert(_context22.t0.message);
            case 16:
            case "end":
              return _context22.stop();
          }
        }, _callee22, null, [[6, 13]]);
      }))();
    },
    saveKeyword: function saveKeyword(type, kw) {
      return ajaxRequest({
        do_action: 'save_keyword_list',
        save: type,
        data: kw
      });
    }
  };
  ready = function ready() {
    var $scope = $('.infility-global-keyword-pages');
    if ($scope.length > 0) KeywordPages.init($scope);
  };
})();