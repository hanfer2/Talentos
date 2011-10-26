/*!
 * jQuery UI 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI
 */
jQuery.ui ||
  function (c) {
    c.ui = {
      version: "1.8.1",
      plugin: {
        add: function (a, b, d) {
          a = c.ui[a].prototype;
          for (var e in d) {
            a.plugins[e] = a.plugins[e] || [];
            a.plugins[e].push([b, d[e]])
          }
        },
        call: function (a, b, d) {
          if ((b = a.plugins[b]) && a.element[0].parentNode) for (var e = 0; e < b.length; e++) a.options[b[e][0]] && b[e][1].apply(a.element, d)
        }
      },
      contains: function (a, b) {
        return document.compareDocumentPosition ? a.compareDocumentPosition(b) & 16 : a !== b && a.contains(b)
      },
      hasScroll: function (a, b) {
        if (c(a).css("overflow") == "hidden") return false;
        b = b && b == "left" ? "scrollLeft" : "scrollTop";
        var d = false;
        if (a[b] > 0) return true;
        a[b] = 1;
        d = a[b] > 0;
        a[b] = 0;
        return d
      },
      isOverAxis: function (a, b, d) {
        return a > b && a < b + d
      },
      isOver: function (a, b, d, e, f, g) {
        return c.ui.isOverAxis(a, d, f) && c.ui.isOverAxis(b, e, g)
      },
      keyCode: {
        ALT: 18,
        BACKSPACE: 8,
        CAPS_LOCK: 20,
        COMMA: 188,
        CONTROL: 17,
        DELETE: 46,
        DOWN: 40,
        END: 35,
        ENTER: 13,
        ESCAPE: 27,
        HOME: 36,
        INSERT: 45,
        LEFT: 37,
        NUMPAD_ADD: 107,
        NUMPAD_DECIMAL: 110,
        NUMPAD_DIVIDE: 111,
        NUMPAD_ENTER: 108,
        NUMPAD_MULTIPLY: 106,
        NUMPAD_SUBTRACT: 109,
        PAGE_DOWN: 34,
        PAGE_UP: 33,
        PERIOD: 190,
        RIGHT: 39,
        SHIFT: 16,
        SPACE: 32,
        TAB: 9,
        UP: 38
      }
    };
    c.fn.extend({
      _focus: c.fn.focus,
      focus: function (a, b) {
        return typeof a === "number" ? this.each(function () {
          var d = this;
          setTimeout(function () {
            c(d).focus();
            b && b.call(d)
          }, a)
        }) : this._focus.apply(this, arguments)
      },
      enableSelection: function () {
        return this.attr("unselectable", "off").css("MozUserSelect", "")
      },
      disableSelection: function () {
        return this.attr("unselectable", "on").css("MozUserSelect", "none")
      },
      scrollParent: function () {
        var a;
        a = c.browser.msie && /(static|relative)/.test(this.css("position")) || /absolute/.test(this.css("position")) ? this.parents().filter(function () {
          return /(relative|absolute|fixed)/.test(c.curCSS(this, "position", 1)) && /(auto|scroll)/.test(c.curCSS(this, "overflow", 1) + c.curCSS(this, "overflow-y", 1) + c.curCSS(this, "overflow-x", 1))
        }).eq(0) : this.parents().filter(function () {
          return /(auto|scroll)/.test(c.curCSS(this, "overflow", 1) + c.curCSS(this, "overflow-y", 1) + c.curCSS(this, "overflow-x", 1))
        }).eq(0);
        return /fixed/.test(this.css("position")) || !a.length ? c(document) : a
      },
      zIndex: function (a) {
        if (a !== undefined) return this.css("zIndex", a);
        if (this.length) {
          a = c(this[0]);
          for (var b; a.length && a[0] !== document;) {
            b = a.css("position");
            if (b == "absolute" || b == "relative" || b == "fixed") {
              b = parseInt(a.css("zIndex"));
              if (!isNaN(b) && b != 0) return b
            }
            a = a.parent()
          }
        }
        return 0
      }
    });
    c.extend(c.expr[":"], {
      data: function (a, b, d) {
        return !!c.data(a, d[3])
      },
      focusable: function (a) {
        var b = a.nodeName.toLowerCase(),
        d = c.attr(a, "tabindex");
        return (/input|select|textarea|button|object/.test(b) ? !a.disabled : "a" == b || "area" == b ? a.href || !isNaN(d) : !isNaN(d)) && !c(a)["area" == b ? "parents" : "closest"](":hidden").length
      },
      tabbable: function (a) {
        var b = c.attr(a, "tabindex");
        return (isNaN(b) || b >= 0) && c(a).is(":focusable")
      }
    })
  }(jQuery);
;
/*!
 * jQuery UI Widget 1.8.1
 *1141
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Widget
 */
(function (b) {
  var j = b.fn.remove;
  b.fn.remove = function (a, c) {
    return this.each(function () {
      if (!c) if (!a || b.filter(a, [this]).length) b("*", this).add(this).each(function () {
        b(this).triggerHandler("remove")
      });
      return j.call(b(this), a, c)
    })
  };
  b.widget = function (a, c, d) {
    var e = a.split(".")[0],
    f;
    a = a.split(".")[1];
    f = e + "-" + a;
    if (!d) {
      d = c;
      c = b.Widget
    }
    b.expr[":"][f] = function (h) {
      return !!b.data(h, a)
    };
    b[e] = b[e] || {};
    b[e][a] = function (h, g) {
      arguments.length && this._createWidget(h, g)
    };
    c = new c;
    c.options = b.extend({}, c.options);
    b[e][a].prototype =
    b.extend(true, c, {
      namespace: e,
      widgetName: a,
      widgetEventPrefix: b[e][a].prototype.widgetEventPrefix || a,
      widgetBaseClass: f
    }, d);
    b.widget.bridge(a, b[e][a])
  };
  b.widget.bridge = function (a, c) {
    b.fn[a] = function (d) {
      var e = typeof d === "string",
      f = Array.prototype.slice.call(arguments, 1),
      h = this;
      d = !e && f.length ? b.extend.apply(null, [true, d].concat(f)) : d;
      if (e && d.substring(0, 1) === "_") return h;
      e ? this.each(function () {
        var g = b.data(this, a),
        i = g && b.isFunction(g[d]) ? g[d].apply(g, f) : g;
        if (i !== g && i !== undefined) {
          h = i;
          return false
        }
      }) : this.each(function () {
        var g =
        b.data(this, a);
        if (g) {
          d && g.option(d);
          g._init()
        } else b.data(this, a, new c(d, this))
      });
      return h
    }
  };
  b.Widget = function (a, c) {
    arguments.length && this._createWidget(a, c)
  };
  b.Widget.prototype = {
    widgetName: "widget",
    widgetEventPrefix: "",
    options: {
      disabled: false
    },
    _createWidget: function (a, c) {
      this.element = b(c).data(this.widgetName, this);
      this.options = b.extend(true, {}, this.options, b.metadata && b.metadata.get(c)[this.widgetName], a);
      var d = this;
      this.element.bind("remove." + this.widgetName, function () {
        d.destroy()
      });
      this._create();
      this._init()
    },
    _create: function () {},
    _init: function () {},
    destroy: function () {
      this.element.unbind("." + this.widgetName).removeData(this.widgetName);
      this.widget().unbind("." + this.widgetName).removeAttr("aria-disabled").removeClass(this.widgetBaseClass + "-disabled ui-state-disabled")
    },
    widget: function () {
      return this.element
    },
    option: function (a, c) {
      var d = a,
      e = this;
      if (arguments.length === 0) return b.extend({}, e.options);
      if (typeof a === "string") {
        if (c === undefined) return this.options[a];
        d = {};
        d[a] = c
      }
      b.each(d, function (f, h) {
        e._setOption(f, h)
      });
      return e
    },
    _setOption: function (a, c) {
      this.options[a] = c;
      if (a === "disabled") this.widget()[c ? "addClass" : "removeClass"](this.widgetBaseClass + "-disabled ui-state-disabled").attr("aria-disabled", c);
      return this
    },
    enable: function () {
      return this._setOption("disabled", false)
    },
    disable: function () {
      return this._setOption("disabled", true)
    },
    _trigger: function (a, c, d) {
      var e = this.options[a];
      c = b.Event(c);
      c.type = (a === this.widgetEventPrefix ? a : this.widgetEventPrefix + a).toLowerCase();
      d = d || {};
      if (c.originalEvent) {
        a =
        b.event.props.length;
        for (var f; a;) {
          f = b.event.props[--a];
          c[f] = c.originalEvent[f]
        }
      }
      this.element.trigger(c, d);
      return !(b.isFunction(e) && e.call(this.element[0], c, d) === false || c.isDefaultPrevented())
    }
  }
})(jQuery);
;
/*!
 * jQuery UI Mouse 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Mouse
 *
 * Depends:
 *	jquery.ui.widget.js
 */
(function (c) {
  c.widget("ui.mouse", {
    options: {
      cancel: ":input,option",
      distance: 1,
      delay: 0
    },
    _mouseInit: function () {
      var a = this;
      this.element.bind("mousedown." + this.widgetName, function (b) {
        return a._mouseDown(b)
      }).bind("click." + this.widgetName, function (b) {
        if (a._preventClickEvent) {
          a._preventClickEvent = false;
          b.stopImmediatePropagation();
          return false
        }
      });
      this.started = false
    },
    _mouseDestroy: function () {
      this.element.unbind("." + this.widgetName)
    },
    _mouseDown: function (a) {
      a.originalEvent = a.originalEvent || {};
      if (!a.originalEvent.mouseHandled) {
        this._mouseStarted && this._mouseUp(a);
        this._mouseDownEvent = a;
        var b = this,
        e = a.which == 1,
        f = typeof this.options.cancel == "string" ? c(a.target).parents().add(a.target).filter(this.options.cancel).length : false;
        if (!e || f || !this._mouseCapture(a)) return true;
        this.mouseDelayMet = !this.options.delay;
        if (!this.mouseDelayMet) this._mouseDelayTimer = setTimeout(function () {
          b.mouseDelayMet = true
        }, this.options.delay);
        if (this._mouseDistanceMet(a) && this._mouseDelayMet(a)) {
          this._mouseStarted = this._mouseStart(a) !== false;
          if (!this._mouseStarted) {
            a.preventDefault();
            return true
          }
        }
        this._mouseMoveDelegate = function (d) {
          return b._mouseMove(d)
        };
        this._mouseUpDelegate = function (d) {
          return b._mouseUp(d)
        };
        c(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate);
        c.browser.safari || a.preventDefault();
        return a.originalEvent.mouseHandled = true
      }
    },
    _mouseMove: function (a) {
      if (c.browser.msie && !a.button) return this._mouseUp(a);
      if (this._mouseStarted) {
        this._mouseDrag(a);
        return a.preventDefault()
      }
      if (this._mouseDistanceMet(a) && this._mouseDelayMet(a))(this._mouseStarted = this._mouseStart(this._mouseDownEvent, a) !== false) ? this._mouseDrag(a) : this._mouseUp(a);
      return !this._mouseStarted
    },
    _mouseUp: function (a) {
      c(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate);
      if (this._mouseStarted) {
        this._mouseStarted = false;
        this._preventClickEvent = a.target == this._mouseDownEvent.target;
        this._mouseStop(a)
      }
      return false
    },
    _mouseDistanceMet: function (a) {
      return Math.max(Math.abs(this._mouseDownEvent.pageX - a.pageX), Math.abs(this._mouseDownEvent.pageY - a.pageY)) >= this.options.distance
    },
    _mouseDelayMet: function () {
      return this.mouseDelayMet
    },
    _mouseStart: function () {},
    _mouseDrag: function () {},
    _mouseStop: function () {},
    _mouseCapture: function () {
      return true
    }
  })
})(jQuery);
;
/*
 * jQuery UI Position 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Position
 */
(function (c) {
  c.ui = c.ui || {};
  var m = /left|center|right/,
  n = /top|center|bottom/,
  p = c.fn.position,
  q = c.fn.offset;
  c.fn.position = function (a) {
    if (!a || !a.of) return p.apply(this, arguments);
    a = c.extend({}, a);
    var b = c(a.of),
    d = (a.collision || "flip").split(" "),
    e = a.offset ? a.offset.split(" ") : [0, 0],
    g, h, i;
    if (a.of.nodeType === 9) {
      g = b.width();
      h = b.height();
      i = {
        top: 0,
        left: 0
      }
    } else if (a.of.scrollTo && a.of.document) {
      g = b.width();
      h = b.height();
      i = {
        top: b.scrollTop(),
        left: b.scrollLeft()
      }
    } else if (a.of.preventDefault) {
      a.at = "left top";
      g = h =
      0;
      i = {
        top: a.of.pageY,
        left: a.of.pageX
      }
    } else {
      g = b.outerWidth();
      h = b.outerHeight();
      i = b.offset()
    }
    c.each(["my", "at"], function () {
      var f = (a[this] || "").split(" ");
      if (f.length === 1) f = m.test(f[0]) ? f.concat(["center"]) : n.test(f[0]) ? ["center"].concat(f) : ["center", "center"];
      f[0] = m.test(f[0]) ? f[0] : "center";
      f[1] = n.test(f[1]) ? f[1] : "center";
      a[this] = f
    });
    if (d.length === 1) d[1] = d[0];
    e[0] = parseInt(e[0], 10) || 0;
    if (e.length === 1) e[1] = e[0];
    e[1] = parseInt(e[1], 10) || 0;
    if (a.at[0] === "right") i.left += g;
    else if (a.at[0] === "center") i.left += g / 2;
    if (a.at[1] === "bottom") i.top += h;
    else if (a.at[1] === "center") i.top += h / 2;
    i.left += e[0];
    i.top += e[1];
    return this.each(function () {
      var f = c(this),
      k = f.outerWidth(),
      l = f.outerHeight(),
      j = c.extend({}, i);
      if (a.my[0] === "right") j.left -= k;
      else if (a.my[0] === "center") j.left -= k / 2;
      if (a.my[1] === "bottom") j.top -= l;
      else if (a.my[1] === "center") j.top -= l / 2;
      j.left = parseInt(j.left);
      j.top = parseInt(j.top);
      c.each(["left", "top"], function (o, r) {
        c.ui.position[d[o]] && c.ui.position[d[o]][r](j, {
          targetWidth: g,
          targetHeight: h,
          elemWidth: k,
          elemHeight: l,
          offset: e,
          my: a.my,
          at: a.at
        })
      });
      c.fn.bgiframe && f.bgiframe();
      f.offset(c.extend(j, {
        using: a.using
      }))
    })
  };
  c.ui.position = {
    fit: {
      left: function (a, b) {
        var d = c(window);
        b = a.left + b.elemWidth - d.width() - d.scrollLeft();
        a.left = b > 0 ? a.left - b : Math.max(0, a.left)
      },
      top: function (a, b) {
        var d = c(window);
        b = a.top + b.elemHeight - d.height() - d.scrollTop();
        a.top = b > 0 ? a.top - b : Math.max(0, a.top)
      }
    },
    flip: {
      left: function (a, b) {
        if (b.at[0] !== "center") {
          var d = c(window);
          d = a.left + b.elemWidth - d.width() - d.scrollLeft();
          var e = b.my[0] === "left" ? -b.elemWidth : b.my[0] === "right" ? b.elemWidth : 0,
          g = -2 * b.offset[0];
          a.left += a.left < 0 ? e + b.targetWidth + g : d > 0 ? e - b.targetWidth + g : 0
        }
      },
      top: function (a, b) {
        if (b.at[1] !== "center") {
          var d = c(window);
          d = a.top + b.elemHeight - d.height() - d.scrollTop();
          var e = b.my[1] === "top" ? -b.elemHeight : b.my[1] === "bottom" ? b.elemHeight : 0,
          g = b.at[1] === "top" ? b.targetHeight : -b.targetHeight,
          h = -2 * b.offset[1];
          a.top += a.top < 0 ? e + b.targetHeight + h : d > 0 ? e + g + h : 0
        }
      }
    }
  };
  if (!c.offset.setOffset) {
    c.offset.setOffset = function (a, b) {
      if (/static/.test(c.curCSS(a, "position"))) a.style.position = "relative";
      var d = c(a),
      e = d.offset(),
      g = parseInt(c.curCSS(a, "top", true), 10) || 0,
      h = parseInt(c.curCSS(a, "left", true), 10) || 0;
      e = {
        top: b.top - e.top + g,
        left: b.left - e.left + h
      };
      "using" in b ? b.using.call(a, e) : d.css(e)
    };
    c.fn.offset = function (a) {
      var b = this[0];
      if (!b || !b.ownerDocument) return null;
      if (a) return this.each(function () {
        c.offset.setOffset(this, a)
      });
      return q.call(this)
    }
  }
})(jQuery);
;
/*
 * jQuery UI Draggable 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Draggables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function (d) {
  d.widget("ui.draggable", d.ui.mouse, {
    widgetEventPrefix: "drag",
    options: {
      addClasses: true,
      appendTo: "parent",
      axis: false,
      connectToSortable: false,
      containment: false,
      cursor: "auto",
      cursorAt: false,
      grid: false,
      handle: false,
      helper: "original",
      iframeFix: false,
      opacity: false,
      refreshPositions: false,
      revert: false,
      revertDuration: 500,
      scope: "default",
      scroll: true,
      scrollSensitivity: 20,
      scrollSpeed: 20,
      snap: false,
      snapMode: "both",
      snapTolerance: 20,
      stack: false,
      zIndex: false
    },
    _create: function () {
      if (this.options.helper == "original" && !/^(?:r|a|f)/.test(this.element.css("position"))) this.element[0].style.position = "relative";
      this.options.addClasses && this.element.addClass("ui-draggable");
      this.options.disabled && this.element.addClass("ui-draggable-disabled");
      this._mouseInit()
    },
    destroy: function () {
      if (this.element.data("draggable")) {
        this.element.removeData("draggable").unbind(".draggable").removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled");
        this._mouseDestroy();
        return this
      }
    },
    _mouseCapture: function (a) {
      var b =
      this.options;
      if (this.helper || b.disabled || d(a.target).is(".ui-resizable-handle")) return false;
      this.handle = this._getHandle(a);
      if (!this.handle) return false;
      return true
    },
    _mouseStart: function (a) {
      var b = this.options;
      this.helper = this._createHelper(a);
      this._cacheHelperProportions();
      if (d.ui.ddmanager) d.ui.ddmanager.current = this;
      this._cacheMargins();
      this.cssPosition = this.helper.css("position");
      this.scrollParent = this.helper.scrollParent();
      this.offset = this.positionAbs = this.element.offset();
      this.offset = {
        top: this.offset.top - this.margins.top,
        left: this.offset.left - this.margins.left
      };
      d.extend(this.offset, {
        click: {
          left: a.pageX - this.offset.left,
          top: a.pageY - this.offset.top
        },
        parent: this._getParentOffset(),
        relative: this._getRelativeOffset()
      });
      this.originalPosition = this.position = this._generatePosition(a);
      this.originalPageX = a.pageX;
      this.originalPageY = a.pageY;
      b.cursorAt && this._adjustOffsetFromHelper(b.cursorAt);
      b.containment && this._setContainment();
      if (this._trigger("start", a) === false) {
        this._clear();
        return false
      }
      this._cacheHelperProportions();
      d.ui.ddmanager && !b.dropBehaviour && d.ui.ddmanager.prepareOffsets(this, a);
      this.helper.addClass("ui-draggable-dragging");
      this._mouseDrag(a, true);
      return true
    },
    _mouseDrag: function (a, b) {
      this.position = this._generatePosition(a);
      this.positionAbs = this._convertPositionTo("absolute");
      if (!b) {
        b = this._uiHash();
        if (this._trigger("drag", a, b) === false) {
          this._mouseUp({});
          return false
        }
        this.position = b.position
      }
      if (!this.options.axis || this.options.axis != "y") this.helper[0].style.left = this.position.left + "px";
      if (!this.options.axis || this.options.axis != "x") this.helper[0].style.top = this.position.top + "px";
      d.ui.ddmanager && d.ui.ddmanager.drag(this, a);
      return false
    },
    _mouseStop: function (a) {
      var b = false;
      if (d.ui.ddmanager && !this.options.dropBehaviour) b = d.ui.ddmanager.drop(this, a);
      if (this.dropped) {
        b = this.dropped;
        this.dropped = false
      }
      if (!this.element[0] || !this.element[0].parentNode) return false;
      if (this.options.revert == "invalid" && !b || this.options.revert == "valid" && b || this.options.revert === true || d.isFunction(this.options.revert) && this.options.revert.call(this.element, b)) {
        var c = this;
        d(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function () {
          c._trigger("stop", a) !== false && c._clear()
        })
      } else this._trigger("stop", a) !== false && this._clear();
      return false
    },
    cancel: function () {
      this.helper.is(".ui-draggable-dragging") ? this._mouseUp({}) : this._clear();
      return this
    },
    _getHandle: function (a) {
      var b = !this.options.handle || !d(this.options.handle, this.element).length ? true : false;
      d(this.options.handle, this.element).find("*").andSelf().each(function () {
        if (this == a.target) b = true
      });
      return b
    },
    _createHelper: function (a) {
      var b = this.options;
      a = d.isFunction(b.helper) ? d(b.helper.apply(this.element[0], [a])) : b.helper == "clone" ? this.element.clone() : this.element;
      a.parents("body").length || a.appendTo(b.appendTo == "parent" ? this.element[0].parentNode : b.appendTo);
      a[0] != this.element[0] && !/(fixed|absolute)/.test(a.css("position")) && a.css("position", "absolute");
      return a
    },
    _adjustOffsetFromHelper: function (a) {
      if (typeof a == "string") a = a.split(" ");
      if (d.isArray(a)) a = {
        left: +a[0],
        top: +a[1] || 0
      };
      if ("left" in a) this.offset.click.left = a.left + this.margins.left;
      if ("right" in a) this.offset.click.left = this.helperProportions.width - a.right + this.margins.left;
      if ("top" in a) this.offset.click.top = a.top + this.margins.top;
      if ("bottom" in a) this.offset.click.top = this.helperProportions.height - a.bottom + this.margins.top
    },
    _getParentOffset: function () {
      this.offsetParent = this.helper.offsetParent();
      var a = this.offsetParent.offset();
      if (this.cssPosition == "absolute" && this.scrollParent[0] != document && d.ui.contains(this.scrollParent[0], this.offsetParent[0])) {
        a.left += this.scrollParent.scrollLeft();
        a.top += this.scrollParent.scrollTop()
      }
      if (this.offsetParent[0] == document.body || this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() == "html" && d.browser.msie) a = {
        top: 0,
        left: 0
      };
      return {
        top: a.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
        left: a.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
      }
    },
    _getRelativeOffset: function () {
      if (this.cssPosition == "relative") {
        var a = this.element.position();
        return {
          top: a.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
          left: a.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
        }
      } else return {
        top: 0,
        left: 0
      }
    },
    _cacheMargins: function () {
      this.margins = {
        left: parseInt(this.element.css("marginLeft"), 10) || 0,
        top: parseInt(this.element.css("marginTop"), 10) || 0
      }
    },
    _cacheHelperProportions: function () {
      this.helperProportions = {
        width: this.helper.outerWidth(),
        height: this.helper.outerHeight()
      }
    },
    _setContainment: function () {
      var a = this.options;
      if (a.containment == "parent") a.containment = this.helper[0].parentNode;
      if (a.containment == "document" || a.containment == "window") this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, d(a.containment == "document" ? document : window).width() - this.helperProportions.width - this.margins.left, (d(a.containment == "document" ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top];
      if (!/^(document|window|parent)$/.test(a.containment) && a.containment.constructor != Array) {
        var b = d(a.containment)[0];
        if (b) {
          a = d(a.containment).offset();
          var c = d(b).css("overflow") != "hidden";
          this.containment = [a.left + (parseInt(d(b).css("borderLeftWidth"), 10) || 0) + (parseInt(d(b).css("paddingLeft"), 10) || 0) - this.margins.left, a.top + (parseInt(d(b).css("borderTopWidth"), 10) || 0) + (parseInt(d(b).css("paddingTop"), 10) || 0) - this.margins.top, a.left + (c ? Math.max(b.scrollWidth, b.offsetWidth) : b.offsetWidth) - (parseInt(d(b).css("borderLeftWidth"), 10) || 0) - (parseInt(d(b).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, a.top + (c ? Math.max(b.scrollHeight, b.offsetHeight) : b.offsetHeight) - (parseInt(d(b).css("borderTopWidth"), 10) || 0) - (parseInt(d(b).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top]
        }
      } else if (a.containment.constructor == Array) this.containment = a.containment
    },
    _convertPositionTo: function (a, b) {
      if (!b) b = this.position;
      a = a == "absolute" ? 1 : -1;
      var c = this.cssPosition == "absolute" && !(this.scrollParent[0] != document && d.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent,
      f = /(html|body)/i.test(c[0].tagName);
      return {
        top: b.top + this.offset.relative.top * a + this.offset.parent.top * a - (d.browser.safari && d.browser.version < 526 && this.cssPosition == "fixed" ? 0 : (this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : f ? 0 : c.scrollTop()) * a),
        left: b.left + this.offset.relative.left * a + this.offset.parent.left * a - (d.browser.safari && d.browser.version < 526 && this.cssPosition == "fixed" ? 0 : (this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : f ? 0 : c.scrollLeft()) * a)
      }
    },
    _generatePosition: function (a) {
      var b = this.options,
      c = this.cssPosition == "absolute" && !(this.scrollParent[0] != document && d.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent,
      f = /(html|body)/i.test(c[0].tagName),
      e = a.pageX,
      g = a.pageY;
      if (this.originalPosition) {
        if (this.containment) {
          if (a.pageX - this.offset.click.left < this.containment[0]) e = this.containment[0] + this.offset.click.left;
          if (a.pageY - this.offset.click.top < this.containment[1]) g = this.containment[1] + this.offset.click.top;
          if (a.pageX - this.offset.click.left > this.containment[2]) e = this.containment[2] + this.offset.click.left;
          if (a.pageY - this.offset.click.top > this.containment[3]) g = this.containment[3] + this.offset.click.top
        }
        if (b.grid) {
          g = this.originalPageY + Math.round((g - this.originalPageY) / b.grid[1]) * b.grid[1];
          g = this.containment ? !(g - this.offset.click.top < this.containment[1] || g - this.offset.click.top > this.containment[3]) ? g : !(g - this.offset.click.top < this.containment[1]) ? g - b.grid[1] : g + b.grid[1] : g;
          e = this.originalPageX + Math.round((e - this.originalPageX) / b.grid[0]) * b.grid[0];
          e = this.containment ? !(e - this.offset.click.left < this.containment[0] || e - this.offset.click.left > this.containment[2]) ? e : !(e - this.offset.click.left < this.containment[0]) ? e - b.grid[0] : e + b.grid[0] : e
        }
      }
      return {
        top: g - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + (d.browser.safari && d.browser.version < 526 && this.cssPosition == "fixed" ? 0 : this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : f ? 0 : c.scrollTop()),
        left: e - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + (d.browser.safari && d.browser.version < 526 && this.cssPosition == "fixed" ? 0 : this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : f ? 0 : c.scrollLeft())
      }
    },
    _clear: function () {
      this.helper.removeClass("ui-draggable-dragging");
      this.helper[0] != this.element[0] && !this.cancelHelperRemoval && this.helper.remove();
      this.helper = null;
      this.cancelHelperRemoval = false
    },
    _trigger: function (a, b, c) {
      c = c || this._uiHash();
      d.ui.plugin.call(this, a, [b, c]);
      if (a == "drag") this.positionAbs = this._convertPositionTo("absolute");
      return d.Widget.prototype._trigger.call(this, a, b, c)
    },
    plugins: {},
    _uiHash: function () {
      return {
        helper: this.helper,
        position: this.position,
        originalPosition: this.originalPosition,
        offset: this.positionAbs
      }
    }
  });
  d.extend(d.ui.draggable, {
    version: "1.8.1"
  });
  d.ui.plugin.add("draggable", "connectToSortable", {
    start: function (a, b) {
      var c = d(this).data("draggable"),
      f = c.options,
      e = d.extend({}, b, {
        item: c.element
      });
      c.sortables = [];
      d(f.connectToSortable).each(function () {
        var g = d.data(this, "sortable");
        if (g && !g.options.disabled) {
          c.sortables.push({
            instance: g,
            shouldRevert: g.options.revert
          });
          g._refreshItems();
          g._trigger("activate", a, e)
        }
      })
    },
    stop: function (a, b) {
      var c = d(this).data("draggable"),
      f = d.extend({}, b, {
        item: c.element
      });
      d.each(c.sortables, function () {
        if (this.instance.isOver) {
          this.instance.isOver = 0;
          c.cancelHelperRemoval = true;
          this.instance.cancelHelperRemoval = false;
          if (this.shouldRevert) this.instance.options.revert = true;
          this.instance._mouseStop(a);
          this.instance.options.helper = this.instance.options._helper;
          c.options.helper == "original" && this.instance.currentItem.css({
            top: "auto",
            left: "auto"
          })
        } else {
          this.instance.cancelHelperRemoval = false;
          this.instance._trigger("deactivate", a, f)
        }
      })
    },
    drag: function (a, b) {
      var c = d(this).data("draggable"),
      f = this;
      d.each(c.sortables, function () {
        this.instance.positionAbs = c.positionAbs;
        this.instance.helperProportions = c.helperProportions;
        this.instance.offset.click = c.offset.click;
        if (this.instance._intersectsWith(this.instance.containerCache)) {
          if (!this.instance.isOver) {
            this.instance.isOver =
            1;
            this.instance.currentItem = d(f).clone().appendTo(this.instance.element).data("sortable-item", true);
            this.instance.options._helper = this.instance.options.helper;
            this.instance.options.helper = function () {
              return b.helper[0]
            };
            a.target = this.instance.currentItem[0];
            this.instance._mouseCapture(a, true);
            this.instance._mouseStart(a, true, true);
            this.instance.offset.click.top = c.offset.click.top;
            this.instance.offset.click.left = c.offset.click.left;
            this.instance.offset.parent.left -= c.offset.parent.left - this.instance.offset.parent.left;
            this.instance.offset.parent.top -= c.offset.parent.top - this.instance.offset.parent.top;
            c._trigger("toSortable", a);
            c.dropped = this.instance.element;
            c.currentItem = c.element;
            this.instance.fromOutside = c
          }
          this.instance.currentItem && this.instance._mouseDrag(a)
        } else if (this.instance.isOver) {
          this.instance.isOver = 0;
          this.instance.cancelHelperRemoval = true;
          this.instance.options.revert = false;
          this.instance._trigger("out", a, this.instance._uiHash(this.instance));
          this.instance._mouseStop(a, true);
          this.instance.options.helper =
          this.instance.options._helper;
          this.instance.currentItem.remove();
          this.instance.placeholder && this.instance.placeholder.remove();
          c._trigger("fromSortable", a);
          c.dropped = false
        }
      })
    }
  });
  d.ui.plugin.add("draggable", "cursor", {
    start: function () {
      var a = d("body"),
      b = d(this).data("draggable").options;
      if (a.css("cursor")) b._cursor = a.css("cursor");
      a.css("cursor", b.cursor)
    },
    stop: function () {
      var a = d(this).data("draggable").options;
      a._cursor && d("body").css("cursor", a._cursor)
    }
  });
  d.ui.plugin.add("draggable", "iframeFix", {
    start: function () {
      var a =
      d(this).data("draggable").options;
      d(a.iframeFix === true ? "iframe" : a.iframeFix).each(function () {
        d('<div class="ui-draggable-iframeFix" style="background: #fff;"></div>').css({
          width: this.offsetWidth + "px",
          height: this.offsetHeight + "px",
          position: "absolute",
          opacity: "0.001",
          zIndex: 1E3
        }).css(d(this).offset()).appendTo("body")
      })
    },
    stop: function () {
      d("div.ui-draggable-iframeFix").each(function () {
        this.parentNode.removeChild(this)
      })
    }
  });
  d.ui.plugin.add("draggable", "opacity", {
    start: function (a, b) {
      a = d(b.helper);
      b = d(this).data("draggable").options;
      if (a.css("opacity")) b._opacity = a.css("opacity");
      a.css("opacity", b.opacity)
    },
    stop: function (a, b) {
      a = d(this).data("draggable").options;
      a._opacity && d(b.helper).css("opacity", a._opacity)
    }
  });
  d.ui.plugin.add("draggable", "scroll", {
    start: function () {
      var a = d(this).data("draggable");
      if (a.scrollParent[0] != document && a.scrollParent[0].tagName != "HTML") a.overflowOffset = a.scrollParent.offset()
    },
    drag: function (a) {
      var b = d(this).data("draggable"),
      c = b.options,
      f = false;
      if (b.scrollParent[0] != document && b.scrollParent[0].tagName != "HTML") {
        if (!c.axis || c.axis != "x") if (b.overflowOffset.top + b.scrollParent[0].offsetHeight - a.pageY < c.scrollSensitivity) b.scrollParent[0].scrollTop = f = b.scrollParent[0].scrollTop + c.scrollSpeed;
          else if (a.pageY - b.overflowOffset.top < c.scrollSensitivity) b.scrollParent[0].scrollTop = f = b.scrollParent[0].scrollTop - c.scrollSpeed;
        if (!c.axis || c.axis != "y") if (b.overflowOffset.left + b.scrollParent[0].offsetWidth - a.pageX < c.scrollSensitivity) b.scrollParent[0].scrollLeft = f = b.scrollParent[0].scrollLeft + c.scrollSpeed;
          else if (a.pageX - b.overflowOffset.left < c.scrollSensitivity) b.scrollParent[0].scrollLeft = f = b.scrollParent[0].scrollLeft - c.scrollSpeed
      } else {
        if (!c.axis || c.axis != "x") if (a.pageY - d(document).scrollTop() < c.scrollSensitivity) f = d(document).scrollTop(d(document).scrollTop() - c.scrollSpeed);
          else if (d(window).height() - (a.pageY - d(document).scrollTop()) < c.scrollSensitivity) f = d(document).scrollTop(d(document).scrollTop() + c.scrollSpeed);
        if (!c.axis || c.axis != "y") if (a.pageX - d(document).scrollLeft() < c.scrollSensitivity) f = d(document).scrollLeft(d(document).scrollLeft() - c.scrollSpeed);
          else if (d(window).width() - (a.pageX - d(document).scrollLeft()) < c.scrollSensitivity) f = d(document).scrollLeft(d(document).scrollLeft() + c.scrollSpeed)
      }
      f !== false && d.ui.ddmanager && !c.dropBehaviour && d.ui.ddmanager.prepareOffsets(b, a)
    }
  });
  d.ui.plugin.add("draggable", "snap", {
    start: function () {
      var a = d(this).data("draggable"),
      b = a.options;
      a.snapElements = [];
      d(b.snap.constructor != String ? b.snap.items || ":data(draggable)" : b.snap).each(function () {
        var c = d(this),
        f = c.offset();
        this != a.element[0] && a.snapElements.push({
          item: this,
          width: c.outerWidth(),
          height: c.outerHeight(),
          top: f.top,
          left: f.left
        })
      })
    },
    drag: function (a, b) {
      for (var c = d(this).data("draggable"), f = c.options, e = f.snapTolerance, g = b.offset.left, n = g + c.helperProportions.width, m = b.offset.top, o = m + c.helperProportions.height, h = c.snapElements.length - 1; h >= 0; h--) {
        var i = c.snapElements[h].left,
        k = i + c.snapElements[h].width,
        j = c.snapElements[h].top,
        l = j + c.snapElements[h].height;
        if (i - e < g && g < k + e && j - e < m && m < l + e || i - e < g && g < k + e && j - e < o && o < l + e || i - e < n && n < k + e && j - e < m && m < l + e || i - e < n && n < k + e && j - e < o && o < l + e) {
          if (f.snapMode != "inner") {
            var p = Math.abs(j - o) <= e,
            q = Math.abs(l - m) <= e,
            r = Math.abs(i - n) <= e,
            s = Math.abs(k - g) <= e;
            if (p) b.position.top = c._convertPositionTo("relative", {
              top: j - c.helperProportions.height,
              left: 0
            }).top - c.margins.top;
            if (q) b.position.top = c._convertPositionTo("relative", {
              top: l,
              left: 0
            }).top - c.margins.top;
            if (r) b.position.left = c._convertPositionTo("relative", {
              top: 0,
              left: i - c.helperProportions.width
            }).left - c.margins.left;
            if (s) b.position.left = c._convertPositionTo("relative", {
              top: 0,
              left: k
            }).left - c.margins.left
          }
          var t =
          p || q || r || s;
          if (f.snapMode != "outer") {
            p = Math.abs(j - m) <= e;
            q = Math.abs(l - o) <= e;
            r = Math.abs(i - g) <= e;
            s = Math.abs(k - n) <= e;
            if (p) b.position.top = c._convertPositionTo("relative", {
              top: j,
              left: 0
            }).top - c.margins.top;
            if (q) b.position.top = c._convertPositionTo("relative", {
              top: l - c.helperProportions.height,
              left: 0
            }).top - c.margins.top;
            if (r) b.position.left = c._convertPositionTo("relative", {
              top: 0,
              left: i
            }).left - c.margins.left;
            if (s) b.position.left = c._convertPositionTo("relative", {
              top: 0,
              left: k - c.helperProportions.width
            }).left - c.margins.left
          }
          if (!c.snapElements[h].snapping && (p || q || r || s || t)) c.options.snap.snap && c.options.snap.snap.call(c.element, a, d.extend(c._uiHash(), {
            snapItem: c.snapElements[h].item
          }));
          c.snapElements[h].snapping = p || q || r || s || t
        } else {
          c.snapElements[h].snapping && c.options.snap.release && c.options.snap.release.call(c.element, a, d.extend(c._uiHash(), {
            snapItem: c.snapElements[h].item
          }));
          c.snapElements[h].snapping = false
        }
      }
    }
  });
  d.ui.plugin.add("draggable", "stack", {
    start: function () {
      var a = d(this).data("draggable").options;
      a = d.makeArray(d(a.stack)).sort(function (c, f) {
        return (parseInt(d(c).css("zIndex"), 10) || 0) - (parseInt(d(f).css("zIndex"), 10) || 0)
      });
      if (a.length) {
        var b = parseInt(a[0].style.zIndex) || 0;
        d(a).each(function (c) {
          this.style.zIndex = b + c
        });
        this[0].style.zIndex = b + a.length
      }
    }
  });
  d.ui.plugin.add("draggable", "zIndex", {
    start: function (a, b) {
      a = d(b.helper);
      b = d(this).data("draggable").options;
      if (a.css("zIndex")) b._zIndex = a.css("zIndex");
      a.css("zIndex", b.zIndex)
    },
    stop: function (a, b) {
      a = d(this).data("draggable").options;
      a._zIndex && d(b.helper).css("zIndex", a._zIndex)
    }
  })
})(jQuery);
;
/*
 * jQuery UI Droppable 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Droppables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.mouse.js
 *	jquery.ui.draggable.js
 */
(function (d) {
  d.widget("ui.droppable", {
    widgetEventPrefix: "drop",
    options: {
      accept: "*",
      activeClass: false,
      addClasses: true,
      greedy: false,
      hoverClass: false,
      scope: "default",
      tolerance: "intersect"
    },
    _create: function () {
      var a = this.options,
      b = a.accept;
      this.isover = 0;
      this.isout = 1;
      this.accept = d.isFunction(b) ? b : function (c) {
        return c.is(b)
      };
      this.proportions = {
        width: this.element[0].offsetWidth,
        height: this.element[0].offsetHeight
      };
      d.ui.ddmanager.droppables[a.scope] = d.ui.ddmanager.droppables[a.scope] || [];
      d.ui.ddmanager.droppables[a.scope].push(this);
      a.addClasses && this.element.addClass("ui-droppable")
    },
    destroy: function () {
      for (var a = d.ui.ddmanager.droppables[this.options.scope], b = 0; b < a.length; b++) a[b] == this && a.splice(b, 1);
      this.element.removeClass("ui-droppable ui-droppable-disabled").removeData("droppable").unbind(".droppable");
      return this
    },
    _setOption: function (a, b) {
      if (a == "accept") this.accept = d.isFunction(b) ? b : function (c) {
        return c.is(b)
      };
      d.Widget.prototype._setOption.apply(this, arguments)
    },
    _activate: function (a) {
      var b = d.ui.ddmanager.current;
      this.options.activeClass && this.element.addClass(this.options.activeClass);
      b && this._trigger("activate", a, this.ui(b))
    },
    _deactivate: function (a) {
      var b = d.ui.ddmanager.current;
      this.options.activeClass && this.element.removeClass(this.options.activeClass);
      b && this._trigger("deactivate", a, this.ui(b))
    },
    _over: function (a) {
      var b = d.ui.ddmanager.current;
      if (!(!b || (b.currentItem || b.element)[0] == this.element[0])) if (this.accept.call(this.element[0], b.currentItem || b.element)) {
        this.options.hoverClass && this.element.addClass(this.options.hoverClass);
        this._trigger("over", a, this.ui(b))
      }
    },
    _out: function (a) {
      var b = d.ui.ddmanager.current;
      if (!(!b || (b.currentItem || b.element)[0] == this.element[0])) if (this.accept.call(this.element[0], b.currentItem || b.element)) {
        this.options.hoverClass && this.element.removeClass(this.options.hoverClass);
        this._trigger("out", a, this.ui(b))
      }
    },
    _drop: function (a, b) {
      var c = b || d.ui.ddmanager.current;
      if (!c || (c.currentItem || c.element)[0] == this.element[0]) return false;
      var e = false;
      this.element.find(":data(droppable)").not(".ui-draggable-dragging").each(function () {
        var g =
        d.data(this, "droppable");
        if (g.options.greedy && !g.options.disabled && g.options.scope == c.options.scope && g.accept.call(g.element[0], c.currentItem || c.element) && d.ui.intersect(c, d.extend(g, {
          offset: g.element.offset()
        }), g.options.tolerance)) {
          e = true;
          return false
        }
      });
      if (e) return false;
      if (this.accept.call(this.element[0], c.currentItem || c.element)) {
        this.options.activeClass && this.element.removeClass(this.options.activeClass);
        this.options.hoverClass && this.element.removeClass(this.options.hoverClass);
        this._trigger("drop", a, this.ui(c));
        return this.element
      }
      return false
    },
    ui: function (a) {
      return {
        draggable: a.currentItem || a.element,
        helper: a.helper,
        position: a.position,
        offset: a.positionAbs
      }
    }
  });
  d.extend(d.ui.droppable, {
    version: "1.8.1"
  });
  d.ui.intersect = function (a, b, c) {
    if (!b.offset) return false;
    var e = (a.positionAbs || a.position.absolute).left,
    g = e + a.helperProportions.width,
    f = (a.positionAbs || a.position.absolute).top,
    h = f + a.helperProportions.height,
    i = b.offset.left,
    k = i + b.proportions.width,
    j = b.offset.top,
    l = j + b.proportions.height;
    switch (c) {
      case "fit":
        return i < e && g < k && j < f && h < l;
      case "intersect":
        return i < e + a.helperProportions.width / 2 && g - a.helperProportions.width / 2 < k && j < f + a.helperProportions.height / 2 && h - a.helperProportions.height / 2 < l;
      case "pointer":
        return d.ui.isOver((a.positionAbs || a.position.absolute).top + (a.clickOffset || a.offset.click).top, (a.positionAbs || a.position.absolute).left + (a.clickOffset || a.offset.click).left, j, i, b.proportions.height, b.proportions.width);
      case "touch":
        return (f >= j && f <= l || h >= j && h <= l || f < j && h > l) && (e >= i && e <= k || g >= i && g <= k || e < i && g > k);
      default:
        return false
    }
  };
  d.ui.ddmanager = {
    current: null,
    droppables: {
      "default": []
    },
    prepareOffsets: function (a, b) {
      var c = d.ui.ddmanager.droppables[a.options.scope] || [],
      e = b ? b.type : null,
      g = (a.currentItem || a.element).find(":data(droppable)").andSelf(),
      f = 0;
        a: for (; f < c.length; f++) if (!(c[f].options.disabled || a && !c[f].accept.call(c[f].element[0], a.currentItem || a.element))) {
          for (var h = 0; h < g.length; h++) if (g[h] == c[f].element[0]) {
            c[f].proportions.height = 0;
            continue a
          }
          c[f].visible = c[f].element.css("display") != "none";
          if (c[f].visible) {
            c[f].offset = c[f].element.offset();
            c[f].proportions = {
              width: c[f].element[0].offsetWidth,
              height: c[f].element[0].offsetHeight
            };
            e == "mousedown" && c[f]._activate.call(c[f], b)
          }
        }
    },
    drop: function (a, b) {
      var c = false;
      d.each(d.ui.ddmanager.droppables[a.options.scope] || [], function () {
        if (this.options) {
          if (!this.options.disabled && this.visible && d.ui.intersect(a, this, this.options.tolerance)) c = c || this._drop.call(this, b);
          if (!this.options.disabled && this.visible && this.accept.call(this.element[0], a.currentItem || a.element)) {
            this.isout = 1;
            this.isover = 0;
            this._deactivate.call(this, b)
          }
        }
      });
      return c
    },
    drag: function (a, b) {
      a.options.refreshPositions && d.ui.ddmanager.prepareOffsets(a, b);
      d.each(d.ui.ddmanager.droppables[a.options.scope] || [], function () {
        if (!(this.options.disabled || this.greedyChild || !this.visible)) {
          var c = d.ui.intersect(a, this, this.options.tolerance);
          if (c = !c && this.isover == 1 ? "isout" : c && this.isover == 0 ? "isover" : null) {
            var e;
            if (this.options.greedy) {
              var g = this.element.parents(":data(droppable):eq(0)");
              if (g.length) {
                e =
                d.data(g[0], "droppable");
                e.greedyChild = c == "isover" ? 1 : 0
              }
            }
            if (e && c == "isover") {
              e.isover = 0;
              e.isout = 1;
              e._out.call(e, b)
            }
            this[c] = 1;
            this[c == "isout" ? "isover" : "isout"] = 0;
            this[c == "isover" ? "_over" : "_out"].call(this, b);
            if (e && c == "isout") {
              e.isout = 0;
              e.isover = 1;
              e._over.call(e, b)
            }
          }
        }
      })
    }
  }
})(jQuery);
;
/*
 * jQuery UI Resizable 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Resizables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function (d) {
  d.widget("ui.resizable", d.ui.mouse, {
    widgetEventPrefix: "resize",
    options: {
      alsoResize: false,
      animate: false,
      animateDuration: "slow",
      animateEasing: "swing",
      aspectRatio: false,
      autoHide: false,
      containment: false,
      ghost: false,
      grid: false,
      handles: "e,s,se",
      helper: false,
      maxHeight: null,
      maxWidth: null,
      minHeight: 10,
      minWidth: 10,
      zIndex: 1E3
    },
    _create: function () {
      var b = this,
      a = this.options;
      this.element.addClass("ui-resizable");
      d.extend(this, {
        _aspectRatio: !! a.aspectRatio,
        aspectRatio: a.aspectRatio,
        originalElement: this.element,
        _proportionallyResizeElements: [],
        _helper: a.helper || a.ghost || a.animate ? a.helper || "ui-resizable-helper" : null
      });
      if (this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i)) {
        /relative/.test(this.element.css("position")) && d.browser.opera && this.element.css({
          position: "relative",
          top: "auto",
          left: "auto"
        });
        this.element.wrap(d('<div class="ui-wrapper" style="overflow: hidden;"></div>').css({
          position: this.element.css("position"),
          width: this.element.outerWidth(),
          height: this.element.outerHeight(),
          top: this.element.css("top"),
          left: this.element.css("left")
        }));
        this.element = this.element.parent().data("resizable", this.element.data("resizable"));
        this.elementIsWrapper = true;
        this.element.css({
          marginLeft: this.originalElement.css("marginLeft"),
          marginTop: this.originalElement.css("marginTop"),
          marginRight: this.originalElement.css("marginRight"),
          marginBottom: this.originalElement.css("marginBottom")
        });
        this.originalElement.css({
          marginLeft: 0,
          marginTop: 0,
          marginRight: 0,
          marginBottom: 0
        });
        this.originalResizeStyle =
        this.originalElement.css("resize");
        this.originalElement.css("resize", "none");
        this._proportionallyResizeElements.push(this.originalElement.css({
          position: "static",
          zoom: 1,
          display: "block"
        }));
        this.originalElement.css({
          margin: this.originalElement.css("margin")
        });
        this._proportionallyResize()
      }
      this.handles = a.handles || (!d(".ui-resizable-handle", this.element).length ? "e,s,se" : {
        n: ".ui-resizable-n",
        e: ".ui-resizable-e",
        s: ".ui-resizable-s",
        w: ".ui-resizable-w",
        se: ".ui-resizable-se",
        sw: ".ui-resizable-sw",
        ne: ".ui-resizable-ne",
        nw: ".ui-resizable-nw"
      });
      if (this.handles.constructor == String) {
        if (this.handles == "all") this.handles = "n,e,s,w,se,sw,ne,nw";
        var c = this.handles.split(",");
        this.handles = {};
        for (var e = 0; e < c.length; e++) {
          var g = d.trim(c[e]),
          f = d('<div class="ui-resizable-handle ' + ("ui-resizable-" + g) + '"></div>');
          /sw|se|ne|nw/.test(g) && f.css({
            zIndex: ++a.zIndex
          });
          "se" == g && f.addClass("ui-icon ui-icon-gripsmall-diagonal-se");
          this.handles[g] = ".ui-resizable-" + g;
          this.element.append(f)
        }
      }
      this._renderAxis = function (h) {
        h = h || this.element;
        for (var i in this.handles) {
          if (this.handles[i].constructor == String) this.handles[i] = d(this.handles[i], this.element).show();
          if (this.elementIsWrapper && this.originalElement[0].nodeName.match(/textarea|input|select|button/i)) {
            var j = d(this.handles[i], this.element),
            l = 0;
            l = /sw|ne|nw|se|n|s/.test(i) ? j.outerHeight() : j.outerWidth();
            j = ["padding", /ne|nw|n/.test(i) ? "Top" : /se|sw|s/.test(i) ? "Bottom" : /^e$/.test(i) ? "Right" : "Left"].join("");
            h.css(j, l);
            this._proportionallyResize()
          }
          d(this.handles[i])
        }
      };
      this._renderAxis(this.element);
      this._handles = d(".ui-resizable-handle", this.element).disableSelection();
      this._handles.mouseover(function () {
        if (!b.resizing) {
          if (this.className) var h = this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i);
          b.axis = h && h[1] ? h[1] : "se"
        }
      });
      if (a.autoHide) {
        this._handles.hide();
        d(this.element).addClass("ui-resizable-autohide").hover(function () {
          d(this).removeClass("ui-resizable-autohide");
          b._handles.show()
        }, function () {
          if (!b.resizing) {
            d(this).addClass("ui-resizable-autohide");
            b._handles.hide()
          }
        })
      }
      this._mouseInit()
    },
    destroy: function () {
      this._mouseDestroy();
      var b = function (c) {
        d(c).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing").removeData("resizable").unbind(".resizable").find(".ui-resizable-handle").remove()
      };
      if (this.elementIsWrapper) {
        b(this.element);
        var a = this.element;
        a.after(this.originalElement.css({
          position: a.css("position"),
          width: a.outerWidth(),
          height: a.outerHeight(),
          top: a.css("top"),
          left: a.css("left")
        })).remove()
      }
      this.originalElement.css("resize", this.originalResizeStyle);
      b(this.originalElement);
      return this
    },
    _mouseCapture: function (b) {
      var a = false;
      for (var c in this.handles) if (d(this.handles[c])[0] == b.target) a = true;
      return !this.options.disabled && a
    },
    _mouseStart: function (b) {
      var a = this.options,
      c = this.element.position(),
      e = this.element;
      this.resizing = true;
      this.documentScroll = {
        top: d(document).scrollTop(),
        left: d(document).scrollLeft()
      };
      if (e.is(".ui-draggable") || /absolute/.test(e.css("position"))) e.css({
        position: "absolute",
        top: c.top,
        left: c.left
      });
      d.browser.opera && /relative/.test(e.css("position")) && e.css({
        position: "relative",
        top: "auto",
        left: "auto"
      });
      this._renderProxy();
      c = m(this.helper.css("left"));
      var g = m(this.helper.css("top"));
      if (a.containment) {
        c += d(a.containment).scrollLeft() || 0;
        g += d(a.containment).scrollTop() || 0
      }
      this.offset =
      this.helper.offset();
      this.position = {
        left: c,
        top: g
      };
      this.size = this._helper ? {
        width: e.outerWidth(),
        height: e.outerHeight()
      } : {
        width: e.width(),
        height: e.height()
      };
      this.originalSize = this._helper ? {
        width: e.outerWidth(),
        height: e.outerHeight()
      } : {
        width: e.width(),
        height: e.height()
      };
      this.originalPosition = {
        left: c,
        top: g
      };
      this.sizeDiff = {
        width: e.outerWidth() - e.width(),
        height: e.outerHeight() - e.height()
      };
      this.originalMousePosition = {
        left: b.pageX,
        top: b.pageY
      };
      this.aspectRatio = typeof a.aspectRatio == "number" ? a.aspectRatio : this.originalSize.width / this.originalSize.height || 1;
      a = d(".ui-resizable-" + this.axis).css("cursor");
      d("body").css("cursor", a == "auto" ? this.axis + "-resize" : a);
      e.addClass("ui-resizable-resizing");
      this._propagate("start", b);
      return true
    },
    _mouseDrag: function (b) {
      var a = this.helper,
      c = this.originalMousePosition,
      e = this._change[this.axis];
      if (!e) return false;
      c = e.apply(this, [b, b.pageX - c.left || 0, b.pageY - c.top || 0]);
      if (this._aspectRatio || b.shiftKey) c = this._updateRatio(c, b);
      c = this._respectSize(c, b);
      this._propagate("resize", b);
      a.css({
        top: this.position.top + "px",
        left: this.position.left + "px",
        width: this.size.width + "px",
        height: this.size.height + "px"
      });
      !this._helper && this._proportionallyResizeElements.length && this._proportionallyResize();
      this._updateCache(c);
      this._trigger("resize", b, this.ui());
      return false
    },
    _mouseStop: function (b) {
      this.resizing = false;
      var a = this.options,
      c = this;
      if (this._helper) {
        var e = this._proportionallyResizeElements,
        g = e.length && /textarea/i.test(e[0].nodeName);
        e = g && d.ui.hasScroll(e[0], "left") ? 0 : c.sizeDiff.height;
        g = {
          width: c.size.width - (g ? 0 : c.sizeDiff.width),
          height: c.size.height - e
        };
        e = parseInt(c.element.css("left"), 10) + (c.position.left - c.originalPosition.left) || null;
        var f = parseInt(c.element.css("top"), 10) + (c.position.top - c.originalPosition.top) || null;
        a.animate || this.element.css(d.extend(g, {
          top: f,
          left: e
        }));
        c.helper.height(c.size.height);
        c.helper.width(c.size.width);
        this._helper && !a.animate && this._proportionallyResize()
      }
      d("body").css("cursor", "auto");
      this.element.removeClass("ui-resizable-resizing");
      this._propagate("stop", b);
      this._helper && this.helper.remove();
      return false
    },
    _updateCache: function (b) {
      this.offset = this.helper.offset();
      if (k(b.left)) this.position.left = b.left;
      if (k(b.top)) this.position.top = b.top;
      if (k(b.height)) this.size.height = b.height;
      if (k(b.width)) this.size.width = b.width
    },
    _updateRatio: function (b) {
      var a = this.position,
      c = this.size,
      e = this.axis;
      if (b.height) b.width = c.height * this.aspectRatio;
      else if (b.width) b.height = c.width / this.aspectRatio;
      if (e == "sw") {
        b.left = a.left + (c.width - b.width);
        b.top = null
      }
      if (e == "nw") {
        b.top =
        a.top + (c.height - b.height);
        b.left = a.left + (c.width - b.width)
      }
      return b
    },
    _respectSize: function (b) {
      var a = this.options,
      c = this.axis,
      e = k(b.width) && a.maxWidth && a.maxWidth < b.width,
      g = k(b.height) && a.maxHeight && a.maxHeight < b.height,
      f = k(b.width) && a.minWidth && a.minWidth > b.width,
      h = k(b.height) && a.minHeight && a.minHeight > b.height;
      if (f) b.width = a.minWidth;
      if (h) b.height = a.minHeight;
      if (e) b.width = a.maxWidth;
      if (g) b.height = a.maxHeight;
      var i = this.originalPosition.left + this.originalSize.width,
      j = this.position.top + this.size.height,
      l = /sw|nw|w/.test(c);
      c = /nw|ne|n/.test(c);
      if (f && l) b.left = i - a.minWidth;
      if (e && l) b.left = i - a.maxWidth;
      if (h && c) b.top = j - a.minHeight;
      if (g && c) b.top = j - a.maxHeight;
      if ((a = !b.width && !b.height) && !b.left && b.top) b.top = null;
      else if (a && !b.top && b.left) b.left = null;
      return b
    },
    _proportionallyResize: function () {
      if (this._proportionallyResizeElements.length) for (var b = this.helper || this.element, a = 0; a < this._proportionallyResizeElements.length; a++) {
        var c = this._proportionallyResizeElements[a];
        if (!this.borderDif) {
          var e = [c.css("borderTopWidth"), c.css("borderRightWidth"), c.css("borderBottomWidth"), c.css("borderLeftWidth")],
          g = [c.css("paddingTop"), c.css("paddingRight"), c.css("paddingBottom"), c.css("paddingLeft")];
          this.borderDif = d.map(e, function (f, h) {
            f = parseInt(f, 10) || 0;
            h = parseInt(g[h], 10) || 0;
            return f + h
          })
        }
        d.browser.msie && (d(b).is(":hidden") || d(b).parents(":hidden").length) || c.css({
          height: b.height() - this.borderDif[0] - this.borderDif[2] || 0,
          width: b.width() - this.borderDif[1] - this.borderDif[3] || 0
        })
      }
    },
    _renderProxy: function () {
      var b = this.options;
      this.elementOffset =
      this.element.offset();
      if (this._helper) {
        this.helper = this.helper || d('<div style="overflow:hidden;"></div>');
        var a = d.browser.msie && d.browser.version < 7,
        c = a ? 1 : 0;
        a = a ? 2 : -1;
        this.helper.addClass(this._helper).css({
          width: this.element.outerWidth() + a,
          height: this.element.outerHeight() + a,
          position: "absolute",
          left: this.elementOffset.left - c + "px",
          top: this.elementOffset.top - c + "px",
          zIndex: ++b.zIndex
        });
        this.helper.appendTo("body").disableSelection()
      } else this.helper = this.element
    },
    _change: {
      e: function (b, a) {
        return {
          width: this.originalSize.width + a
        }
      },
      w: function (b, a) {
        return {
          left: this.originalPosition.left + a,
          width: this.originalSize.width - a
        }
      },
      n: function (b, a, c) {
        return {
          top: this.originalPosition.top + c,
          height: this.originalSize.height - c
        }
      },
      s: function (b, a, c) {
        return {
          height: this.originalSize.height + c
        }
      },
      se: function (b, a, c) {
        return d.extend(this._change.s.apply(this, arguments), this._change.e.apply(this, [b, a, c]))
      },
      sw: function (b, a, c) {
        return d.extend(this._change.s.apply(this, arguments), this._change.w.apply(this, [b, a, c]))
      },
      ne: function (b, a, c) {
        return d.extend(this._change.n.apply(this, arguments), this._change.e.apply(this, [b, a, c]))
      },
      nw: function (b, a, c) {
        return d.extend(this._change.n.apply(this, arguments), this._change.w.apply(this, [b, a, c]))
      }
    },
    _propagate: function (b, a) {
      d.ui.plugin.call(this, b, [a, this.ui()]);
      b != "resize" && this._trigger(b, a, this.ui())
    },
    plugins: {},
    ui: function () {
      return {
        originalElement: this.originalElement,
        element: this.element,
        helper: this.helper,
        position: this.position,
        size: this.size,
        originalSize: this.originalSize,
        originalPosition: this.originalPosition
      }
    }
  });
  d.extend(d.ui.resizable, {
    version: "1.8.1"
  });
  d.ui.plugin.add("resizable", "alsoResize", {
    start: function () {
      var b = d(this).data("resizable").options,
      a = function (c) {
        d(c).each(function () {
          d(this).data("resizable-alsoresize", {
            width: parseInt(d(this).width(), 10),
            height: parseInt(d(this).height(), 10),
            left: parseInt(d(this).css("left"), 10),
            top: parseInt(d(this).css("top"), 10)
          })
        })
      };
      if (typeof b.alsoResize == "object" && !b.alsoResize.parentNode) if (b.alsoResize.length) {
        b.alsoResize = b.alsoResize[0];
        a(b.alsoResize)
      } else d.each(b.alsoResize, function (c) {
        a(c)
      });
      else a(b.alsoResize)
    },
    resize: function () {
      var b = d(this).data("resizable"),
      a = b.options,
      c = b.originalSize,
      e = b.originalPosition,
      g = {
        height: b.size.height - c.height || 0,
        width: b.size.width - c.width || 0,
        top: b.position.top - e.top || 0,
        left: b.position.left - e.left || 0
      },
      f = function (h, i) {
        d(h).each(function () {
          var j = d(this),
          l = d(this).data("resizable-alsoresize"),
          p = {};
          d.each((i && i.length ? i : ["width", "height", "top", "left"]) || ["width", "height", "top", "left"], function (n, o) {
            if ((n = (l[o] || 0) + (g[o] || 0)) && n >= 0) p[o] = n || null
          });
          if (/relative/.test(j.css("position")) && d.browser.opera) {
            b._revertToRelativePosition = true;
            j.css({
              position: "absolute",
              top: "auto",
              left: "auto"
            })
          }
          j.css(p)
        })
      };
      typeof a.alsoResize == "object" && !a.alsoResize.nodeType ? d.each(a.alsoResize, function (h, i) {
        f(h, i)
      }) : f(a.alsoResize)
    },
    stop: function () {
      var b = d(this).data("resizable");
      if (b._revertToRelativePosition && d.browser.opera) {
        b._revertToRelativePosition = false;
        el.css({
          position: "relative"
        })
      }
      d(this).removeData("resizable-alsoresize-start")
    }
  });
  d.ui.plugin.add("resizable", "animate", {
    stop: function (b) {
      var a =
      d(this).data("resizable"),
      c = a.options,
      e = a._proportionallyResizeElements,
      g = e.length && /textarea/i.test(e[0].nodeName),
      f = g && d.ui.hasScroll(e[0], "left") ? 0 : a.sizeDiff.height;
      g = {
        width: a.size.width - (g ? 0 : a.sizeDiff.width),
        height: a.size.height - f
      };
      f = parseInt(a.element.css("left"), 10) + (a.position.left - a.originalPosition.left) || null;
      var h = parseInt(a.element.css("top"), 10) + (a.position.top - a.originalPosition.top) || null;
      a.element.animate(d.extend(g, h && f ? {
        top: h,
        left: f
      } : {}), {
        duration: c.animateDuration,
        easing: c.animateEasing,
        step: function () {
          var i = {
            width: parseInt(a.element.css("width"), 10),
            height: parseInt(a.element.css("height"), 10),
            top: parseInt(a.element.css("top"), 10),
            left: parseInt(a.element.css("left"), 10)
          };
          e && e.length && d(e[0]).css({
            width: i.width,
            height: i.height
          });
          a._updateCache(i);
          a._propagate("resize", b)
        }
      })
    }
  });
  d.ui.plugin.add("resizable", "containment", {
    start: function () {
      var b = d(this).data("resizable"),
      a = b.element,
      c = b.options.containment;
      if (a = c instanceof d ? c.get(0) : /parent/.test(c) ? a.parent().get(0) : c) {
        b.containerElement =
        d(a);
        if (/document/.test(c) || c == document) {
          b.containerOffset = {
            left: 0,
            top: 0
          };
          b.containerPosition = {
            left: 0,
            top: 0
          };
          b.parentData = {
            element: d(document),
            left: 0,
            top: 0,
            width: d(document).width(),
            height: d(document).height() || document.body.parentNode.scrollHeight
          }
        } else {
          var e = d(a),
          g = [];
          d(["Top", "Right", "Left", "Bottom"]).each(function (i, j) {
            g[i] = m(e.css("padding" + j))
          });
          b.containerOffset = e.offset();
          b.containerPosition = e.position();
          b.containerSize = {
            height: e.innerHeight() - g[3],
            width: e.innerWidth() - g[1]
          };
          c = b.containerOffset;
          var f = b.containerSize.height,
          h = b.containerSize.width;
          h = d.ui.hasScroll(a, "left") ? a.scrollWidth : h;
          f = d.ui.hasScroll(a) ? a.scrollHeight : f;
          b.parentData = {
            element: a,
            left: c.left,
            top: c.top,
            width: h,
            height: f
          }
        }
      }
    },
    resize: function (b) {
      var a = d(this).data("resizable"),
      c = a.options,
      e = a.containerOffset,
      g = a.position;
      b = a._aspectRatio || b.shiftKey;
      var f = {
        top: 0,
        left: 0
      },
      h = a.containerElement;
      if (h[0] != document && /static/.test(h.css("position"))) f = e;
      if (g.left < (a._helper ? e.left : 0)) {
        a.size.width += a._helper ? a.position.left - e.left : a.position.left - f.left;
        if (b) a.size.height = a.size.width / c.aspectRatio;
        a.position.left = c.helper ? e.left : 0
      }
      if (g.top < (a._helper ? e.top : 0)) {
        a.size.height += a._helper ? a.position.top - e.top : a.position.top;
        if (b) a.size.width = a.size.height * c.aspectRatio;
        a.position.top = a._helper ? e.top : 0
      }
      a.offset.left = a.parentData.left + a.position.left;
      a.offset.top = a.parentData.top + a.position.top;
      c = Math.abs((a._helper ? a.offset.left - f.left : a.offset.left - f.left) + a.sizeDiff.width);
      e = Math.abs((a._helper ? a.offset.top - f.top : a.offset.top - e.top) + a.sizeDiff.height);
      g = a.containerElement.get(0) == a.element.parent().get(0);
      f = /relative|absolute/.test(a.containerElement.css("position"));
      if (g && f) c -= a.parentData.left;
      if (c + a.size.width >= a.parentData.width) {
        a.size.width = a.parentData.width - c;
        if (b) a.size.height = a.size.width / a.aspectRatio
      }
      if (e + a.size.height >= a.parentData.height) {
        a.size.height = a.parentData.height - e;
        if (b) a.size.width = a.size.height * a.aspectRatio
      }
    },
    stop: function () {
      var b = d(this).data("resizable"),
      a = b.options,
      c = b.containerOffset,
      e = b.containerPosition,
      g = b.containerElement,
      f = d(b.helper),
      h = f.offset(),
      i = f.outerWidth() - b.sizeDiff.width;
      f = f.outerHeight() - b.sizeDiff.height;
      b._helper && !a.animate && /relative/.test(g.css("position")) && d(this).css({
        left: h.left - e.left - c.left,
        width: i,
        height: f
      });
      b._helper && !a.animate && /static/.test(g.css("position")) && d(this).css({
        left: h.left - e.left - c.left,
        width: i,
        height: f
      })
    }
  });
  d.ui.plugin.add("resizable", "ghost", {
    start: function () {
      var b = d(this).data("resizable"),
      a = b.options,
      c = b.size;
      b.ghost = b.originalElement.clone();
      b.ghost.css({
        opacity: 0.25,
        display: "block",
        position: "relative",
        height: c.height,
        width: c.width,
        margin: 0,
        left: 0,
        top: 0
      }).addClass("ui-resizable-ghost").addClass(typeof a.ghost == "string" ? a.ghost : "");
      b.ghost.appendTo(b.helper)
    },
    resize: function () {
      var b = d(this).data("resizable");
      b.ghost && b.ghost.css({
        position: "relative",
        height: b.size.height,
        width: b.size.width
      })
    },
    stop: function () {
      var b = d(this).data("resizable");
      b.ghost && b.helper && b.helper.get(0).removeChild(b.ghost.get(0))
    }
  });
  d.ui.plugin.add("resizable", "grid", {
    resize: function () {
      var b =
      d(this).data("resizable"),
      a = b.options,
      c = b.size,
      e = b.originalSize,
      g = b.originalPosition,
      f = b.axis;
      a.grid = typeof a.grid == "number" ? [a.grid, a.grid] : a.grid;
      var h = Math.round((c.width - e.width) / (a.grid[0] || 1)) * (a.grid[0] || 1);
      a = Math.round((c.height - e.height) / (a.grid[1] || 1)) * (a.grid[1] || 1);
      if (/^(se|s|e)$/.test(f)) {
        b.size.width = e.width + h;
        b.size.height = e.height + a
      } else if (/^(ne)$/.test(f)) {
        b.size.width = e.width + h;
        b.size.height = e.height + a;
        b.position.top = g.top - a
      } else {
        if (/^(sw)$/.test(f)) {
          b.size.width = e.width + h;
          b.size.height =
          e.height + a
        } else {
          b.size.width = e.width + h;
          b.size.height = e.height + a;
          b.position.top = g.top - a
        }
        b.position.left = g.left - h
      }
    }
  });
  var m = function (b) {
    return parseInt(b, 10) || 0
  },
  k = function (b) {
    return !isNaN(parseInt(b, 10))
  }
})(jQuery);
;
/*
 * jQuery UI Selectable 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Selectables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function (e) {
  e.widget("ui.selectable", e.ui.mouse, {
    options: {
      appendTo: "body",
      autoRefresh: true,
      distance: 0,
      filter: "*",
      tolerance: "touch"
    },
    _create: function () {
      var d = this;
      this.element.addClass("ui-selectable");
      this.dragged = false;
      var f;
      this.refresh = function () {
        f = e(d.options.filter, d.element[0]);
        f.each(function () {
          var c = e(this),
          b = c.offset();
          e.data(this, "selectable-item", {
            element: this,
            $element: c,
            left: b.left,
            top: b.top,
            right: b.left + c.outerWidth(),
            bottom: b.top + c.outerHeight(),
            startselected: false,
            selected: c.hasClass("ui-selected"),
            selecting: c.hasClass("ui-selecting"),
            unselecting: c.hasClass("ui-unselecting")
          })
        })
      };
      this.refresh();
      this.selectees = f.addClass("ui-selectee");
      this._mouseInit();
      this.helper = e(document.createElement("div")).css({
        border: "1px dotted black"
      }).addClass("ui-selectable-helper")
    },
    destroy: function () {
      this.selectees.removeClass("ui-selectee").removeData("selectable-item");
      this.element.removeClass("ui-selectable ui-selectable-disabled").removeData("selectable").unbind(".selectable");
      this._mouseDestroy();
      return this
    },
    _mouseStart: function (d) {
      var f = this;
      this.opos = [d.pageX, d.pageY];
      if (!this.options.disabled) {
        var c = this.options;
        this.selectees = e(c.filter, this.element[0]);
        this._trigger("start", d);
        e(c.appendTo).append(this.helper);
        this.helper.css({
          "z-index": 100,
          position: "absolute",
          left: d.clientX,
          top: d.clientY,
          width: 0,
          height: 0
        });
        c.autoRefresh && this.refresh();
        this.selectees.filter(".ui-selected").each(function () {
          var b = e.data(this, "selectable-item");
          b.startselected = true;
          if (!d.metaKey) {
            b.$element.removeClass("ui-selected");
            b.selected = false;
            b.$element.addClass("ui-unselecting");
            b.unselecting = true;
            f._trigger("unselecting", d, {
              unselecting: b.element
            })
          }
        });
        e(d.target).parents().andSelf().each(function () {
          var b = e.data(this, "selectable-item");
          if (b) {
            b.$element.removeClass("ui-unselecting").addClass("ui-selecting");
            b.unselecting = false;
            b.selecting = true;
            b.selected = true;
            f._trigger("selecting", d, {
              selecting: b.element
            });
            return false
          }
        })
      }
    },
    _mouseDrag: function (d) {
      var f = this;
      this.dragged = true;
      if (!this.options.disabled) {
        var c = this.options,
        b = this.opos[0],
        g = this.opos[1],
        h = d.pageX,
        i = d.pageY;
        if (b > h) {
          var j = h;
          h = b;
          b = j
        }
        if (g > i) {
          j = i;
          i = g;
          g = j
        }
        this.helper.css({
          left: b,
          top: g,
          width: h - b,
          height: i - g
        });
        this.selectees.each(function () {
          var a = e.data(this, "selectable-item");
          if (!(!a || a.element == f.element[0])) {
            var k = false;
            if (c.tolerance == "touch") k = !(a.left > h || a.right < b || a.top > i || a.bottom < g);
            else if (c.tolerance == "fit") k = a.left > b && a.right < h && a.top > g && a.bottom < i;
            if (k) {
              if (a.selected) {
                a.$element.removeClass("ui-selected");
                a.selected = false
              }
              if (a.unselecting) {
                a.$element.removeClass("ui-unselecting");
                a.unselecting = false
              }
              if (!a.selecting) {
                a.$element.addClass("ui-selecting");
                a.selecting = true;
                f._trigger("selecting", d, {
                  selecting: a.element
                })
              }
            } else {
              if (a.selecting) if (d.metaKey && a.startselected) {
                a.$element.removeClass("ui-selecting");
                a.selecting = false;
                a.$element.addClass("ui-selected");
                a.selected = true
              } else {
                a.$element.removeClass("ui-selecting");
                a.selecting = false;
                if (a.startselected) {
                  a.$element.addClass("ui-unselecting");
                  a.unselecting = true
                }
                f._trigger("unselecting", d, {
                  unselecting: a.element
                })
              }
              if (a.selected) if (!d.metaKey && !a.startselected) {
                a.$element.removeClass("ui-selected");
                a.selected = false;
                a.$element.addClass("ui-unselecting");
                a.unselecting = true;
                f._trigger("unselecting", d, {
                  unselecting: a.element
                })
              }
            }
          }
        });
        return false
      }
    },
    _mouseStop: function (d) {
      var f = this;
      this.dragged = false;
      e(".ui-unselecting", this.element[0]).each(function () {
        var c = e.data(this, "selectable-item");
        c.$element.removeClass("ui-unselecting");
        c.unselecting = false;
        c.startselected = false;
        f._trigger("unselected", d, {
          unselected: c.element
        })
      });
      e(".ui-selecting", this.element[0]).each(function () {
        var c =
        e.data(this, "selectable-item");
        c.$element.removeClass("ui-selecting").addClass("ui-selected");
        c.selecting = false;
        c.selected = true;
        c.startselected = true;
        f._trigger("selected", d, {
          selected: c.element
        })
      });
      this._trigger("stop", d);
      this.helper.remove();
      return false
    }
  });
  e.extend(e.ui.selectable, {
    version: "1.8.1"
  })
})(jQuery);
;
/*
 * jQuery UI Sortable 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Sortables
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.mouse.js
 *	jquery.ui.widget.js
 */
(function (d) {
  d.widget("ui.sortable", d.ui.mouse, {
    widgetEventPrefix: "sort",
    options: {
      appendTo: "parent",
      axis: false,
      connectWith: false,
      containment: false,
      cursor: "auto",
      cursorAt: false,
      dropOnEmpty: true,
      forcePlaceholderSize: false,
      forceHelperSize: false,
      grid: false,
      handle: false,
      helper: "original",
      items: "> *",
      opacity: false,
      placeholder: false,
      revert: false,
      scroll: true,
      scrollSensitivity: 20,
      scrollSpeed: 20,
      scope: "default",
      tolerance: "intersect",
      zIndex: 1E3
    },
    _create: function () {
      this.containerCache = {};
      this.element.addClass("ui-sortable");
      this.refresh();
      this.floating = this.items.length ? /left|right/.test(this.items[0].item.css("float")) : false;
      this.offset = this.element.offset();
      this._mouseInit()
    },
    destroy: function () {
      this.element.removeClass("ui-sortable ui-sortable-disabled").removeData("sortable").unbind(".sortable");
      this._mouseDestroy();
      for (var a = this.items.length - 1; a >= 0; a--) this.items[a].item.removeData("sortable-item");
      return this
    },
    _setOption: function (a, b) {
      if (a === "disabled") {
        this.options[a] = b;
        this.widget()[b ? "addClass" : "removeClass"]("ui-sortable-disabled")
      } else d.Widget.prototype._setOption.apply(self, arguments)
    },
    _mouseCapture: function (a, b) {
      if (this.reverting) return false;
      if (this.options.disabled || this.options.type == "static") return false;
      this._refreshItems(a);
      var c = null,
      e = this;
      d(a.target).parents().each(function () {
        if (d.data(this, "sortable-item") == e) {
          c = d(this);
          return false
        }
      });
      if (d.data(a.target, "sortable-item") == e) c = d(a.target);
      if (!c) return false;
      if (this.options.handle && !b) {
        var f = false;
        d(this.options.handle, c).find("*").andSelf().each(function () {
          if (this == a.target) f = true
        });
        if (!f) return false
      }
      this.currentItem =
      c;
      this._removeCurrentsFromItems();
      return true
    },
    _mouseStart: function (a, b, c) {
      b = this.options;
      var e = this;
      this.currentContainer = this;
      this.refreshPositions();
      this.helper = this._createHelper(a);
      this._cacheHelperProportions();
      this._cacheMargins();
      this.scrollParent = this.helper.scrollParent();
      this.offset = this.currentItem.offset();
      this.offset = {
        top: this.offset.top - this.margins.top,
        left: this.offset.left - this.margins.left
      };
      this.helper.css("position", "absolute");
      this.cssPosition = this.helper.css("position");
      d.extend(this.offset, {
        click: {
          left: a.pageX - this.offset.left,
          top: a.pageY - this.offset.top
        },
        parent: this._getParentOffset(),
        relative: this._getRelativeOffset()
      });
      this.originalPosition = this._generatePosition(a);
      this.originalPageX = a.pageX;
      this.originalPageY = a.pageY;
      b.cursorAt && this._adjustOffsetFromHelper(b.cursorAt);
      this.domPosition = {
        prev: this.currentItem.prev()[0],
        parent: this.currentItem.parent()[0]
      };
      this.helper[0] != this.currentItem[0] && this.currentItem.hide();
      this._createPlaceholder();
      b.containment && this._setContainment();
      if (b.cursor) {
        if (d("body").css("cursor")) this._storedCursor = d("body").css("cursor");
        d("body").css("cursor", b.cursor)
      }
      if (b.opacity) {
        if (this.helper.css("opacity")) this._storedOpacity = this.helper.css("opacity");
        this.helper.css("opacity", b.opacity)
      }
      if (b.zIndex) {
        if (this.helper.css("zIndex")) this._storedZIndex = this.helper.css("zIndex");
        this.helper.css("zIndex", b.zIndex)
      }
      if (this.scrollParent[0] != document && this.scrollParent[0].tagName != "HTML") this.overflowOffset = this.scrollParent.offset();
      this._trigger("start", a, this._uiHash());
      this._preserveHelperProportions || this._cacheHelperProportions();
      if (!c) for (c = this.containers.length - 1; c >= 0; c--) this.containers[c]._trigger("activate", a, e._uiHash(this));
      if (d.ui.ddmanager) d.ui.ddmanager.current = this;
      d.ui.ddmanager && !b.dropBehaviour && d.ui.ddmanager.prepareOffsets(this, a);
      this.dragging = true;
      this.helper.addClass("ui-sortable-helper");
      this._mouseDrag(a);
      return true
    },
    _mouseDrag: function (a) {
      this.position = this._generatePosition(a);
      this.positionAbs = this._convertPositionTo("absolute");
      if (!this.lastPositionAbs) this.lastPositionAbs = this.positionAbs;
      if (this.options.scroll) {
        var b = this.options,
        c = false;
        if (this.scrollParent[0] != document && this.scrollParent[0].tagName != "HTML") {
          if (this.overflowOffset.top + this.scrollParent[0].offsetHeight - a.pageY < b.scrollSensitivity) this.scrollParent[0].scrollTop = c = this.scrollParent[0].scrollTop + b.scrollSpeed;
          else if (a.pageY - this.overflowOffset.top < b.scrollSensitivity) this.scrollParent[0].scrollTop = c = this.scrollParent[0].scrollTop - b.scrollSpeed;
          if (this.overflowOffset.left + this.scrollParent[0].offsetWidth - a.pageX < b.scrollSensitivity) this.scrollParent[0].scrollLeft = c = this.scrollParent[0].scrollLeft + b.scrollSpeed;
          else if (a.pageX - this.overflowOffset.left < b.scrollSensitivity) this.scrollParent[0].scrollLeft = c = this.scrollParent[0].scrollLeft - b.scrollSpeed
        } else {
          if (a.pageY - d(document).scrollTop() < b.scrollSensitivity) c = d(document).scrollTop(d(document).scrollTop() - b.scrollSpeed);
          else if (d(window).height() - (a.pageY - d(document).scrollTop()) < b.scrollSensitivity) c = d(document).scrollTop(d(document).scrollTop() + b.scrollSpeed);
          if (a.pageX - d(document).scrollLeft() < b.scrollSensitivity) c = d(document).scrollLeft(d(document).scrollLeft() - b.scrollSpeed);
          else if (d(window).width() - (a.pageX - d(document).scrollLeft()) < b.scrollSensitivity) c = d(document).scrollLeft(d(document).scrollLeft() + b.scrollSpeed)
        }
        c !== false && d.ui.ddmanager && !b.dropBehaviour && d.ui.ddmanager.prepareOffsets(this, a)
      }
      this.positionAbs = this._convertPositionTo("absolute");
      if (!this.options.axis || this.options.axis != "y") this.helper[0].style.left = this.position.left + "px";
      if (!this.options.axis || this.options.axis != "x") this.helper[0].style.top = this.position.top + "px";
      for (b = this.items.length - 1; b >= 0; b--) {
        c = this.items[b];
        var e = c.item[0],
        f = this._intersectsWithPointer(c);
        if (f) if (e != this.currentItem[0] && this.placeholder[f == 1 ? "next" : "prev"]()[0] != e && !d.ui.contains(this.placeholder[0], e) && (this.options.type == "semi-dynamic" ? !d.ui.contains(this.element[0], e) : true)) {
          this.direction = f == 1 ? "down" : "up";
          if (this.options.tolerance == "pointer" || this._intersectsWithSides(c)) this._rearrange(a, c);
          else break;
          this._trigger("change", a, this._uiHash());
          break
        }
      }
      this._contactContainers(a);
      d.ui.ddmanager && d.ui.ddmanager.drag(this, a);
      this._trigger("sort", a, this._uiHash());
      this.lastPositionAbs = this.positionAbs;
      return false
    },
    _mouseStop: function (a, b) {
      if (a) {
        d.ui.ddmanager && !this.options.dropBehaviour && d.ui.ddmanager.drop(this, a);
        if (this.options.revert) {
          var c = this;
          b = c.placeholder.offset();
          c.reverting = true;
          d(this.helper).animate({
            left: b.left - this.offset.parent.left - c.margins.left + (this.offsetParent[0] == document.body ? 0 : this.offsetParent[0].scrollLeft),
            top: b.top - this.offset.parent.top - c.margins.top + (this.offsetParent[0] == document.body ? 0 : this.offsetParent[0].scrollTop)
          }, parseInt(this.options.revert, 10) || 500, function () {
            c._clear(a)
          })
        } else this._clear(a, b);
        return false
      }
    },
    cancel: function () {
      var a = this;
      if (this.dragging) {
        this._mouseUp();
        this.options.helper == "original" ? this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper") : this.currentItem.show();
        for (var b = this.containers.length - 1; b >= 0; b--) {
          this.containers[b]._trigger("deactivate", null, a._uiHash(this));
          if (this.containers[b].containerCache.over) {
            this.containers[b]._trigger("out", null, a._uiHash(this));
            this.containers[b].containerCache.over = 0
          }
        }
      }
      this.placeholder[0].parentNode && this.placeholder[0].parentNode.removeChild(this.placeholder[0]);
      this.options.helper != "original" && this.helper && this.helper[0].parentNode && this.helper.remove();
      d.extend(this, {
        helper: null,
        dragging: false,
        reverting: false,
        _noFinalSort: null
      });
      this.domPosition.prev ? d(this.domPosition.prev).after(this.currentItem) : d(this.domPosition.parent).prepend(this.currentItem);
      return this
    },
    serialize: function (a) {
      var b = this._getItemsAsjQuery(a && a.connected),
      c = [];
      a = a || {};
      d(b).each(function () {
        var e = (d(a.item || this).attr(a.attribute || "id") || "").match(a.expression || /(.+)[-=_](.+)/);
        if (e) c.push((a.key || e[1] + "[]") + "=" + (a.key && a.expression ? e[1] : e[2]))
      });
      return c.join("&")
    },
    toArray: function (a) {
      var b = this._getItemsAsjQuery(a && a.connected),
      c = [];
      a = a || {};
      b.each(function () {
        c.push(d(a.item || this).attr(a.attribute || "id") || "")
      });
      return c
    },
    _intersectsWith: function (a) {
      var b = this.positionAbs.left,
      c = b + this.helperProportions.width,
      e = this.positionAbs.top,
      f = e + this.helperProportions.height,
      g = a.left,
      h = g + a.width,
      i = a.top,
      k = i + a.height,
      j = this.offset.click.top,
      l = this.offset.click.left;
      j = e + j > i && e + j < k && b + l > g && b + l < h;
      return this.options.tolerance == "pointer" || this.options.forcePointerForContainers || this.options.tolerance != "pointer" && this.helperProportions[this.floating ? "width" : "height"] > a[this.floating ? "width" : "height"] ? j : g < b + this.helperProportions.width / 2 && c - this.helperProportions.width / 2 < h && i < e + this.helperProportions.height / 2 && f - this.helperProportions.height / 2 < k
    },
    _intersectsWithPointer: function (a) {
      var b = d.ui.isOverAxis(this.positionAbs.top + this.offset.click.top, a.top, a.height);
      a = d.ui.isOverAxis(this.positionAbs.left + this.offset.click.left, a.left, a.width);
      b = b && a;
      a = this._getDragVerticalDirection();
      var c = this._getDragHorizontalDirection();
      if (!b) return false;
      return this.floating ? c && c == "right" || a == "down" ? 2 : 1 : a && (a == "down" ? 2 : 1)
    },
    _intersectsWithSides: function (a) {
      var b =
      d.ui.isOverAxis(this.positionAbs.top + this.offset.click.top, a.top + a.height / 2, a.height);
      a = d.ui.isOverAxis(this.positionAbs.left + this.offset.click.left, a.left + a.width / 2, a.width);
      var c = this._getDragVerticalDirection(),
      e = this._getDragHorizontalDirection();
      return this.floating && e ? e == "right" && a || e == "left" && !a : c && (c == "down" && b || c == "up" && !b)
    },
    _getDragVerticalDirection: function () {
      var a = this.positionAbs.top - this.lastPositionAbs.top;
      return a != 0 && (a > 0 ? "down" : "up")
    },
    _getDragHorizontalDirection: function () {
      var a =
      this.positionAbs.left - this.lastPositionAbs.left;
      return a != 0 && (a > 0 ? "right" : "left")
    },
    refresh: function (a) {
      this._refreshItems(a);
      this.refreshPositions();
      return this
    },
    _connectWith: function () {
      var a = this.options;
      return a.connectWith.constructor == String ? [a.connectWith] : a.connectWith
    },
    _getItemsAsjQuery: function (a) {
      var b = [],
      c = [],
      e = this._connectWith();
      if (e && a) for (a = e.length - 1; a >= 0; a--) for (var f = d(e[a]), g = f.length - 1; g >= 0; g--) {
        var h = d.data(f[g], "sortable");
        if (h && h != this && !h.options.disabled) c.push([d.isFunction(h.options.items) ? h.options.items.call(h.element) : d(h.options.items, h.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), h])
      }
      c.push([d.isFunction(this.options.items) ? this.options.items.call(this.element, null, {
        options: this.options,
        item: this.currentItem
      }) : d(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]);
      for (a = c.length - 1; a >= 0; a--) c[a][0].each(function () {
        b.push(this)
      });
      return d(b)
    },
    _removeCurrentsFromItems: function () {
      for (var a = this.currentItem.find(":data(sortable-item)"), b = 0; b < this.items.length; b++) for (var c = 0; c < a.length; c++) a[c] == this.items[b].item[0] && this.items.splice(b, 1)
    },
    _refreshItems: function (a) {
      this.items = [];
      this.containers = [this];
      var b = this.items,
      c = [
      [d.isFunction(this.options.items) ? this.options.items.call(this.element[0], a, {
        item: this.currentItem
      }) : d(this.options.items, this.element), this]
      ],
      e = this._connectWith();
      if (e) for (var f = e.length - 1; f >= 0; f--) for (var g = d(e[f]), h = g.length - 1; h >= 0; h--) {
        var i = d.data(g[h], "sortable");
        if (i && i != this && !i.options.disabled) {
          c.push([d.isFunction(i.options.items) ? i.options.items.call(i.element[0], a, {
            item: this.currentItem
          }) : d(i.options.items, i.element), i]);
          this.containers.push(i)
        }
      }
      for (f = c.length - 1; f >= 0; f--) {
        a = c[f][1];
        e = c[f][0];
        h = 0;
        for (g = e.length; h < g; h++) {
          i = d(e[h]);
          i.data("sortable-item", a);
          b.push({
            item: i,
            instance: a,
            width: 0,
            height: 0,
            left: 0,
            top: 0
          })
        }
      }
    },
    refreshPositions: function (a) {
      if (this.offsetParent && this.helper) this.offset.parent = this._getParentOffset();
      for (var b = this.items.length - 1; b >= 0; b--) {
        var c = this.items[b],
        e = this.options.toleranceElement ? d(this.options.toleranceElement, c.item) : c.item;
        if (!a) {
          c.width = e.outerWidth();
          c.height = e.outerHeight()
        }
        e = e.offset();
        c.left = e.left;
        c.top = e.top
      }
      if (this.options.custom && this.options.custom.refreshContainers) this.options.custom.refreshContainers.call(this);
      else for (b = this.containers.length - 1; b >= 0; b--) {
        e = this.containers[b].element.offset();
        this.containers[b].containerCache.left = e.left;
        this.containers[b].containerCache.top = e.top;
        this.containers[b].containerCache.width = this.containers[b].element.outerWidth();
        this.containers[b].containerCache.height =
        this.containers[b].element.outerHeight()
      }
      return this
    },
    _createPlaceholder: function (a) {
      var b = a || this,
      c = b.options;
      if (!c.placeholder || c.placeholder.constructor == String) {
        var e = c.placeholder;
        c.placeholder = {
          element: function () {
            var f = d(document.createElement(b.currentItem[0].nodeName)).addClass(e || b.currentItem[0].className + " ui-sortable-placeholder").removeClass("ui-sortable-helper")[0];
            if (!e) f.style.visibility = "hidden";
            return f
          },
          update: function (f, g) {
            if (!(e && !c.forcePlaceholderSize)) {
              g.height() || g.height(b.currentItem.innerHeight() - parseInt(b.currentItem.css("paddingTop") || 0, 10) - parseInt(b.currentItem.css("paddingBottom") || 0, 10));
              g.width() || g.width(b.currentItem.innerWidth() - parseInt(b.currentItem.css("paddingLeft") || 0, 10) - parseInt(b.currentItem.css("paddingRight") || 0, 10))
            }
          }
        }
      }
      b.placeholder = d(c.placeholder.element.call(b.element, b.currentItem));
      b.currentItem.after(b.placeholder);
      c.placeholder.update(b, b.placeholder)
    },
    _contactContainers: function (a) {
      for (var b = null, c = null, e = this.containers.length - 1; e >= 0; e--) if (!d.ui.contains(this.currentItem[0], this.containers[e].element[0])) if (this._intersectsWith(this.containers[e].containerCache)) {
        if (!(b && d.ui.contains(this.containers[e].element[0], b.element[0]))) {
          b = this.containers[e];
          c = e
        }
      } else if (this.containers[e].containerCache.over) {
        this.containers[e]._trigger("out", a, this._uiHash(this));
        this.containers[e].containerCache.over = 0
      }
      if (b) if (this.containers.length === 1) {
        this.containers[c]._trigger("over", a, this._uiHash(this));
        this.containers[c].containerCache.over = 1
      } else if (this.currentContainer != this.containers[c]) {
        b =
        1E4;
        e = null;
        for (var f = this.positionAbs[this.containers[c].floating ? "left" : "top"], g = this.items.length - 1; g >= 0; g--) if (d.ui.contains(this.containers[c].element[0], this.items[g].item[0])) {
          var h = this.items[g][this.containers[c].floating ? "left" : "top"];
          if (Math.abs(h - f) < b) {
            b = Math.abs(h - f);
            e = this.items[g]
          }
        }
        if (e || this.options.dropOnEmpty) {
          this.currentContainer = this.containers[c];
          e ? this._rearrange(a, e, null, true) : this._rearrange(a, null, this.containers[c].element, true);
          this._trigger("change", a, this._uiHash());
          this.containers[c]._trigger("change", a, this._uiHash(this));
          this.options.placeholder.update(this.currentContainer, this.placeholder);
          this.containers[c]._trigger("over", a, this._uiHash(this));
          this.containers[c].containerCache.over = 1
        }
      }
    },
    _createHelper: function (a) {
      var b = this.options;
      a = d.isFunction(b.helper) ? d(b.helper.apply(this.element[0], [a, this.currentItem])) : b.helper == "clone" ? this.currentItem.clone() : this.currentItem;
      a.parents("body").length || d(b.appendTo != "parent" ? b.appendTo : this.currentItem[0].parentNode)[0].appendChild(a[0]);
      if (a[0] == this.currentItem[0]) this._storedCSS = {
        width: this.currentItem[0].style.width,
        height: this.currentItem[0].style.height,
        position: this.currentItem.css("position"),
        top: this.currentItem.css("top"),
        left: this.currentItem.css("left")
      };
      if (a[0].style.width == "" || b.forceHelperSize) a.width(this.currentItem.width());
      if (a[0].style.height == "" || b.forceHelperSize) a.height(this.currentItem.height());
      return a
    },
    _adjustOffsetFromHelper: function (a) {
      if (typeof a == "string") a = a.split(" ");
      if (d.isArray(a)) a = {
        left: +a[0],
        top: +a[1] || 0
      };
      if ("left" in a) this.offset.click.left = a.left + this.margins.left;
      if ("right" in a) this.offset.click.left = this.helperProportions.width - a.right + this.margins.left;
      if ("top" in a) this.offset.click.top = a.top + this.margins.top;
      if ("bottom" in a) this.offset.click.top = this.helperProportions.height - a.bottom + this.margins.top
    },
    _getParentOffset: function () {
      this.offsetParent = this.helper.offsetParent();
      var a = this.offsetParent.offset();
      if (this.cssPosition == "absolute" && this.scrollParent[0] != document && d.ui.contains(this.scrollParent[0], this.offsetParent[0])) {
        a.left += this.scrollParent.scrollLeft();
        a.top += this.scrollParent.scrollTop()
      }
      if (this.offsetParent[0] == document.body || this.offsetParent[0].tagName && this.offsetParent[0].tagName.toLowerCase() == "html" && d.browser.msie) a = {
        top: 0,
        left: 0
      };
      return {
        top: a.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
        left: a.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
      }
    },
    _getRelativeOffset: function () {
      if (this.cssPosition == "relative") {
        var a = this.currentItem.position();
        return {
          top: a.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
          left: a.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
        }
      } else return {
        top: 0,
        left: 0
      }
    },
    _cacheMargins: function () {
      this.margins = {
        left: parseInt(this.currentItem.css("marginLeft"), 10) || 0,
        top: parseInt(this.currentItem.css("marginTop"), 10) || 0
      }
    },
    _cacheHelperProportions: function () {
      this.helperProportions = {
        width: this.helper.outerWidth(),
        height: this.helper.outerHeight()
      }
    },
    _setContainment: function () {
      var a = this.options;
      if (a.containment == "parent") a.containment = this.helper[0].parentNode;
      if (a.containment == "document" || a.containment == "window") this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, d(a.containment == "document" ? document : window).width() - this.helperProportions.width - this.margins.left, (d(a.containment == "document" ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top];
      if (!/^(document|window|parent)$/.test(a.containment)) {
        var b =
        d(a.containment)[0];
        a = d(a.containment).offset();
        var c = d(b).css("overflow") != "hidden";
        this.containment = [a.left + (parseInt(d(b).css("borderLeftWidth"), 10) || 0) + (parseInt(d(b).css("paddingLeft"), 10) || 0) - this.margins.left, a.top + (parseInt(d(b).css("borderTopWidth"), 10) || 0) + (parseInt(d(b).css("paddingTop"), 10) || 0) - this.margins.top, a.left + (c ? Math.max(b.scrollWidth, b.offsetWidth) : b.offsetWidth) - (parseInt(d(b).css("borderLeftWidth"), 10) || 0) - (parseInt(d(b).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, a.top + (c ? Math.max(b.scrollHeight, b.offsetHeight) : b.offsetHeight) - (parseInt(d(b).css("borderTopWidth"), 10) || 0) - (parseInt(d(b).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top]
      }
    },
    _convertPositionTo: function (a, b) {
      if (!b) b = this.position;
      a = a == "absolute" ? 1 : -1;
      var c = this.cssPosition == "absolute" && !(this.scrollParent[0] != document && d.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent,
      e = /(html|body)/i.test(c[0].tagName);
      return {
        top: b.top + this.offset.relative.top * a + this.offset.parent.top * a - (d.browser.safari && this.cssPosition == "fixed" ? 0 : (this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : e ? 0 : c.scrollTop()) * a),
        left: b.left + this.offset.relative.left * a + this.offset.parent.left * a - (d.browser.safari && this.cssPosition == "fixed" ? 0 : (this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : e ? 0 : c.scrollLeft()) * a)
      }
    },
    _generatePosition: function (a) {
      var b = this.options,
      c = this.cssPosition == "absolute" && !(this.scrollParent[0] != document && d.ui.contains(this.scrollParent[0], this.offsetParent[0])) ? this.offsetParent : this.scrollParent,
      e = /(html|body)/i.test(c[0].tagName);
      if (this.cssPosition == "relative" && !(this.scrollParent[0] != document && this.scrollParent[0] != this.offsetParent[0])) this.offset.relative = this._getRelativeOffset();
      var f = a.pageX,
      g = a.pageY;
      if (this.originalPosition) {
        if (this.containment) {
          if (a.pageX - this.offset.click.left < this.containment[0]) f = this.containment[0] + this.offset.click.left;
          if (a.pageY - this.offset.click.top < this.containment[1]) g = this.containment[1] + this.offset.click.top;
          if (a.pageX - this.offset.click.left > this.containment[2]) f = this.containment[2] + this.offset.click.left;
          if (a.pageY - this.offset.click.top > this.containment[3]) g = this.containment[3] + this.offset.click.top
        }
        if (b.grid) {
          g = this.originalPageY + Math.round((g - this.originalPageY) / b.grid[1]) * b.grid[1];
          g = this.containment ? !(g - this.offset.click.top < this.containment[1] || g - this.offset.click.top > this.containment[3]) ? g : !(g - this.offset.click.top < this.containment[1]) ? g - b.grid[1] : g + b.grid[1] : g;
          f = this.originalPageX + Math.round((f - this.originalPageX) / b.grid[0]) * b.grid[0];
          f = this.containment ? !(f - this.offset.click.left < this.containment[0] || f - this.offset.click.left > this.containment[2]) ? f : !(f - this.offset.click.left < this.containment[0]) ? f - b.grid[0] : f + b.grid[0] : f
        }
      }
      return {
        top: g - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + (d.browser.safari && this.cssPosition == "fixed" ? 0 : this.cssPosition == "fixed" ? -this.scrollParent.scrollTop() : e ? 0 : c.scrollTop()),
        left: f - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + (d.browser.safari && this.cssPosition == "fixed" ? 0 : this.cssPosition == "fixed" ? -this.scrollParent.scrollLeft() : e ? 0 : c.scrollLeft())
      }
    },
    _rearrange: function (a, b, c, e) {
      c ? c[0].appendChild(this.placeholder[0]) : b.item[0].parentNode.insertBefore(this.placeholder[0], this.direction == "down" ? b.item[0] : b.item[0].nextSibling);
      this.counter = this.counter ? ++this.counter : 1;
      var f = this,
      g = this.counter;
      window.setTimeout(function () {
        g == f.counter && f.refreshPositions(!e)
      }, 0)
    },
    _clear: function (a, b) {
      this.reverting = false;
      var c = [];
      !this._noFinalSort && this.currentItem[0].parentNode && this.placeholder.before(this.currentItem);
      this._noFinalSort = null;
      if (this.helper[0] == this.currentItem[0]) {
        for (var e in this._storedCSS) if (this._storedCSS[e] == "auto" || this._storedCSS[e] == "static") this._storedCSS[e] = "";
        this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")
      } else this.currentItem.show();
      this.fromOutside && !b && c.push(function (f) {
        this._trigger("receive", f, this._uiHash(this.fromOutside))
      });
      if ((this.fromOutside || this.domPosition.prev != this.currentItem.prev().not(".ui-sortable-helper")[0] || this.domPosition.parent != this.currentItem.parent()[0]) && !b) c.push(function (f) {
        this._trigger("update", f, this._uiHash())
      });
      if (!d.ui.contains(this.element[0], this.currentItem[0])) {
        b || c.push(function (f) {
          this._trigger("remove", f, this._uiHash())
        });
        for (e = this.containers.length - 1; e >= 0; e--) if (d.ui.contains(this.containers[e].element[0], this.currentItem[0]) && !b) {
          c.push(function (f) {
            return function (g) {
              f._trigger("receive", g, this._uiHash(this))
            }
          }.call(this, this.containers[e]));
          c.push(function (f) {
            return function (g) {
              f._trigger("update", g, this._uiHash(this))
            }
          }.call(this, this.containers[e]))
        }
      }
      for (e = this.containers.length - 1; e >= 0; e--) {
        b || c.push(function (f) {
          return function (g) {
            f._trigger("deactivate", g, this._uiHash(this))
          }
        }.call(this, this.containers[e]));
        if (this.containers[e].containerCache.over) {
          c.push(function (f) {
            return function (g) {
              f._trigger("out", g, this._uiHash(this))
            }
          }.call(this, this.containers[e]));
          this.containers[e].containerCache.over = 0
        }
      }
      this._storedCursor && d("body").css("cursor", this._storedCursor);
      this._storedOpacity && this.helper.css("opacity", this._storedOpacity);
      if (this._storedZIndex) this.helper.css("zIndex", this._storedZIndex == "auto" ? "" : this._storedZIndex);
      this.dragging = false;
      if (this.cancelHelperRemoval) {
        if (!b) {
          this._trigger("beforeStop", a, this._uiHash());
          for (e = 0; e < c.length; e++) c[e].call(this, a);
          this._trigger("stop", a, this._uiHash())
        }
        return false
      }
      b || this._trigger("beforeStop", a, this._uiHash());
      this.placeholder[0].parentNode.removeChild(this.placeholder[0]);
      this.helper[0] != this.currentItem[0] && this.helper.remove();
      this.helper = null;
      if (!b) {
        for (e =
          0; e < c.length; e++) c[e].call(this, a);
        this._trigger("stop", a, this._uiHash())
      }
      this.fromOutside = false;
      return true
    },
    _trigger: function () {
      d.Widget.prototype._trigger.apply(this, arguments) === false && this.cancel()
    },
    _uiHash: function (a) {
      var b = a || this;
      return {
        helper: b.helper,
        placeholder: b.placeholder || d([]),
        position: b.position,
        originalPosition: b.originalPosition,
        offset: b.positionAbs,
        item: b.currentItem,
        sender: a ? a.element : null
      }
    }
  });
  d.extend(d.ui.sortable, {
    version: "1.8.1"
  })
})(jQuery);
;

/*
 * jQuery UI Button 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Button
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 */
(function (a) {
  var g, i = function (b) {
    a(":ui-button", b.target.form).each(function () {
      var c = a(this).data("button");
      setTimeout(function () {
        c.refresh()
      }, 1)
    })
  },
  h = function (b) {
    var c = b.name,
    d = b.form,
    e = a([]);
    if (c) e = d ? a(d).find("[name='" + c + "']") : a("[name='" + c + "']", b.ownerDocument).filter(function () {
      return !this.form
    });
    return e
  };
  a.widget("ui.button", {
    options: {
      text: true,
      label: null,
      icons: {
        primary: null,
        secondary: null
      }
    },
    _create: function () {
      this.element.closest("form").unbind("reset.button").bind("reset.button", i);
      this._determineButtonType();
      this.hasTitle = !! this.buttonElement.attr("title");
      var b = this,
      c = this.options,
      d = this.type === "checkbox" || this.type === "radio",
      e = "ui-state-hover" + (!d ? " ui-state-active" : "");
      if (c.label === null) c.label = this.buttonElement.html();
      if (this.element.is(":disabled")) c.disabled = true;
      this.buttonElement.addClass("ui-button ui-widget ui-state-default ui-corner-all").attr("role", "button").bind("mouseenter.button", function () {
        if (!c.disabled) {
          a(this).addClass("ui-state-hover");
          this === g && a(this).addClass("ui-state-active")
        }
      }).bind("mouseleave.button", function () {
        c.disabled || a(this).removeClass(e)
      }).bind("focus.button", function () {
        a(this).addClass("ui-state-focus")
      }).bind("blur.button", function () {
        a(this).removeClass("ui-state-focus")
      });
      d && this.element.bind("change.button", function () {
        b.refresh()
      });
      if (this.type === "checkbox") this.buttonElement.bind("click.button", function () {
        if (c.disabled) return false;
        a(this).toggleClass("ui-state-active");
        b.buttonElement.attr("aria-pressed", b.element[0].checked)
      });
      else if (this.type === "radio") this.buttonElement.bind("click.button", function () {
        if (c.disabled) return false;
        a(this).addClass("ui-state-active");
        b.buttonElement.attr("aria-pressed", true);
        var f = b.element[0];
        h(f).not(f).map(function () {
          return a(this).button("widget")[0]
        }).removeClass("ui-state-active").attr("aria-pressed", false)
      });
      else {
        this.buttonElement.bind("mousedown.button", function () {
          if (c.disabled) return false;
          a(this).addClass("ui-state-active");
          g = this;
          a(document).one("mouseup", function () {
            g = null
          })
        }).bind("mouseup.button", function () {
          if (c.disabled) return false;
          a(this).removeClass("ui-state-active")
        }).bind("keydown.button", function (f) {
          if (c.disabled) return false;
          if (f.keyCode == a.ui.keyCode.SPACE || f.keyCode == a.ui.keyCode.ENTER) a(this).addClass("ui-state-active")
        }).bind("keyup.button", function () {
          a(this).removeClass("ui-state-active")
        });
        this.buttonElement.is("a") && this.buttonElement.keyup(function (f) {
          f.keyCode === a.ui.keyCode.SPACE && a(this).click()
        })
      }
      this._setOption("disabled", c.disabled)
    },
    _determineButtonType: function () {
      this.type = this.element.is(":checkbox") ? "checkbox" : this.element.is(":radio") ? "radio" : this.element.is("input") ? "input" : "button";
      if (this.type === "checkbox" || this.type === "radio") {
        this.buttonElement = this.element.parents().last().find("[for=" + this.element.attr("id") + "]");
        this.element.addClass("ui-helper-hidden-accessible");
        var b = this.element.is(":checked");
        b && this.buttonElement.addClass("ui-state-active");
        this.buttonElement.attr("aria-pressed", b)
      } else this.buttonElement = this.element
    },
    widget: function () {
      return this.buttonElement
    },
    destroy: function () {
      this.element.removeClass("ui-helper-hidden-accessible");
      this.buttonElement.removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover ui-state-active ui-button-icons-only ui-button-icon-only ui-button-text-icons ui-button-text-icon ui-button-text-only").removeAttr("role").removeAttr("aria-pressed").html(this.buttonElement.find(".ui-button-text").html());
      this.hasTitle || this.buttonElement.removeAttr("title");
      a.Widget.prototype.destroy.call(this)
    },
    _setOption: function (b, c) {
      a.Widget.prototype._setOption.apply(this, arguments);
      if (b === "disabled") c ? this.element.attr("disabled", true) : this.element.removeAttr("disabled");
      this._resetButton()
    },
    refresh: function () {
      var b = this.element.is(":disabled");
      b !== this.options.disabled && this._setOption("disabled", b);
      if (this.type === "radio") h(this.element[0]).each(function () {
        a(this).is(":checked") ? a(this).button("widget").addClass("ui-state-active").attr("aria-pressed", true) : a(this).button("widget").removeClass("ui-state-active").attr("aria-pressed", false)
      });
      else if (this.type === "checkbox") this.element.is(":checked") ? this.buttonElement.addClass("ui-state-active").attr("aria-pressed", true) : this.buttonElement.removeClass("ui-state-active").attr("aria-pressed", false)
    },
    _resetButton: function () {
      if (this.type === "input") this.options.label && this.element.val(this.options.label);
      else {
        var b = this.buttonElement,
        c = a("<span></span>").addClass("ui-button-text").html(this.options.label).appendTo(b.empty()).text(),
        d = this.options.icons,
        e = d.primary && d.secondary;
        if (d.primary || d.secondary) {
          b.addClass("ui-button-text-icon" + (e ? "s" : ""));
          d.primary && b.prepend("<span class='ui-button-icon-primary ui-icon " + d.primary + "'></span>");
          d.secondary && b.append("<span class='ui-button-icon-secondary ui-icon " + d.secondary + "'></span>");
          if (!this.options.text) {
            b.addClass(e ? "ui-button-icons-only" : "ui-button-icon-only").removeClass("ui-button-text-icons ui-button-text-icon");
            this.hasTitle || b.attr("title", c)
          }
        } else b.addClass("ui-button-text-only")
      }
    }
  });
  a.widget("ui.buttonset", {
    _create: function () {
      this.element.addClass("ui-buttonset");
      this._init()
    },
    _init: function () {
      this.refresh()
    },
    _setOption: function (b, c) {
      b === "disabled" && this.buttons.button("option", b, c);
      a.Widget.prototype._setOption.apply(this, arguments)
    },
    refresh: function () {
      this.buttons = this.element.find(":button, :submit, :reset, :checkbox, :radio, a, :data(button)").filter(":ui-button").button("refresh").end().not(":ui-button").button().end().map(function () {
        return a(this).button("widget")[0]
      }).removeClass("ui-corner-all ui-corner-left ui-corner-right").filter(":first").addClass("ui-corner-left").end().filter(":last").addClass("ui-corner-right").end().end()
    },
    destroy: function () {
      this.element.removeClass("ui-buttonset");
      this.buttons.map(function () {
        return a(this).button("widget")[0]
      }).removeClass("ui-corner-left ui-corner-right").end().button("destroy");
      a.Widget.prototype.destroy.call(this)
    }
  })
})(jQuery);
;
/*
 * jQuery UI Dialog 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Dialog
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *  jquery.ui.button.js
 *	jquery.ui.draggable.js
 *	jquery.ui.mouse.js
 *	jquery.ui.position.js
 *	jquery.ui.resizable.js
 */
(function (c) {
  c.widget("ui.dialog", {
    options: {
      autoOpen: true,
      buttons: {},
      closeOnEscape: true,
      closeText: "[x]",
      dialogClass: "",
      draggable: true,
      hide: "explode",
      height: "auto",
      maxHeight: false,
      maxWidth: false,
      minHeight: 150,
      minWidth: 150,
      modal: false,
      position: "center",
      resizable: true,
      show: "slide",
      stack: true,
      title: "",
      width: 350,
      zIndex: 1E3
    },
    _create: function () {
      this.originalTitle = this.element.attr("title");
      var a = this,
      b = a.options,
      d = b.title || a.originalTitle || "&#160;",
      e = c.ui.dialog.getTitleId(a.element),
      g = (a.uiDialog = c("<div></div>")).appendTo(document.body).hide().addClass("ui-dialog ui-widget ui-widget-content " + b.dialogClass).css({
        zIndex: b.zIndex
      }).attr("tabIndex", -1).css("outline", 0).keydown(function (i) {
        if (b.closeOnEscape && i.keyCode && i.keyCode === c.ui.keyCode.ESCAPE) {
          a.close(i);
          i.preventDefault()
        }
      }).attr({
        role: "dialog",
        "aria-labelledby": e
      }).mousedown(function (i) {
        a.moveToTop(false, i)
      });
      a.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(g);
      var f = (a.uiDialogTitlebar = c("<div></div>")).addClass("ui-dialog-titlebar ui-widget-header ui-helper-clearfix").prependTo(g),
      h = c('<a href="#"></a>').addClass("ui-dialog-titlebar-close").attr("role", "button").hover(function () {
        if(!c(this).is(".ui-alert-dialog .ui-dialog-titlebar-close")) h.addClass("ui-state-hover")
      }, function () {
        h.removeClass("ui-state-hover")
      }).focus(function () {
        h.addClass("ui-state-focus")
      }).blur(function () {
        h.removeClass("ui-state-focus")
      }).click(function (i) {
        a.close(i);
        return false
      }).appendTo(f);
      (a.uiDialogTitlebarCloseText = c("<span></span>")).addClass("ui-icon ui-icon-close").text(b.closeText).appendTo(h);
      c("<span></span>").addClass("ui-dialog-title").attr("id", e).html(d).prependTo(f);
      if (c.isFunction(b.beforeclose) && !c.isFunction(b.beforeClose)) b.beforeClose = b.beforeclose;
      f.find("*").add(f).disableSelection();
      b.draggable && c.fn.draggable && a._makeDraggable();
      b.resizable && c.fn.resizable && a._makeResizable();
      a._createButtons(b.buttons);
      a._isOpen = false;
      c.fn.bgiframe && g.bgiframe()
    },
    _init: function () {
      this.options.autoOpen && this.open()
    },
    destroy: function () {
      var a = this;
      a.overlay && a.overlay.destroy();
      a.uiDialog.hide();
      a.element.unbind(".dialog").removeData("dialog").removeClass("ui-dialog-content ui-widget-content").hide().appendTo("body");
      a.uiDialog.remove();
      a.originalTitle && a.element.attr("title", a.originalTitle);
      return a
    },
    widget: function () {
      return this.uiDialog
    },
    close: function (a) {
      var b = this,
      d;
      if (false !== b._trigger("beforeClose", a)) {
        b.overlay && b.overlay.destroy();
        b.uiDialog.unbind("keypress.ui-dialog");
        b._isOpen = false;
        if (b.options.hide) b.uiDialog.hide(b.options.hide, function () {
          b._trigger("close", a)
        });
        else {
          b.uiDialog.hide();
          b._trigger("close", a)
        }
        c.ui.dialog.overlay.resize();
        if (b.options.modal) {
          d = 0;
          c(".ui-dialog").each(function () {
            if (this !== b.uiDialog[0]) d = Math.max(d, c(this).css("z-index"))
          });
          c.ui.dialog.maxZ = d
        }
        return b
      }
    },
    isOpen: function () {
      return this._isOpen
    },
    moveToTop: function (a, b) {
      var d = this,
      e = d.options;
      if (e.modal && !a || !e.stack && !e.modal) return d._trigger("focus", b);
      if (e.zIndex > c.ui.dialog.maxZ) c.ui.dialog.maxZ = e.zIndex;
      if (d.overlay) {
        c.ui.dialog.maxZ += 1;
        d.overlay.$el.css("z-index", c.ui.dialog.overlay.maxZ = c.ui.dialog.maxZ)
      }
      a = {
        scrollTop: d.element.attr("scrollTop"),
        scrollLeft: d.element.attr("scrollLeft")
      };
      c.ui.dialog.maxZ += 1;
      d.uiDialog.css("z-index", c.ui.dialog.maxZ);
      d.element.attr(a);
      d._trigger("focus", b);
      return d
    },
    open: function () {
      if (!this._isOpen) {
        var a = this,
        b = a.options,
        d = a.uiDialog;
        a.overlay = b.modal ? new c.ui.dialog.overlay(a) : null;
        d.next().length && d.appendTo("body");
        a._size();
        a._position(b.position);
                
        b.modal && d.bind("keypress.ui-dialog", function (e) {
          if (e.keyCode === c.ui.keyCode.TAB) {
            var g = c(":tabbable", this),
            f = g.filter(":first");
            g = g.filter(":last");
            if (e.target === g[0] && !e.shiftKey) {
              f.focus(1);
              return false
            } else if (e.target === f[0] && e.shiftKey) {
              g.focus(1);
              return false
            }
          }
        });
        c([]).add(d.find(".ui-dialog-content :tabbable:first")).add(d.find(".ui-dialog-buttonpane :tabbable:first")).add(d).filter(":first").focus();
        d.show(b.show,b.afterOpen);
        a.moveToTop(true);
        a._trigger("open");
        a._isOpen = true;
        return a
      }
    },
    _createButtons: function (a) {
      var b = this,
      d = false,
      e = c("<div></div>").addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix");
      b.uiDialog.find(".ui-dialog-buttonpane").remove();
      typeof a === "object" && a !== null && c.each(a, function () {
        return !(d = true)
      });
      if (d) {
        c.each(a, function (g, f) {
					
          var ac=null;
          opt={};
          
          if($.isFunction(f)){
            ac=f;
          }else{
            ac=f.action
            if(f.icons != undefined){
              opt.icons = {};
              if(typeof f.icons == 'string')
                opt.icons.primary=f.icons;
              else
                opt.icons=f.icons;
            }
          }
          g = c('<button type="button"></button>').text(g).click(function () {
            var args = arguments;
            ac.apply(b.element[0], args);
          }).appendTo(e);
                    
          c.fn.button && g.button(opt);
        });
        e.appendTo(b.uiDialog)
      }
    },
    _makeDraggable: function () {
      function a(f) {
        return {
          position: f.position,
          offset: f.offset
        }
      }
      var b = this,
      d = b.options,
      e = c(document),
      g;
      b.uiDialog.draggable({
        cancel: ".ui-dialog-content, .ui-dialog-titlebar-close",
        handle: ".ui-dialog-titlebar",
        containment: "document",
        start: function (f, h) {
          g = d.height === "auto" ? "auto" : c(this).height();
          c(this).height(c(this).height()).addClass("ui-dialog-dragging");
          b._trigger("dragStart", f, a(h))
        },
        drag: function (f, h) {
          b._trigger("drag", f, a(h))
        },
        stop: function (f, h) {
          d.position = [h.position.left - e.scrollLeft(), h.position.top - e.scrollTop()];
          c(this).removeClass("ui-dialog-dragging").height(g);
          b._trigger("dragStop", f, a(h));
          c.ui.dialog.overlay.resize()
        }
      })
    },
    _makeResizable: function (a) {
      function b(f) {
        return {
          originalPosition: f.originalPosition,
          originalSize: f.originalSize,
          position: f.position,
          size: f.size
        }
      }
      a = a === undefined ? this.options.resizable : a;
      var d = this,
      e = d.options,
      g = d.uiDialog.css("position");
      a = typeof a === "string" ? a : "n,e,s,w,se,sw,ne,nw";
      d.uiDialog.resizable({
        cancel: ".ui-dialog-content",
        containment: "document",
        alsoResize: d.element,
        maxWidth: e.maxWidth,
        maxHeight: e.maxHeight,
        minWidth: e.minWidth,
        minHeight: d._minHeight(),
        handles: a,
        start: function (f, h) {
          c(this).addClass("ui-dialog-resizing");
          d._trigger("resizeStart", f, b(h))
        },
        resize: function (f, h) {
          d._trigger("resize", f, b(h))
        },
        stop: function (f, h) {
          c(this).removeClass("ui-dialog-resizing");
          e.height = c(this).height();
          e.width = c(this).width();
          d._trigger("resizeStop", f, b(h));
          c.ui.dialog.overlay.resize()
        }
      }).css("position", g).find(".ui-resizable-se").addClass("ui-icon ui-icon-grip-diagonal-se")
    },
    _minHeight: function () {
      var a = this.options;
      return a.height === "auto" ? a.minHeight : Math.min(a.minHeight, a.height)
    },
    _position: function (a) {
      var b = [],
      d = [0, 0];
      a = a || c.ui.dialog.prototype.options.position;
      if (typeof a === "string" || typeof a === "object" && "0" in a) {
        b = a.split ? a.split(" ") : [a[0], a[1]];
        if (b.length === 1) b[1] = b[0];
        c.each(["left", "top"], function (e, g) {
          if (+b[e] === b[e]) {
            d[e] = b[e];
            b[e] =
            g
          }
        })
      } else if (typeof a === "object") {
        if ("left" in a) {
          b[0] = "left";
          d[0] = a.left
        } else if ("right" in a) {
          b[0] = "right";
          d[0] = -a.right
        }
        if ("top" in a) {
          b[1] = "top";
          d[1] = a.top
        } else if ("bottom" in a) {
          b[1] = "bottom";
          d[1] = -a.bottom
        }
      }(a = this.uiDialog.is(":visible")) || this.uiDialog.show();
      this.uiDialog.css({
        top: 0,
        left: 0
      }).position({
        my: b.join(" "),
        at: b.join(" "),
        offset: d.join(" "),
        of: window,
        collision: "fit",
        using: function (e) {
          var g = c(this).css(e).offset().top;
          g < 0 && c(this).css("top", e.top - g)
        }
      });
      a || this.uiDialog.hide()
    },
    _setOption: function (a, b) {
      var d = this,
      e = d.uiDialog,
      g = e.is(":data(resizable)"),
      f = false;
      switch (a) {
        case "beforeclose":
          a = "beforeClose";
          break;
        case "buttons":
          d._createButtons(b);
          break;
        case "closeText":
          d.uiDialogTitlebarCloseText.text("" + b);
          break;
        case "dialogClass":
          e.removeClass(d.options.dialogClass).addClass("ui-dialog ui-widget ui-widget-content ui-corner-all " + b);
          break;
        case "disabled":
          b ? e.addClass("ui-dialog-disabled") : e.removeClass("ui-dialog-disabled");
          break;
        case "draggable":
          b ? d._makeDraggable() : e.draggable("destroy");
          break;
        case "height":
          f = true;
          break;
        case "maxHeight":
          g && e.resizable("option", "maxHeight", b);
          f = true;
          break;
        case "maxWidth":
          g && e.resizable("option", "maxWidth", b);
          f = true;
          break;
        case "minHeight":
          g && e.resizable("option", "minHeight", b);
          f = true;
          break;
        case "minWidth":
          g && e.resizable("option", "minWidth", b);
          f = true;
          break;
        case "position":
          d._position(b);
          break;
        case "resizable":
          g && !b && e.resizable("destroy");
          g && typeof b === "string" && e.resizable("option", "handles", b);
          !g && b !== false && d._makeResizable(b);
          break;
        case "title":
          c(".ui-dialog-title", d.uiDialogTitlebar).html("" + (b || "&#160;"));
          break;
        case "width":
          f = true;
          break
      }
      c.Widget.prototype._setOption.apply(d, arguments);
      f && d._size()
    },
    _size: function () {
      var a = this.options,
      b;
      this.element.css({
        width: "auto",
        minHeight: 0,
        height: 0
      });
      b = this.uiDialog.css({
        height: "auto",
        width: a.width
      }).height();
      this.element.css(a.height === "auto" ? {
        minHeight: Math.max(a.minHeight - b, 0),
        height: "auto"
      } : {
        minHeight: 0,
        height: Math.max(a.height - b, 0)
      }).show();
      this.uiDialog.is(":data(resizable)") && this.uiDialog.resizable("option", "minHeight", this._minHeight())
    }
  });
  c.extend(c.ui.dialog, {
    version: "1.8.1",
    uuid: 0,
    maxZ: 0,
    getTitleId: function (a) {
      a = a.attr("id");
      if (!a) {
        this.uuid += 1;
        a = this.uuid
      }
      return "ui-dialog-title-" + a
    },
    overlay: function (a) {
      this.$el = c.ui.dialog.overlay.create(a)
    }
  });
  c.extend(c.ui.dialog.overlay, {
    instances: [],
    oldInstances: [],
    maxZ: 0,
    events: c.map("focus,mousedown,mouseup,keydown,keypress,click".split(","), function (a) {
      return a + ".dialog-overlay"
    }).join(" "),
    create: function (a) {
      if (this.instances.length === 0) {
        setTimeout(function () {
          c.ui.dialog.overlay.instances.length && c(document).bind(c.ui.dialog.overlay.events, function (d) {
            return c(d.target).zIndex() >= c.ui.dialog.overlay.maxZ
          })
        }, 1);
        c(document).bind("keydown.dialog-overlay", function (d) {
          if (a.options.closeOnEscape && d.keyCode && d.keyCode === c.ui.keyCode.ESCAPE) {
            a.close(d);
            d.preventDefault()
          }
        });
        c(window).bind("resize.dialog-overlay", c.ui.dialog.overlay.resize)
      }
      var b = (this.oldInstances.pop() || c("<div></div>").addClass("ui-widget-overlay")).appendTo(document.body).css({
        width: this.width(),
        height: this.height()
      });
      c.fn.bgiframe && b.bgiframe();
      this.instances.push(b);
      return b
    },
    destroy: function (a) {
      this.oldInstances.push(this.instances.splice(c.inArray(a, this.instances), 1)[0]);
      this.instances.length === 0 && c([document, window]).unbind(".dialog-overlay");
      a.remove();
      var b = 0;
      c.each(this.instances, function () {
        b = Math.max(b, this.css("z-index"))
      });
      this.maxZ = b
    },
    height: function () {
      var a, b;
      if (c.browser.msie && c.browser.version < 7) {
        a = Math.max(document.documentElement.scrollHeight, document.body.scrollHeight);
        b = Math.max(document.documentElement.offsetHeight, document.body.offsetHeight);
        return a < b ? c(window).height() + "px" : a + "px"
      } else return c(document).height() + "px"
    },
    width: function () {
      var a, b;
      if (c.browser.msie && c.browser.version < 7) {
        a = Math.max(document.documentElement.scrollWidth, document.body.scrollWidth);
        b = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth);
        return a < b ? c(window).width() + "px" : a + "px"
      } else return c(document).width() + "px"
    },
    resize: function () {
      var a = c([]);
      c.each(c.ui.dialog.overlay.instances, function () {
        a = a.add(this)
      });
      a.css({
        width: 0,
        height: 0
      }).css({
        width: c.ui.dialog.overlay.width(),
        height: c.ui.dialog.overlay.height()
      })
    }
  });
  c.extend(c.ui.dialog.overlay.prototype, {
    destroy: function () {
      c.ui.dialog.overlay.destroy(this.$el)
    }
  })
})(jQuery);
;

/*
 * jQuery UI Progressbar 1.8.1
 *
 * Copyright (c) 2010 AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * http://docs.jquery.com/UI/Progressbar
 *
 * Depends:
 *   jquery.ui.core.js
 *   jquery.ui.widget.js
 */
(function (b) {
  b.widget("ui.progressbar", {
    options: {
      value: 0
    },
    _create: function () {
      this.element.addClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").attr({
        role: "progressbar",
        "aria-valuemin": this._valueMin(),
        "aria-valuemax": this._valueMax(),
        "aria-valuenow": this._value()
      });
      this.valueDiv = b("<div class='ui-progressbar-value ui-widget-header ui-corner-left'></div>").appendTo(this.element);
      this._refreshValue()
    },
    destroy: function () {
      this.element.removeClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow");
      this.valueDiv.remove();
      b.Widget.prototype.destroy.apply(this, arguments)
    },
    value: function (a) {
      if (a === undefined) return this._value();
      this._setOption("value", a);
      return this
    },
    _setOption: function (a, c) {
      switch (a) {
        case "value":
          this.options.value = c;
          this._refreshValue();
          this._trigger("change");
          break
      }
      b.Widget.prototype._setOption.apply(this, arguments)
    },
    _value: function () {
      var a = this.options.value;
      if (typeof a !== "number") a = 0;
      if (a < this._valueMin()) a = this._valueMin();
      if (a > this._valueMax()) a = this._valueMax();
      return a
    },
    _valueMin: function () {
      return 0
    },
    _valueMax: function () {
      return 100
    },
    _refreshValue: function () {
      var a = this.value();
      this.valueDiv[a === this._valueMax() ? "addClass" : "removeClass"]("ui-corner-right").width(a + "%");
      this.element.attr("aria-valuenow", a)
    }
  });
  b.extend(b.ui.progressbar, {
    version: "1.8.1"
  })
})(jQuery);
;
/*
 * jQuery UI Effects 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/
 */
;
jQuery.effects || (function ($, undefined) {

  $.effects = {};



  /******************************************************************************/
  /****************************** COLOR ANIMATIONS ******************************/
  /******************************************************************************/

  // override the animation for color styles
  $.each(['backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'color', 'outlineColor'], function (i, attr) {
    $.fx.step[attr] = function (fx) {
      if (!fx.colorInit) {
        fx.start = getColor(fx.elem, attr);
        fx.end = getRGB(fx.end);
        fx.colorInit = true;
      }

      fx.elem.style[attr] = 'rgb(' + Math.max(Math.min(parseInt((fx.pos * (fx.end[0] - fx.start[0])) + fx.start[0], 10), 255), 0) + ',' + Math.max(Math.min(parseInt((fx.pos * (fx.end[1] - fx.start[1])) + fx.start[1], 10), 255), 0) + ',' + Math.max(Math.min(parseInt((fx.pos * (fx.end[2] - fx.start[2])) + fx.start[2], 10), 255), 0) + ')';
    };
  });

  // Color Conversion functions from highlightFade
  // By Blair Mitchelmore
  // http://jquery.offput.ca/highlightFade/
  // Parse strings looking for color tuples [255,255,255]


  function getRGB(color) {
    var result;

    // Check if we're already dealing with an array of colors
    if (color && color.constructor == Array && color.length == 3) return color;

    // Look for rgb(num,num,num)
    if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color)) return [parseInt(result[1], 10), parseInt(result[2], 10), parseInt(result[3], 10)];

    // Look for rgb(num%,num%,num%)
    if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color)) return [parseFloat(result[1]) * 2.55, parseFloat(result[2]) * 2.55, parseFloat(result[3]) * 2.55];

    // Look for #a0b1c2
    if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color)) return [parseInt(result[1], 16), parseInt(result[2], 16), parseInt(result[3], 16)];

    // Look for #fff
    if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color)) return [parseInt(result[1] + result[1], 16), parseInt(result[2] + result[2], 16), parseInt(result[3] + result[3], 16)];

    // Look for rgba(0, 0, 0, 0) == transparent in Safari 3
    if (result = /rgba\(0, 0, 0, 0\)/.exec(color)) return colors['transparent'];

    // Otherwise, we're most likely dealing with a named color
    return colors[$.trim(color).toLowerCase()];
  }

  function getColor(elem, attr) {
    var color;

    do {
      color = $.curCSS(elem, attr);

      // Keep going until we find an element that has color, or we hit the body
      if (color != '' && color != 'transparent' || $.nodeName(elem, "body")) break;

      attr = "backgroundColor";
    } while (elem = elem.parentNode);

    return getRGB(color);
  };

  // Some named colors to work with
  // From Interface by Stefan Petre
  // http://interface.eyecon.ro/
  var colors = {
    aqua: [0, 255, 255],
    azure: [240, 255, 255],
    beige: [245, 245, 220],
    black: [0, 0, 0],
    blue: [0, 0, 255],
    brown: [165, 42, 42],
    cyan: [0, 255, 255],
    darkblue: [0, 0, 139],
    darkcyan: [0, 139, 139],
    darkgrey: [169, 169, 169],
    darkgreen: [0, 100, 0],
    darkkhaki: [189, 183, 107],
    darkmagenta: [139, 0, 139],
    darkolivegreen: [85, 107, 47],
    darkorange: [255, 140, 0],
    darkorchid: [153, 50, 204],
    darkred: [139, 0, 0],
    darksalmon: [233, 150, 122],
    darkviolet: [148, 0, 211],
    fuchsia: [255, 0, 255],
    gold: [255, 215, 0],
    green: [0, 128, 0],
    indigo: [75, 0, 130],
    khaki: [240, 230, 140],
    lightblue: [173, 216, 230],
    lightcyan: [224, 255, 255],
    lightgreen: [144, 238, 144],
    lightgrey: [211, 211, 211],
    lightpink: [255, 182, 193],
    lightyellow: [255, 255, 224],
    lime: [0, 255, 0],
    magenta: [255, 0, 255],
    maroon: [128, 0, 0],
    navy: [0, 0, 128],
    olive: [128, 128, 0],
    orange: [255, 165, 0],
    pink: [255, 192, 203],
    purple: [128, 0, 128],
    violet: [128, 0, 128],
    red: [255, 0, 0],
    silver: [192, 192, 192],
    white: [255, 255, 255],
    yellow: [255, 255, 0],
    transparent: [255, 255, 255]
  };



  /******************************************************************************/
  /****************************** CLASS ANIMATIONS ******************************/
  /******************************************************************************/

  var classAnimationActions = ['add', 'remove', 'toggle'],
  shorthandStyles = {
    border: 1,
    borderBottom: 1,
    borderColor: 1,
    borderLeft: 1,
    borderRight: 1,
    borderTop: 1,
    borderWidth: 1,
    margin: 1,
    padding: 1
  };

  function getElementStyles() {
    var style = document.defaultView ? document.defaultView.getComputedStyle(this, null) : this.currentStyle,
    newStyle = {},
    key, camelCase;

    // webkit enumerates style porperties
    if (style && style.length && style[0] && style[style[0]]) {
      var len = style.length;
      while (len--) {
        key = style[len];
        if (typeof style[key] == 'string') {
          camelCase = key.replace(/\-(\w)/g, function (all, letter) {
            return letter.toUpperCase();
          });
          newStyle[camelCase] = style[key];
        }
      }
    } else {
      for (key in style) {
        if (typeof style[key] === 'string') {
          newStyle[key] = style[key];
        }
      }
    }

    return newStyle;
  }

  function filterStyles(styles) {
    var name, value;
    for (name in styles) {
      value = styles[name];
      if (
        // ignore null and undefined values
        value == null ||
        // ignore functions (when does this occur?)
        $.isFunction(value) ||
        // shorthand styles that need to be expanded
        name in shorthandStyles ||
        // ignore scrollbars (break in IE)
        (/scrollbar/).test(name) ||

        // only colors or values that can be converted to numbers
        (!(/color/i).test(name) && isNaN(parseFloat(value)))) {
        delete styles[name];
      }
    }

    return styles;
  }

  function styleDifference(oldStyle, newStyle) {
    var diff = {
      _: 0
    },
    // http://dev.jquery.com/ticket/5459
    name;

    for (name in newStyle) {
      if (oldStyle[name] != newStyle[name]) {
        diff[name] = newStyle[name];
      }
    }

    return diff;
  }

  $.effects.animateClass = function (value, duration, easing, callback) {
    if ($.isFunction(easing)) {
      callback = easing;
      easing = null;
    }

    return this.each(function () {

      var that = $(this),
      originalStyleAttr = that.attr('style') || ' ',
      originalStyle = filterStyles(getElementStyles.call(this)),
      newStyle, className = that.attr('className');

      $.each(classAnimationActions, function (i, action) {
        if (value[action]) {
          that[action + 'Class'](value[action]);
        }
      });
      newStyle = filterStyles(getElementStyles.call(this));
      that.attr('className', className);

      that.animate(styleDifference(originalStyle, newStyle), duration, easing, function () {
        $.each(classAnimationActions, function (i, action) {
          if (value[action]) {
            that[action + 'Class'](value[action]);
          }
        });
        // work around bug in IE by clearing the cssText before setting it
        if (typeof that.attr('style') == 'object') {
          that.attr('style').cssText = '';
          that.attr('style').cssText = originalStyleAttr;
        } else {
          that.attr('style', originalStyleAttr);
        }
        if (callback) {
          callback.apply(this, arguments);
        }
      });
    });
  };

  $.fn.extend({
    _addClass: $.fn.addClass,
    addClass: function (classNames, speed, easing, callback) {
      return speed ? $.effects.animateClass.apply(this, [{
        add: classNames
      },
      speed, easing, callback]) : this._addClass(classNames);
    },

    _removeClass: $.fn.removeClass,
    removeClass: function (classNames, speed, easing, callback) {
      return speed ? $.effects.animateClass.apply(this, [{
        remove: classNames
      },
      speed, easing, callback]) : this._removeClass(classNames);
    },

    _toggleClass: $.fn.toggleClass,
    toggleClass: function (classNames, force, speed, easing, callback) {
      if (typeof force == "boolean" || force === undefined) {
        if (!speed) {
          // without speed parameter;
          return this._toggleClass(classNames, force);
        } else {
          return $.effects.animateClass.apply(this, [(force ? {
            add: classNames
          } : {
            remove: classNames
          }), speed, easing, callback]);
        }
      } else {
        // without switch parameter;
        return $.effects.animateClass.apply(this, [{
          toggle: classNames
        },
        force, speed, easing]);
      }
    },

    switchClass: function (remove, add, speed, easing, callback) {
      return $.effects.animateClass.apply(this, [{
        add: add,
        remove: remove
      },
      speed, easing, callback]);
    }
  });



  /******************************************************************************/
  /*********************************** EFFECTS **********************************/
  /******************************************************************************/

  $.extend($.effects, {
    version: "1.8.4",

    // Saves a set of properties in a data storage
    save: function (element, set) {
      for (var i = 0; i < set.length; i++) {
        if (set[i] !== null) element.data("ec.storage." + set[i], element[0].style[set[i]]);
      }
    },

    // Restores a set of previously saved properties from a data storage
    restore: function (element, set) {
      for (var i = 0; i < set.length; i++) {
        if (set[i] !== null) element.css(set[i], element.data("ec.storage." + set[i]));
      }
    },

    setMode: function (el, mode) {
      if (mode == 'toggle') mode = el.is(':hidden') ? 'show' : 'hide'; // Set for toggle
      return mode;
    },

    getBaseline: function (origin, original) { // Translates a [top,left] array into a baseline value
      // this should be a little more flexible in the future to handle a string & hash
      var y, x;
      switch (origin[0]) {
        case 'top':
          y = 0;
          break;
        case 'middle':
          y = 0.5;
          break;
        case 'bottom':
          y = 1;
          break;
        default:
          y = origin[0] / original.height;
      };
      switch (origin[1]) {
        case 'left':
          x = 0;
          break;
        case 'center':
          x = 0.5;
          break;
        case 'right':
          x = 1;
          break;
        default:
          x = origin[1] / original.width;
      };
      return {
        x: x,
        y: y
      };
    },

    // Wraps the element around a wrapper that copies position properties
    createWrapper: function (element) {

      // if the element is already wrapped, return it
      if (element.parent().is('.ui-effects-wrapper')) {
        return element.parent();
      }

      // wrap the element
      var props = {
        width: element.outerWidth(true),
        height: element.outerHeight(true),
        'float': element.css('float')
      },
      wrapper = $('<div></div>').addClass('ui-effects-wrapper').css({
        fontSize: '100%',
        background: 'transparent',
        border: 'none',
        margin: 0,
        padding: 0
      });

      element.wrap(wrapper);
      wrapper = element.parent(); //Hotfix for jQuery 1.4 since some change in wrap() seems to actually loose the reference to the wrapped element
      // transfer positioning properties to the wrapper
      if (element.css('position') == 'static') {
        wrapper.css({
          position: 'relative'
        });
        element.css({
          position: 'relative'
        });
      } else {
        $.extend(props, {
          position: element.css('position'),
          zIndex: element.css('z-index')
        });
        $.each(['top', 'left', 'bottom', 'right'], function (i, pos) {
          props[pos] = element.css(pos);
          if (isNaN(parseInt(props[pos], 10))) {
            props[pos] = 'auto';
          }
        });
        element.css({
          position: 'relative',
          top: 0,
          left: 0
        });
      }

      return wrapper.css(props).show();
    },

    removeWrapper: function (element) {
      if (element.parent().is('.ui-effects-wrapper')) return element.parent().replaceWith(element);
      return element;
    },

    setTransition: function (element, list, factor, value) {
      value = value || {};
      $.each(list, function (i, x) {
        unit = element.cssUnit(x);
        if (unit[0] > 0) value[x] = unit[0] * factor + unit[1];
      });
      return value;
    }
  });


  function _normalizeArguments(effect, options, speed, callback) {
    // shift params for method overloading
    if (typeof effect == 'object') {
      callback = options;
      speed = null;
      options = effect;
      effect = options.effect;
    }
    if ($.isFunction(options)) {
      callback = options;
      speed = null;
      options = {};
    }
    if (typeof options == 'number' || $.fx.speeds[options]) {
      callback = speed;
      speed = options;
      options = {};
    }
    if ($.isFunction(speed)) {
      callback = speed;
      speed = null;
    }

    options = options || {};

    speed = speed || options.duration;
    speed = $.fx.off ? 0 : typeof speed == 'number' ? speed : $.fx.speeds[speed] || $.fx.speeds._default;

    callback = callback || options.complete;

    return [effect, options, speed, callback];
  }

  $.fn.extend({
    effect: function (effect, options, speed, callback) {
      var args = _normalizeArguments.apply(this, arguments),
      // TODO: make effects takes actual parameters instead of a hash
      args2 = {
        options: args[1],
        duration: args[2],
        callback: args[3]
      },
      effectMethod = $.effects[effect];

      return effectMethod && !$.fx.off ? effectMethod.call(this, args2) : this;
    },

    _show: $.fn.show,
    show: function (speed) {
      if (!speed || typeof speed == 'number' || $.fx.speeds[speed]) {
        return this._show.apply(this, arguments);
      } else {
        var args = _normalizeArguments.apply(this, arguments);
        args[1].mode = 'show';
        return this.effect.apply(this, args);
      }
    },

    _hide: $.fn.hide,
    hide: function (speed) {
      if (!speed || typeof speed == 'number' || $.fx.speeds[speed]) {
        return this._hide.apply(this, arguments);
      } else {
        var args = _normalizeArguments.apply(this, arguments);
        args[1].mode = 'hide';
        return this.effect.apply(this, args);
      }
    },

    // jQuery core overloads toggle and create _toggle
    __toggle: $.fn.toggle,
    toggle: function (speed) {
      if (!speed || typeof speed == 'number' || $.fx.speeds[speed] || typeof speed == 'boolean' || $.isFunction(speed)) {
        return this.__toggle.apply(this, arguments);
      } else {
        var args = _normalizeArguments.apply(this, arguments);
        args[1].mode = 'toggle';
        return this.effect.apply(this, args);
      }
    },

    // helper functions
    cssUnit: function (key) {
      var style = this.css(key),
      val = [];
      $.each(['em', 'px', '%', 'pt'], function (i, unit) {
        if (style.indexOf(unit) > 0) val = [parseFloat(style), unit];
      });
      return val;
    }
  });



  /******************************************************************************/
  /*********************************** EASING ***********************************/
  /******************************************************************************/

  /*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
*/

  // t: current time, b: begInnIng value, c: change In value, d: duration
  $.easing.jswing = $.easing.swing;

  $.extend($.easing, {
    def: 'easeOutQuad',
    swing: function (x, t, b, c, d) {
      //alert($.easing.default);
      return $.easing[$.easing.def](x, t, b, c, d);
    },
    easeInQuad: function (x, t, b, c, d) {
      return c * (t /= d) * t + b;
    },
    easeOutQuad: function (x, t, b, c, d) {
      return -c * (t /= d) * (t - 2) + b;
    },
    easeInOutQuad: function (x, t, b, c, d) {
      if ((t /= d / 2) < 1) return c / 2 * t * t + b;
      return -c / 2 * ((--t) * (t - 2) - 1) + b;
    },
    easeInCubic: function (x, t, b, c, d) {
      return c * (t /= d) * t * t + b;
    },
    easeOutCubic: function (x, t, b, c, d) {
      return c * ((t = t / d - 1) * t * t + 1) + b;
    },
    easeInOutCubic: function (x, t, b, c, d) {
      if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
      return c / 2 * ((t -= 2) * t * t + 2) + b;
    },
    easeInQuart: function (x, t, b, c, d) {
      return c * (t /= d) * t * t * t + b;
    },
    easeOutQuart: function (x, t, b, c, d) {
      return -c * ((t = t / d - 1) * t * t * t - 1) + b;
    },
    easeInOutQuart: function (x, t, b, c, d) {
      if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
      return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
    },
    easeInQuint: function (x, t, b, c, d) {
      return c * (t /= d) * t * t * t * t + b;
    },
    easeOutQuint: function (x, t, b, c, d) {
      return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
    },
    easeInOutQuint: function (x, t, b, c, d) {
      if ((t /= d / 2) < 1) return c / 2 * t * t * t * t * t + b;
      return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;
    },
    easeInSine: function (x, t, b, c, d) {
      return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
    },
    easeOutSine: function (x, t, b, c, d) {
      return c * Math.sin(t / d * (Math.PI / 2)) + b;
    },
    easeInOutSine: function (x, t, b, c, d) {
      return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
    },
    easeInExpo: function (x, t, b, c, d) {
      return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;
    },
    easeOutExpo: function (x, t, b, c, d) {
      return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
    },
    easeInOutExpo: function (x, t, b, c, d) {
      if (t == 0) return b;
      if (t == d) return b + c;
      if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
      return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
    },
    easeInCirc: function (x, t, b, c, d) {
      return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;
    },
    easeOutCirc: function (x, t, b, c, d) {
      return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
    },
    easeInOutCirc: function (x, t, b, c, d) {
      if ((t /= d / 2) < 1) return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
      return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
    },
    easeInElastic: function (x, t, b, c, d) {
      var s = 1.70158;
      var p = 0;
      var a = c;
      if (t == 0) return b;
      if ((t /= d) == 1) return b + c;
      if (!p) p = d * .3;
      if (a < Math.abs(c)) {
        a = c;
        var s = p / 4;
      }
      else var s = p / (2 * Math.PI) * Math.asin(c / a);
      return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
    },
    easeOutElastic: function (x, t, b, c, d) {
      var s = 1.70158;
      var p = 0;
      var a = c;
      if (t == 0) return b;
      if ((t /= d) == 1) return b + c;
      if (!p) p = d * .3;
      if (a < Math.abs(c)) {
        a = c;
        var s = p / 4;
      }
      else var s = p / (2 * Math.PI) * Math.asin(c / a);
      return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b;
    },
    easeInOutElastic: function (x, t, b, c, d) {
      var s = 1.70158;
      var p = 0;
      var a = c;
      if (t == 0) return b;
      if ((t /= d / 2) == 2) return b + c;
      if (!p) p = d * (.3 * 1.5);
      if (a < Math.abs(c)) {
        a = c;
        var s = p / 4;
      }
      else var s = p / (2 * Math.PI) * Math.asin(c / a);
      if (t < 1) return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
      return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b;
    },
    easeInBack: function (x, t, b, c, d, s) {
      if (s == undefined) s = 1.70158;
      return c * (t /= d) * t * ((s + 1) * t - s) + b;
    },
    easeOutBack: function (x, t, b, c, d, s) {
      if (s == undefined) s = 1.70158;
      return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
    },
    easeInOutBack: function (x, t, b, c, d, s) {
      if (s == undefined) s = 1.70158;
      if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
      return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
    },
    easeInBounce: function (x, t, b, c, d) {
      return c - $.easing.easeOutBounce(x, d - t, 0, c, d) + b;
    },
    easeOutBounce: function (x, t, b, c, d) {
      if ((t /= d) < (1 / 2.75)) {
        return c * (7.5625 * t * t) + b;
      } else if (t < (2 / 2.75)) {
        return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b;
      } else if (t < (2.5 / 2.75)) {
        return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b;
      } else {
        return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b;
      }
    },
    easeInOutBounce: function (x, t, b, c, d) {
      if (t < d / 2) return $.easing.easeInBounce(x, t * 2, 0, c, d) * .5 + b;
      return $.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * .5 + c * .5 + b;
    }
  });


})(jQuery);
/*
 * jQuery UI Effects Blind 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Blind
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.blind = function (o) {

    return this.queue(function () {

      // Create element
      var el = $(this),
      props = ['position', 'top', 'left'];

      // Set options
      var mode = $.effects.setMode(el, o.options.mode || 'hide'); // Set Mode
      var direction = o.options.direction || 'vertical'; // Default direction
      // Adjust
      $.effects.save(el, props);
      el.show(); // Save & Show
      var wrapper = $.effects.createWrapper(el).css({
        overflow: 'hidden'
      }); // Create Wrapper
      var ref = (direction == 'vertical') ? 'height' : 'width';
      var distance = (direction == 'vertical') ? wrapper.height() : wrapper.width();
      if (mode == 'show') wrapper.css(ref, 0); // Shift
      // Animation
      var animation = {};
      animation[ref] = mode == 'show' ? distance : 0;

      // Animate
      wrapper.animate(animation, o.duration, o.options.easing, function () {
        if (mode == 'hide') el.hide(); // Hide
        $.effects.restore(el, props);
        $.effects.removeWrapper(el); // Restore
        if (o.callback) o.callback.apply(el[0], arguments); // Callback
        el.dequeue();
      });

    });

  };

})(jQuery);
/*
 * jQuery UI Effects Bounce 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Bounce
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.bounce = function (o) {

    return this.queue(function () {

      // Create element
      var el = $(this),
      props = ['position', 'top', 'left'];

      // Set options
      var mode = $.effects.setMode(el, o.options.mode || 'effect'); // Set Mode
      var direction = o.options.direction || 'up'; // Default direction
      var distance = o.options.distance || 20; // Default distance
      var times = o.options.times || 5; // Default # of times
      var speed = o.duration || 250; // Default speed per bounce
      if (/show|hide/.test(mode)) props.push('opacity'); // Avoid touching opacity to prevent clearType and PNG issues in IE
      // Adjust
      $.effects.save(el, props);
      el.show(); // Save & Show
      $.effects.createWrapper(el); // Create Wrapper
      var ref = (direction == 'up' || direction == 'down') ? 'top' : 'left';
      var motion = (direction == 'up' || direction == 'left') ? 'pos' : 'neg';
      var distance = o.options.distance || (ref == 'top' ? el.outerHeight({
        margin: true
      }) / 3 : el.outerWidth({
        margin: true
      }) / 3);
      if (mode == 'show') el.css('opacity', 0).css(ref, motion == 'pos' ? -distance : distance); // Shift
      if (mode == 'hide') distance = distance / (times * 2);
      if (mode != 'hide') times--;

      // Animate
      if (mode == 'show') { // Show Bounce
        var animation = {
          opacity: 1
        };
        animation[ref] = (motion == 'pos' ? '+=' : '-=') + distance;
        el.animate(animation, speed / 2, o.options.easing);
        distance = distance / 2;
        times--;
      };
      for (var i = 0; i < times; i++) { // Bounces
        var animation1 = {},
        animation2 = {};
        animation1[ref] = (motion == 'pos' ? '-=' : '+=') + distance;
        animation2[ref] = (motion == 'pos' ? '+=' : '-=') + distance;
        el.animate(animation1, speed / 2, o.options.easing).animate(animation2, speed / 2, o.options.easing);
        distance = (mode == 'hide') ? distance * 2 : distance / 2;
      };
      if (mode == 'hide') { // Last Bounce
        var animation = {
          opacity: 0
        };
        animation[ref] = (motion == 'pos' ? '-=' : '+=') + distance;
        el.animate(animation, speed / 2, o.options.easing, function () {
          el.hide(); // Hide
          $.effects.restore(el, props);
          $.effects.removeWrapper(el); // Restore
          if (o.callback) o.callback.apply(this, arguments); // Callback
        });
      } else {
        var animation1 = {},
        animation2 = {};
        animation1[ref] = (motion == 'pos' ? '-=' : '+=') + distance;
        animation2[ref] = (motion == 'pos' ? '+=' : '-=') + distance;
        el.animate(animation1, speed / 2, o.options.easing).animate(animation2, speed / 2, o.options.easing, function () {
          $.effects.restore(el, props);
          $.effects.removeWrapper(el); // Restore
          if (o.callback) o.callback.apply(this, arguments); // Callback
        });
      };
      el.queue('fx', function () {
        el.dequeue();
      });
      el.dequeue();
    });

  };

})(jQuery);
/*
 * jQuery UI Effects Clip 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Clip
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.clip = function (o) {

    return this.queue(function () {

      // Create element
      var el = $(this),
      props = ['position', 'top', 'left', 'height', 'width'];

      // Set options
      var mode = $.effects.setMode(el, o.options.mode || 'hide'); // Set Mode
      var direction = o.options.direction || 'vertical'; // Default direction
      // Adjust
      $.effects.save(el, props);
      el.show(); // Save & Show
      var wrapper = $.effects.createWrapper(el).css({
        overflow: 'hidden'
      }); // Create Wrapper
      var animate = el[0].tagName == 'IMG' ? wrapper : el;
      var ref = {
        size: (direction == 'vertical') ? 'height' : 'width',
        position: (direction == 'vertical') ? 'top' : 'left'
      };
      var distance = (direction == 'vertical') ? animate.height() : animate.width();
      if (mode == 'show') {
        animate.css(ref.size, 0);
        animate.css(ref.position, distance / 2);
      } // Shift
      // Animation
      var animation = {};
      animation[ref.size] = mode == 'show' ? distance : 0;
      animation[ref.position] = mode == 'show' ? 0 : distance / 2;

      // Animate
      animate.animate(animation, {
        queue: false,
        duration: o.duration,
        easing: o.options.easing,
        complete: function () {
          if (mode == 'hide') el.hide(); // Hide
          $.effects.restore(el, props);
          $.effects.removeWrapper(el); // Restore
          if (o.callback) o.callback.apply(el[0], arguments); // Callback
          el.dequeue();
        }
      });

    });

  };

})(jQuery);
/*
 * jQuery UI Effects Drop 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Drop
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.drop = function (o) {

    return this.queue(function () {

      // Create element
      var el = $(this),
      props = ['position', 'top', 'left', 'opacity'];

      // Set options
      var mode = $.effects.setMode(el, o.options.mode || 'hide'); // Set Mode
      var direction = o.options.direction || 'left'; // Default Direction
      // Adjust
      $.effects.save(el, props);
      el.show(); // Save & Show
      $.effects.createWrapper(el); // Create Wrapper
      var ref = (direction == 'up' || direction == 'down') ? 'top' : 'left';
      var motion = (direction == 'up' || direction == 'left') ? 'pos' : 'neg';
      var distance = o.options.distance || (ref == 'top' ? el.outerHeight({
        margin: true
      }) / 2 : el.outerWidth({
        margin: true
      }) / 2);
      if (mode == 'show') el.css('opacity', 0).css(ref, motion == 'pos' ? -distance : distance); // Shift
      // Animation
      var animation = {
        opacity: mode == 'show' ? 1 : 0
      };
      animation[ref] = (mode == 'show' ? (motion == 'pos' ? '+=' : '-=') : (motion == 'pos' ? '-=' : '+=')) + distance;

      // Animate
      el.animate(animation, {
        queue: false,
        duration: o.duration,
        easing: o.options.easing,
        complete: function () {
          if (mode == 'hide') el.hide(); // Hide
          $.effects.restore(el, props);
          $.effects.removeWrapper(el); // Restore
          if (o.callback) o.callback.apply(this, arguments); // Callback
          el.dequeue();
        }
      });

    });

  };

})(jQuery);
/*
 * jQuery UI Effects Explode 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Explode
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.explode = function (o) {

    return this.queue(function () {

      var rows = o.options.pieces ? Math.round(Math.sqrt(o.options.pieces)) : 3;
      var cells = o.options.pieces ? Math.round(Math.sqrt(o.options.pieces)) : 3;

      o.options.mode = o.options.mode == 'toggle' ? ($(this).is(':visible') ? 'hide' : 'show') : o.options.mode;
      var el = $(this).show().css('visibility', 'hidden');
      var offset = el.offset();

      //Substract the margins - not fixing the problem yet.
      offset.top -= parseInt(el.css("marginTop"), 10) || 0;
      offset.left -= parseInt(el.css("marginLeft"), 10) || 0;

      var width = el.outerWidth(true);
      var height = el.outerHeight(true);

      for (var i = 0; i < rows; i++) { // =
        for (var j = 0; j < cells; j++) { // ||
          el.clone().appendTo('body').wrap('<div></div>').css({
            position: 'absolute',
            visibility: 'visible',
            left: -j * (width / cells),
            top: -i * (height / rows)
          }).parent().addClass('ui-effects-explode').css({
            position: 'absolute',
            overflow: 'hidden',
            width: width / cells,
            height: height / rows,
            left: offset.left + j * (width / cells) + (o.options.mode == 'show' ? (j - Math.floor(cells / 2)) * (width / cells) : 0),
            top: offset.top + i * (height / rows) + (o.options.mode == 'show' ? (i - Math.floor(rows / 2)) * (height / rows) : 0),
            opacity: o.options.mode == 'show' ? 0 : 1
          }).animate({
            left: offset.left + j * (width / cells) + (o.options.mode == 'show' ? 0 : (j - Math.floor(cells / 2)) * (width / cells)),
            top: offset.top + i * (height / rows) + (o.options.mode == 'show' ? 0 : (i - Math.floor(rows / 2)) * (height / rows)),
            opacity: o.options.mode == 'show' ? 1 : 0
          }, o.duration || 500);
        }
      }

      // Set a timeout, to call the callback approx. when the other animations have finished
      setTimeout(function () {

        o.options.mode == 'show' ? el.css({
          visibility: 'visible'
        }) : el.css({
          visibility: 'visible'
        }).hide();
        if (o.callback) o.callback.apply(el[0]); // Callback
        el.dequeue();

        $('div.ui-effects-explode').remove();

      }, o.duration || 500);


    });

  };

})(jQuery);
/*
 * jQuery UI Effects Fold 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Fold
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.fold = function (o) {

    return this.queue(function () {

      // Create element
      var el = $(this),
      props = ['position', 'top', 'left'];

      // Set options
      var mode = $.effects.setMode(el, o.options.mode || 'hide'); // Set Mode
      var size = o.options.size || 15; // Default fold size
      var horizFirst = !(!o.options.horizFirst); // Ensure a boolean value
      var duration = o.duration ? o.duration / 2 : $.fx.speeds._default / 2;

      // Adjust
      $.effects.save(el, props);
      el.show(); // Save & Show
      var wrapper = $.effects.createWrapper(el).css({
        overflow: 'hidden'
      }); // Create Wrapper
      var widthFirst = ((mode == 'show') != horizFirst);
      var ref = widthFirst ? ['width', 'height'] : ['height', 'width'];
      var distance = widthFirst ? [wrapper.width(), wrapper.height()] : [wrapper.height(), wrapper.width()];
      var percent = /([0-9]+)%/.exec(size);
      if (percent) size = parseInt(percent[1], 10) / 100 * distance[mode == 'hide' ? 0 : 1];
      if (mode == 'show') wrapper.css(horizFirst ? {
        height: 0,
        width: size
      } : {
        height: size,
        width: 0
      }); // Shift
      // Animation
      var animation1 = {},
      animation2 = {};
      animation1[ref[0]] = mode == 'show' ? distance[0] : size;
      animation2[ref[1]] = mode == 'show' ? distance[1] : 0;

      // Animate
      wrapper.animate(animation1, duration, o.options.easing).animate(animation2, duration, o.options.easing, function () {
        if (mode == 'hide') el.hide(); // Hide
        $.effects.restore(el, props);
        $.effects.removeWrapper(el); // Restore
        if (o.callback) o.callback.apply(el[0], arguments); // Callback
        el.dequeue();
      });

    });

  };

})(jQuery);
/*
 * jQuery UI Effects Highlight 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Highlight
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.highlight = function (o) {
    return this.queue(function () {
      var elem = $(this),
      props = ['backgroundImage', 'backgroundColor', 'opacity'],
      mode = $.effects.setMode(elem, o.options.mode || 'show'),
      animation = {
        backgroundColor: elem.css('backgroundColor')
      };

      if (mode == 'hide') {
        animation.opacity = 0;
      }

      $.effects.save(elem, props);
      elem.show().css({
        backgroundImage: 'none',
        backgroundColor: o.options.color || '#ffff99'
      }).animate(animation, {
        queue: false,
        duration: o.duration,
        easing: o.options.easing,
        complete: function () {
          (mode == 'hide' && elem.hide());
          $.effects.restore(elem, props);
          (mode == 'show' && !$.support.opacity && this.style.removeAttribute('filter'));
          (o.callback && o.callback.apply(this, arguments));
          elem.dequeue();
        }
      });
    });
  };

})(jQuery);
/*
 * jQuery UI Effects Pulsate 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Pulsate
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.pulsate = function (o) {
    return this.queue(function () {
      var elem = $(this),
      mode = $.effects.setMode(elem, o.options.mode || 'show');
      times = ((o.options.times || 5) * 2) - 1;
      duration = o.duration ? o.duration / 2 : $.fx.speeds._default / 2, isVisible = elem.is(':visible'), animateTo = 0;

      if (!isVisible) {
        elem.css('opacity', 0).show();
        animateTo = 1;
      }

      if ((mode == 'hide' && isVisible) || (mode == 'show' && !isVisible)) {
        times--;
      }

      for (var i = 0; i < times; i++) {
        elem.animate({
          opacity: animateTo
        }, duration, o.options.easing);
        animateTo = (animateTo + 1) % 2;
      }

      elem.animate({
        opacity: animateTo
      }, duration, o.options.easing, function () {
        if (animateTo == 0) {
          elem.hide();
        }(o.callback && o.callback.apply(this, arguments));
      });

      elem.queue('fx', function () {
        elem.dequeue();
      }).dequeue();
    });
  };

})(jQuery);
/*
 * jQuery UI Effects Scale 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Scale
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.puff = function (o) {
    return this.queue(function () {
      var elem = $(this),
      mode = $.effects.setMode(elem, o.options.mode || 'hide'),
      percent = parseInt(o.options.percent, 10) || 150,
      factor = percent / 100,
      original = {
        height: elem.height(),
        width: elem.width()
      };

      $.extend(o.options, {
        fade: true,
        mode: mode,
        percent: mode == 'hide' ? percent : 100,
        from: mode == 'hide' ? original : {
          height: original.height * factor,
          width: original.width * factor
        }
      });

      elem.effect('scale', o.options, o.duration, o.callback);
      elem.dequeue();
    });
  };

  $.effects.scale = function (o) {

    return this.queue(function () {

      // Create element
      var el = $(this);

      // Set options
      var options = $.extend(true, {}, o.options);
      var mode = $.effects.setMode(el, o.options.mode || 'effect'); // Set Mode
      var percent = parseInt(o.options.percent, 10) || (parseInt(o.options.percent, 10) == 0 ? 0 : (mode == 'hide' ? 0 : 100)); // Set default scaling percent
      var direction = o.options.direction || 'both'; // Set default axis
      var origin = o.options.origin; // The origin of the scaling
      if (mode != 'effect') { // Set default origin and restore for show/hide
        options.origin = origin || ['middle', 'center'];
        options.restore = true;
      }
      var original = {
        height: el.height(),
        width: el.width()
      }; // Save original
      el.from = o.options.from || (mode == 'show' ? {
        height: 0,
        width: 0
      } : original); // Default from state
      // Adjust
      var factor = { // Set scaling factor
        y: direction != 'horizontal' ? (percent / 100) : 1,
        x: direction != 'vertical' ? (percent / 100) : 1
      };
      el.to = {
        height: original.height * factor.y,
        width: original.width * factor.x
      }; // Set to state
      if (o.options.fade) { // Fade option to support puff
        if (mode == 'show') {
          el.from.opacity = 0;
          el.to.opacity = 1;
        };
        if (mode == 'hide') {
          el.from.opacity = 1;
          el.to.opacity = 0;
        };
      };

      // Animation
      options.from = el.from;
      options.to = el.to;
      options.mode = mode;

      // Animate
      el.effect('size', options, o.duration, o.callback);
      el.dequeue();
    });

  };

  $.effects.size = function (o) {

    return this.queue(function () {

      // Create element
      var el = $(this),
      props = ['position', 'top', 'left', 'width', 'height', 'overflow', 'opacity'];
      var props1 = ['position', 'top', 'left', 'overflow', 'opacity']; // Always restore
      var props2 = ['width', 'height', 'overflow']; // Copy for children
      var cProps = ['fontSize'];
      var vProps = ['borderTopWidth', 'borderBottomWidth', 'paddingTop', 'paddingBottom'];
      var hProps = ['borderLeftWidth', 'borderRightWidth', 'paddingLeft', 'paddingRight'];

      // Set options
      var mode = $.effects.setMode(el, o.options.mode || 'effect'); // Set Mode
      var restore = o.options.restore || false; // Default restore
      var scale = o.options.scale || 'both'; // Default scale mode
      var origin = o.options.origin; // The origin of the sizing
      var original = {
        height: el.height(),
        width: el.width()
      }; // Save original
      el.from = o.options.from || original; // Default from state
      el.to = o.options.to || original; // Default to state
      // Adjust
      if (origin) { // Calculate baseline shifts
        var baseline = $.effects.getBaseline(origin, original);
        el.from.top = (original.height - el.from.height) * baseline.y;
        el.from.left = (original.width - el.from.width) * baseline.x;
        el.to.top = (original.height - el.to.height) * baseline.y;
        el.to.left = (original.width - el.to.width) * baseline.x;
      };
      var factor = { // Set scaling factor
        from: {
          y: el.from.height / original.height,
          x: el.from.width / original.width
        },
        to: {
          y: el.to.height / original.height,
          x: el.to.width / original.width
        }
      };
      if (scale == 'box' || scale == 'both') { // Scale the css box
        if (factor.from.y != factor.to.y) { // Vertical props scaling
          props = props.concat(vProps);
          el.from = $.effects.setTransition(el, vProps, factor.from.y, el.from);
          el.to = $.effects.setTransition(el, vProps, factor.to.y, el.to);
        };
        if (factor.from.x != factor.to.x) { // Horizontal props scaling
          props = props.concat(hProps);
          el.from = $.effects.setTransition(el, hProps, factor.from.x, el.from);
          el.to = $.effects.setTransition(el, hProps, factor.to.x, el.to);
        };
      };
      if (scale == 'content' || scale == 'both') { // Scale the content
        if (factor.from.y != factor.to.y) { // Vertical props scaling
          props = props.concat(cProps);
          el.from = $.effects.setTransition(el, cProps, factor.from.y, el.from);
          el.to = $.effects.setTransition(el, cProps, factor.to.y, el.to);
        };
      };
      $.effects.save(el, restore ? props : props1);
      el.show(); // Save & Show
      $.effects.createWrapper(el); // Create Wrapper
      el.css('overflow', 'hidden').css(el.from); // Shift
      // Animate
      if (scale == 'content' || scale == 'both') { // Scale the children
        vProps = vProps.concat(['marginTop', 'marginBottom']).concat(cProps); // Add margins/font-size
        hProps = hProps.concat(['marginLeft', 'marginRight']); // Add margins
        props2 = props.concat(vProps).concat(hProps); // Concat
        el.find("*[width]").each(function () {
          child = $(this);
          if (restore) $.effects.save(child, props2);
          var c_original = {
            height: child.height(),
            width: child.width()
          }; // Save original
          child.from = {
            height: c_original.height * factor.from.y,
            width: c_original.width * factor.from.x
          };
          child.to = {
            height: c_original.height * factor.to.y,
            width: c_original.width * factor.to.x
          };
          if (factor.from.y != factor.to.y) { // Vertical props scaling
            child.from = $.effects.setTransition(child, vProps, factor.from.y, child.from);
            child.to = $.effects.setTransition(child, vProps, factor.to.y, child.to);
          };
          if (factor.from.x != factor.to.x) { // Horizontal props scaling
            child.from = $.effects.setTransition(child, hProps, factor.from.x, child.from);
            child.to = $.effects.setTransition(child, hProps, factor.to.x, child.to);
          };
          child.css(child.from); // Shift children
          child.animate(child.to, o.duration, o.options.easing, function () {
            if (restore) $.effects.restore(child, props2); // Restore children
          }); // Animate children
        });
      };

      // Animate
      el.animate(el.to, {
        queue: false,
        duration: o.duration,
        easing: o.options.easing,
        complete: function () {
          if (el.to.opacity === 0) {
            el.css('opacity', el.from.opacity);
          }
          if (mode == 'hide') el.hide(); // Hide
          $.effects.restore(el, restore ? props : props1);
          $.effects.removeWrapper(el); // Restore
          if (o.callback) o.callback.apply(this, arguments); // Callback
          el.dequeue();
        }
      });

    });

  };

})(jQuery);
/*
 * jQuery UI Effects Shake 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Shake
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.shake = function (o) {

    return this.queue(function () {

      // Create element
      var el = $(this),
      props = ['position', 'top', 'left'];

      // Set options
      var mode = $.effects.setMode(el, o.options.mode || 'effect'); // Set Mode
      var direction = o.options.direction || 'left'; // Default direction
      var distance = o.options.distance || 20; // Default distance
      var times = o.options.times || 3; // Default # of times
      var speed = o.duration || o.options.duration || 140; // Default speed per shake
      // Adjust
      $.effects.save(el, props);
      el.show(); // Save & Show
      $.effects.createWrapper(el); // Create Wrapper
      var ref = (direction == 'up' || direction == 'down') ? 'top' : 'left';
      var motion = (direction == 'up' || direction == 'left') ? 'pos' : 'neg';

      // Animation
      var animation = {},
      animation1 = {},
      animation2 = {};
      animation[ref] = (motion == 'pos' ? '-=' : '+=') + distance;
      animation1[ref] = (motion == 'pos' ? '+=' : '-=') + distance * 2;
      animation2[ref] = (motion == 'pos' ? '-=' : '+=') + distance * 2;

      // Animate
      el.animate(animation, speed, o.options.easing);
      for (var i = 1; i < times; i++) { // Shakes
        el.animate(animation1, speed, o.options.easing).animate(animation2, speed, o.options.easing);
      };
      el.animate(animation1, speed, o.options.easing).
      animate(animation, speed / 2, o.options.easing, function () { // Last shake
        $.effects.restore(el, props);
        $.effects.removeWrapper(el); // Restore
        if (o.callback) o.callback.apply(this, arguments); // Callback
      });
      el.queue('fx', function () {
        el.dequeue();
      });
      el.dequeue();
    });

  };

})(jQuery);
/*
 * jQuery UI Effects Slide 1.8.4
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Effects/Slide
 *
 * Depends:
 *	jquery.effects.core.js
 */
(function ($, undefined) {

  $.effects.slide = function (o) {

    return this.queue(function () {

      // Create element
      var el = $(this),
      props = ['position', 'top', 'left'];

      // Set options
      var mode = $.effects.setMode(el, o.options.mode || 'show'); // Set Mode
      var direction = o.options.direction || 'left'; // Default Direction
      // Adjust
      $.effects.save(el, props);
      el.show(); // Save & Show
      $.effects.createWrapper(el).css({
        overflow: 'hidden'
      }); // Create Wrapper
      var ref = (direction == 'up' || direction == 'down') ? 'top' : 'left';
      var motion = (direction == 'up' || direction == 'left') ? 'pos' : 'neg';
      var distance = o.options.distance || (ref == 'top' ? el.outerHeight({
        margin: true
      }) : el.outerWidth({
        margin: true
      }));
      if (mode == 'show') el.css(ref, motion == 'pos' ? -distance : distance); // Shift
      // Animation
      var animation = {};
      animation[ref] = (mode == 'show' ? (motion == 'pos' ? '+=' : '-=') : (motion == 'pos' ? '-=' : '+=')) + distance;

      // Animate
      el.animate(animation, {
        queue: false,
        duration: o.duration,
        easing: o.options.easing,
        complete: function () {
          if (mode == 'hide') el.hide(); // Hide
          $.effects.restore(el, props);
          $.effects.removeWrapper(el); // Restore
          if (o.callback) o.callback.apply(this, arguments); // Callback
          el.dequeue();
        }
      });

    });

  };

})(jQuery);


(function ($) {
  $.alerts = {
    verticalOffset: -75,
    horizontalOffset: 0,
    repositionOnResize: true,
    overlayOpacity: .01,
    overlayColor: '#FFF',
    draggable: true,
    okButton: '&nbsp;Aceptar&nbsp;',
    cancelButton: '&nbsp;Cancelar&nbsp;',
    dialogClass: null,
    alert: function (message, title, callback) {
      if (title == null) title = 'Alerta';
      $.alerts._show(title, message, null, 'alert', function (result) {
        if (callback) callback(result);
      });
    },
    confirm: function (message, title, callback) {
      if (title == null) title = 'Confirmaci�n';
      $.alerts._show(title, message, null, 'confirm', function (result) {
        if (callback) callback(result);
      });
    },
    prompt: function (message, value, title, callback) {
      if (title == null) title = 'Pregunta';
      $.alerts._show(title, message, value, 'prompt', function (result) {
        if (callback) callback(result);
      });
    },
    _show: function (title, msg, value, type, callback) {
      $.alerts._hide();
      $.alerts._overlay('show');
      $("BODY").append('<div id="popup_container">' + '<h1 id="popup_title"></h1>' + '<div id="popup_content">' + '<div id="popup_message"></div>' + '</div>' + '</div>');
      if ($.alerts.dialogClass) $("#popup_container").addClass($.alerts.dialogClass);
      var pos = ($.browser.msie && parseInt($.browser.version) <= 6) ? 'absolute' : 'fixed';
      $("#popup_container").css({
        position: pos,
        zIndex: 99999,
        padding: 0,
        margin: 0
      });
      $("#popup_title").text(title);
      $("#popup_content").addClass(type);
      $("#popup_message").text(msg);
      $("#popup_message").html($("#popup_message").text().replace(/\n/g, '<br />'));
      $("#popup_container").css({
        minWidth: $("#popup_container").outerWidth(),
        maxWidth: $("#popup_container").outerWidth()
      });
      $.alerts._reposition();
      $.alerts._maintainPosition(true);
      switch (type) {
        case 'alert':
          $("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /></div>');
          $("#popup_ok").click(function () {
            $.alerts._hide();
            callback(true);
          });
          $("#popup_ok").focus().keypress(function (e) {
            if (e.keyCode == 13 || e.keyCode == 27) $("#popup_ok").trigger('click');
          });
          break;
        case 'confirm':
          $("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
          $("#popup_ok").click(function () {
            $.alerts._hide();
            if (callback) callback(true);
          });
          $("#popup_cancel").click(function () {
            $.alerts._hide();
            if (callback) callback(false);
          });
          $("#popup_ok").focus();
          $("#popup_ok, #popup_cancel").keypress(function (e) {
            if (e.keyCode == 13) $("#popup_ok").trigger('click');
            if (e.keyCode == 27) $("#popup_cancel").trigger('click');
          });
          break;
        case 'prompt':
          $("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
          $("#popup_prompt").width($("#popup_message").width());
          $("#popup_ok").click(function () {
            var val = $("#popup_prompt").val();
            $.alerts._hide();
            if (callback) callback(val);
          });
          $("#popup_cancel").click(function () {
            $.alerts._hide();
            if (callback) callback(null);
          });
          $("#popup_prompt, #popup_ok, #popup_cancel").keypress(function (e) {
            if (e.keyCode == 13) $("#popup_ok").trigger('click');
            if (e.keyCode == 27) $("#popup_cancel").trigger('click');
          });
          if (value) $("#popup_prompt").val(value);
          $("#popup_prompt").focus().select();
          break;
      }
      if ($.alerts.draggable) {
        try {
          $("#popup_container").draggable({
            handle: $("#popup_title")
          });
          $("#popup_title").css({
            cursor: 'move'
          });
        } catch (e) {}
      }
    },
    _hide: function () {
      $("#popup_container").remove();
      $.alerts._overlay('hide');
      $.alerts._maintainPosition(false);
    },
    _overlay: function (status) {
      switch (status) {
        case 'show':
          $.alerts._overlay('hide');
          $("BODY").append('<div id="popup_overlay"></div>');
          $("#popup_overlay").css({
            position: 'absolute',
            zIndex: 99998,
            top: '0px',
            left: '0px',
            width: '100%',
            height: $(document).height(),
            background: $.alerts.overlayColor,
            opacity: $.alerts.overlayOpacity
          });
          break;
        case 'hide':
          $("#popup_overlay").remove();
          break;
      }
    },
    _reposition: function () {
      var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
      var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
      if (top < 0) top = 0;
      if (left < 0) left = 0;
      if ($.browser.msie && parseInt($.browser.version) <= 6) top = top + $(window).scrollTop();
      $("#popup_container").css({
        top: top + 'px',
        left: left + 'px'
      });
      $("#popup_overlay").height($(document).height());
    },
    _maintainPosition: function (status) {
      if ($.alerts.repositionOnResize) {
        switch (status) {
          case true:
            $(window).bind('resize', $.alerts._reposition);
            break;
          case false:
            $(window).unbind('resize', $.alerts._reposition);
            break;
        }
      }
    }
  }
  jAlert = function (message, title, callback) {
    $.alerts.alert(message, title, callback);
  }
  jConfirm = function (message, title, callback) {
    $.alerts.confirm(message, title, callback);
  };
  jPrompt = function (message, value, title, callback) {
    $.alerts.prompt(message, value, title, callback);
  };
})(jQuery);

/**
 * hoverIntent r5 // 2007.03.27 // jQuery 1.1.2+
 * <http://cherne.net/brian/resources/jquery.hoverIntent.html>
 *
 * @param  f  onMouseOver function || An object with configuration options
 * @param  g  onMouseOut function  || Nothing (use configuration options object)
 * @author    Brian Cherne <brian@cherne.net>
 */
(function ($) {
  $.fn.hoverIntent = function (f, g) {
    var cfg = {
      sensitivity: 7,
      interval: 100,
      timeout: 0
    };
    cfg = $.extend(cfg, g ? {
      over: f,
      out: g
    } : f);
    var cX, cY, pX, pY;
    var track = function (ev) {
      cX = ev.pageX;
      cY = ev.pageY;
    };
    var compare = function (ev, ob) {
      ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
      if ((Math.abs(pX - cX) + Math.abs(pY - cY)) < cfg.sensitivity) {
        $(ob).unbind("mousemove", track);
        ob.hoverIntent_s = 1;
        return cfg.over.apply(ob, [ev]);
      } else {
        pX = cX;
        pY = cY;
        ob.hoverIntent_t = setTimeout(function () {
          compare(ev, ob);
        }, cfg.interval);
      }
    };
    var delay = function (ev, ob) {
      ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
      ob.hoverIntent_s = 0;
      return cfg.out.apply(ob, [ev]);
    };
    var handleHover = function (e) {
      var p = (e.type == "mouseover" ? e.fromElement : e.toElement) || e.relatedTarget;
      while (p && p != this) {
        try {
          p = p.parentNode;
        } catch (e) {
          p = this;
        }
      }
      if (p == this) {
        return false;
      }
      var ev = jQuery.extend({}, e);
      var ob = this;
      if (ob.hoverIntent_t) {
        ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
      }
      if (e.type == "mouseover") {
        pX = ev.pageX;
        pY = ev.pageY;
        $(ob).bind("mousemove", track);
        if (ob.hoverIntent_s != 1) {
          ob.hoverIntent_t = setTimeout(function () {
            compare(ev, ob);
          }, cfg.interval);
        }
      } else {
        $(ob).unbind("mousemove", track);
        if (ob.hoverIntent_s == 1) {
          ob.hoverIntent_t = setTimeout(function () {
            delay(ev, ob);
          }, cfg.timeout);
        }
      }
    };
    return this.mouseover(handleHover).mouseout(handleHover);
  };
})(jQuery);

/*
 * jQuery.validity v1.0.3
 * http://validity.thatscaptaintoyou.com/
 * http://code.google.com/p/validity/
 *
 * Copyright (c) 2010 Wyatt Allen
 * Dual licensed under the MIT and GPL licenses.
 *
 * Date: 2009-2-16 (Tuesday, 16 February 2010)
 * Revision: 132
 */
(function ($) {
  var defaults = {
    outputMode: "modal",
    scrollTo: false,
    modalErrorsClickable: true,
    defaultFieldName: "Este campo",
    elementSupport: ":text, :password, textarea, select, :radio, :checkbox",
    argToString: function (val) {
      return val.getDate ? (val.getMonth() + 1) + "/" + val.getDate() + "/" + val.getFullYear() : val;
    }
  };
  $.validity = {
    settings: $.extend(defaults, {}),
    patterns: {
      integer: /^\d+$/,
      date: /^\d{1,4}-([012]?\d|30|31)-([01]?\d)$/,
      email: /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,
      number: /^[+-]?(\d+(\.\d*)?|\.\d+)([Ee]\d+)?$/,
      time12: /^[01]?\d:[0-5]\d?\s?[aApP]\.?[mM]\.?$/,
      time24: /^(20|21|22|23|[01]\d|\d)(([:][0-5]\d){1,2})$/,
      nonHtml: /^[^<>]*$/
    },
    messages: {
      require: "#{field} es obligatorio.",
      match: "#{field} es invalido.",
      integer: "#{field} debe ser un número.",
      date: "#{field} debe ser una fecha.",
      email: "#{field} es un correo inválido.",
      usd: "#{field} es invalido.",
      url: "#{field} es una URL inválida.",
      number: "#{field} debe ser numérico.",
      zip: "#{field} es invalido",
      phone: "#{field} must be formatted as a phone number ###-###-####.",
      guid: "#{field} es un GUID invalido",
      time24: "#{field} debe ser una hora válida",
      time12: "#{field} debe ser una hora válida: 12:00 AM/PM",
      lessThan: "#{field} debe ser menor que #{max}.",
      lessThanOrEqualTo: "#{field} debe ser menor o igual que #{max}.",
      greaterThan: "#{field} debe ser mayor #{min}.",
      greaterThanOrEqualTo: "#{field} debe ser mayor o igual que #{min}.",
      range: "#{field} debe estar entre #{min} y #{max}.",
      tooLong: "#{field} no puede ser superior a #{max} carácteres.",
      tooShort: "#{field} debe ser superior a #{min} carácteres.",
      equal: "Valor inválido.",
      distinct: "Este valor está repetido.",
      sum: "Los valores deben sumar #{sum}.",
      sumMax: "La suman debe ser inferior a #{max}.",
      sumMin: "La suma debe ser superior a #{min}.",
      nonHtml: "Carácteres No Válidos.",
      generic: "Dato Inválido"
    },
    outputs: {},
    setup: function (options) {
      this.settings = $.extend(this.settings, options);
    },
    report: null,
    isValidating: function () {
      return !!this.report;
    },
    start: function () {
      if (this.outputs[this.settings.outputMode] && this.outputs[this.settings.outputMode].start) {
        this.outputs[this.settings.outputMode].start();
      }
      $('input, select, textarea').removeData('hasError');
      this.report = {
        errors: 0,
        valid: true
      };
    },
    end: function () {
      var results = this.report || {
        errors: 0,
        valid: true
      };
      this.report = null;
      if (this.outputs[this.settings.outputMode] && this.outputs[this.settings.outputMode].end) {
        this.outputs[this.settings.outputMode].end(results);
      }
      return results;
    },
    clear: function () {
      this.start();
      this.end();
    }
  };
  $.fn.extend({
    validity: function (arg) {
      return this.each(function () {
        if (this.tagName.toLowerCase() == "form") {
          var f = null;
          if (typeof(arg) == "string") {
            f = function () {
              $(arg).require();
            };
          } else if ($.isFunction(arg)) {
            f = arg;
          }
          if (arg) {
            $(this).bind("submit", function () {
              $.validity.start();
              f();
              return $.validity.end().valid;
            });
          }
        }
      });
    },
    require: function (msg) {
      return validate(this, function (obj) {
        return obj.value.length;
      }, msg || $.validity.messages.require);
    },
    match: function (rule, msg) {
      if (!msg) {
        msg = $.validity.messages.match;
        if (typeof(rule) === "string" && $.validity.messages[rule]) {
          msg = $.validity.messages[rule];
        }
      }
      if (typeof(rule) == "string") {
        rule = $.validity.patterns[rule];
      }
      return validate(this, $.isFunction(rule) ?
        function (obj) {
          return !obj.value.length || rule(obj.value);
        } : function (obj) {
          if (rule.global) {
            rule.lastIndex = 0;
          }
          return !obj.value.length || rule.test(obj.value);
        }, msg);
    },
    range: function (min, max, msg) {
      return validate(this, min.getTime && max.getTime ?
        function (obj) {
          var d = new Date(obj.value);
          return !obj.value.length || d >= new Date(min) && d <= new Date(max);
        } : function (obj) {
          var f = parseFloat(obj.value);
          return !obj.value.length || f >= min && f <= max;
        }, msg || format($.validity.messages.range, {
          min: $.validity.settings.argToString(min),
          max: $.validity.settings.argToString(max)
        }));
    },
    greaterThan: function (min, msg) {
      return validate(this, min.getTime ?
        function (obj) {
          ;
          return new Date(obj.value) > min;
        } : function (obj) {
          return parseFloat(obj.value) > min;
        }, msg || format($.validity.messages.greaterThan, {
          min: $.validity.settings.argToString(min)
        }));
    },
    greaterThanOrEqualTo: function (min, msg) {
      return validate(this, min.getTime ?
        function (obj) {
          return new Date(obj.value) >= min;
        } : function (obj) {
          return parseFloat(obj.value) >= min;
        }, msg || format($.validity.messages.greaterThanOrEqualTo, {
          min: $.validity.settings.argToString(min)
        }));
    },
    lessThan: function (max, msg) {
      return validate(this, max.getTime ?
        function (obj) {
          return new Date(obj.value) < max;
        } : function (obj) {
          return parseFloat(obj.value) < max;
        }, msg || format($.validity.messages.lessThan, {
          max: $.validity.settings.argToString(max)
        }));
    },
    lessThanOrEqualTo: function (max, msg) {
      return validate(this, max.getTime ?
        function (obj) {
          return new Date(obj.value) <= max;
        } : function (obj) {
          return parseFloat(obj.value) <= max;
        }, msg || format($.validity.messages.lessThanOrEqualTo, {
          max: $.validity.settings.argToString(max)
        }));
    },
    maxLength: function (max, msg) {
      return validate(this, function (obj) {
        return obj.value.length <= max;
      }, msg || format($.validity.messages.tooLong, {
        max: max
      }));
    },
    minLength: function (min, msg) {
      return validate(this, function (obj) {
        return obj.value.length >= min;
      }, msg || format($.validity.messages.tooShort, {
        min: min
      }));
    },
    equal: function (arg0, arg1) {
      var $reduction = (this.reduction || this).filter($.validity.settings.elementSupport),
      transform = function (val) {
        return val;
      },
      msg = $.validity.messages.equal;
      if ($reduction.length) {
        if ($.isFunction(arg0)) {
          transform = arg0;
          if (typeof(arg1) == "string") {
            msg = arg1;
          }
        } else if (typeof(arg0) == "string") {
          msg = arg0;
        }
        var map = $.map($reduction, function (obj) {
          return transform(obj.value);
        }),
        first = map[0],
        valid = true;
        for (var i in map) {
          if (map[i] != first) {
            valid = false;
          }
        }
        if (!valid) {
          raiseAggregateError($reduction, msg);
          this.reduction = $([]);
        }
      }
      return this;
    },
    distinct: function (arg0, arg1) {
      var $reduction = (this.reduction || this).filter($.validity.settings.elementSupport),
      transform = function (val) {
        return val;
      },
      msg = $.validity.messages.distinct,
      subMap = [],
      valid = true;
      if ($reduction.length) {
        if ($.isFunction(arg0)) {
          transform = arg0;
          if (typeof(arg1) == "string") {
            msg = arg1;
          }
        } else if (typeof(arg0) == "string") {
          msg = arg0;
        }
        var map = $.map($reduction, function (obj) {
          return transform(obj.value);
        });
        for (var i1 = 0; i1 < map.length; i1++) {
          if (map[i1].length) {
            for (var i2 = 0; i2 < subMap.length; i2++) {
              if (subMap[i2] == map[i1]) {
                valid = false;
              }
            }
            subMap.push(map[i1]);
          }
        }
        if (!valid) {
          raiseAggregateError($reduction, msg);
          this.reduction = $([]);
        }
      }
      return this;
    },
    sum: function (sum, msg) {
      var $reduction = (this.reduction || this).filter($.validity.settings.elementSupport);
      if ($reduction.length && sum != numericSum($reduction)) {
        raiseAggregateError($reduction, msg || format($.validity.messages.sum, {
          sum: sum
        }));
        this.reduction = $([]);
      }
      return this;
    },
    sumMax: function (max, msg) {
      var $reduction = (this.reduction || this).filter($.validity.settings.elementSupport);
      if ($reduction.length && max < numericSum($reduction)) {
        raiseAggregateError($reduction, msg || format($.validity.messages.sumMax, {
          max: max
        }));
        this.reduction = $([]);
      }
      return this;
    },
    sumMin: function (min, msg) {
      var $reduction = (this.reduction || this).filter($.validity.settings.elementSupport);
      if ($reduction.length && min < numericSum($reduction)) {
        raiseAggregateError($reduction, msg || format($.validity.messages.sumMin, {
          min: min
        }));
        this.reduction = $([]);
      }
      return this;
    },
    nonHtml: function (msg) {
      return validate(this, function (obj) {
        return $.validity.patterns.nonHtml.test(obj.value);
      }, msg || $.validity.messages.nonHtml);
    },
    assert: function (expression, msg) {
      var $reduction = this.reduction || this;
      if ($reduction.length) {
        if ($.isFunction(expression)) {
          return validate(this, expression, msg || $.validity.messages.generic);
        } else if (!expression) {
          raiseAggregateError($reduction, msg || $.validity.messages.generic);
          this.reduction = $([]);
        }
      }
      return this;
    }
  });

  function validate($obj, regimen, message) {
    var $reduction = ($obj.reduction || $obj).filter($.validity.settings.elementSupport);
    elements = [];
    $reduction.each(function () {
      if ($(this).data('hasError') == true) return true;
      if (regimen(this)) {
        elements.push(this);
      } else {
        raiseError(this, format(message, {
          field: infer(this)
        }));
      }
    });
    $obj.reduction = $(elements);
    return $obj;
  }

  function addToReport() {
    if ($.validity.isValidating()) {
      $.validity.report.errors++;
      $.validity.report.valid = false;
    }
  }

  function raiseError(obj, msg) {
    addToReport();
    $(obj).data('hasError', true);
    if ($.validity.outputs[$.validity.settings.outputMode] && $.validity.outputs[$.validity.settings.outputMode].raise) {
      $.validity.outputs[$.validity.settings.outputMode].raise($(obj), msg);
    }
  }

  function raiseAggregateError(obj, msg) {
    addToReport();
    if ($(obj).data('hasError')) return;
    $(obj).data('hasError', true);
    if ($.validity.outputs[$.validity.settings.outputMode] && $.validity.outputs[$.validity.settings.outputMode].raiseAggregate) {
      $.validity.outputs[$.validity.settings.outputMode].raiseAggregate(obj, msg);
    }
  }

  function numericSum(obj) {
    var accumulator = 0;
    obj.each(function () {
      var n = parseFloat(this.value);
      accumulator += isNaN(n) ? 0 : n;
    });
    return accumulator;
  }

  function format(str, obj) {
    for (var p in obj) {
      str = str.replace("#{" + p + "}", obj[p]);
    }
    return capitalize(str);
  }

  function infer(field) {
    var $f = $(field),
    ret = $.validity.settings.defaultFieldName;
    if ($f.attr("title").length) {
      ret = $f.attr("title");
    } else if (/^([A-Z0-9][a-z]*)+$/.test(field.id)) {
      ret = field.id.replace(/([A-Z0-9])[a-z]*/g, " $&");
    } else if (/^[a-z0-9_]*$/.test(field.id)) {
      var arr = field.id.split("_");
      for (var i = 0; i < arr.length; i++) {
        arr[i] = capitalize(arr[i]);
      }
      ret = arr.join(" ");
    }
    return ret;
  }

  function capitalize(sz) {
    return sz.substring ? sz.substring(0, 1).toUpperCase() + sz.substring(1, sz.length) : sz;
  }
})(jQuery);

(function ($) {
  function getIdentifier($obj) {
    return $obj.attr('id').length ? $obj.attr('id') : $obj.attr('name');
  }
  $.validity.outputs.label = {
    start: function () {
      $("label.error").remove();
    },
    end: function (results) {
      if (!results.valid && $.validity.settings.scrollTo) {
        location.hash = $("label.error:eq(0)").attr('for');
      }
    },
    raise: function ($obj, msg) {
      var labelSelector = "label.error[for='" + getIdentifier($obj) + "']";
      if ($(labelSelector).length) {
        $(labelSelector).text(msg);
      } else {
        $("<label/>").attr("for", getIdentifier($obj)).addClass("error").text(msg).click(function () {
          if ($obj.length) {
            $obj[0].select();
          }
        }).insertAfter($obj);
      }
    },
    raiseAggregate: function ($obj, msg) {
      if ($obj.length) {
        this.raise($($obj.get($obj.length - 1)), msg);
      }
    }
  };
})(jQuery);
(function ($) {
  var errorClass = "validity-modal-msg",
  container = "body";
  $.validity.outputs.modal = {
    start: function () {
      $("." + errorClass).remove();
    },
    end: function (results) {
      if (!results.valid && $.validity.settings.scrollTo) {
        location.hash = $("." + errorClass + ":eq(0)").attr('id');
      }
    },
    raise: function ($obj, msg) {
      if ($obj.length) {
        var off = $obj.offset(),
        obj = $obj.get(0),
        errorStyle = {
          left: parseInt(off.left + $obj.width() + 4, 10) + "px",
          top: parseInt(off.top - 10, 10) + "px"
        };
        $("<div/>").addClass(errorClass).addClass('ui-state-error-text').css(errorStyle).html("<span class='ui-icon ui-icon-alert'></span>" + msg).click($.validity.settings.modalErrorsClickable ?
          function () {
            $(this).remove();
          } : null).appendTo(container);
      }
    },
    raiseAggregate: function ($obj, msg) {
      if ($obj.length) {
        this.raise($($obj.get($obj.length - 1)), msg);
      }
    }
  };
})(jQuery);
(function ($) {
  var container = ".validity-summary-container",
  erroneous = "validity-erroneous",
  errors = "." + erroneous,
  wrapper = "<li/>",
  buffer = [];
  $.validity.outputs.summary = {
    start: function () {
      $(errors).removeClass(erroneous);
      buffer = [];
    },
    end: function (results) {
      $(container).hide().find("ul").html('');
      if (buffer.length) {
        for (var i = 0; i < buffer.length; i++) {
          $(wrapper).text(buffer[i]).appendTo(container + " ul");
        }
        $(container).show();
        if ($.validity.settings.scrollTo) {
          location.hash = $(errors + ":eq(0)").attr("id");
        }
      }
    },
    raise: function ($obj, msg) {
      buffer.push(msg);
      $obj.addClass(erroneous);
    },
    raiseAggregate: function ($obj, msg) {
      this.raise($obj, msg);
    }
  };
})(jQuery);

(function(jQuery)
{
  jQuery.extend({
    notify: function(text, type, options)   {
      var defaults = {
        inEffect: 			{
          opacity: 'show'
        },	// in effect
        inEffectDuration: 	600,				// in effect duration in miliseconds
        stayTime: 			3000,				// time in miliseconds before the item has to disappear
        stay: 				false				// should the notice item stay or not?
      }
			
      // declare varaibles
      var options, noticeWrapAll, noticeItemOuter, noticeItemInner, noticeItemClose;
								
      options 	= jQuery.extend({}, defaults, options);
      type = type || "notice";
      if(type == 'error'){
        text = "<span class='ui-icon ui-icon-alert ui-white-icon' style='float:left; margin-right:3px'></span>"+text;
      }
      noticeWrapAll	= (!jQuery('.ui-notify').length) ? jQuery('<div></div>').addClass('ui-notify').appendTo('body') : jQuery('.ui-notify');
      noticeItemOuter	= jQuery('<div></div>').addClass('ui-notify-message');
      noticeItemInner	= jQuery('<div></div>').hide().addClass(type).appendTo(noticeWrapAll).html('<p>'+text+'</p>').animate(options.inEffect, options.inEffectDuration).wrap(noticeItemOuter);
      noticeItemClose	= jQuery('<div></div>').addClass('ui-notify-close ').prependTo(noticeItemInner).html('<span/>').addClass('ui-icon ui-icon-close ui-white-icon').click(function() {
        jQuery.noticeRemove(noticeItemInner)
      });
			
      // hmmmz, zucht
      if(navigator.userAgent.match(/MSIE 6/i))
      {
        noticeWrapAll.css({
          top: document.documentElement.scrollTop
          });
      }
			
      if(!options.stay)
      {
        setTimeout(function()
        {
          jQuery.noticeRemove(noticeItemInner);
        },
        options.stayTime);
      }
    },
		
    'noticeRemove': function(obj){
      obj.animate({
        opacity: '0'
      }, 600, function()

      {
        obj.parent().animate({
          height: '0px'
        }, 300, function()

        {
          obj.parent().remove();
        });
      });
    }
  });
})(jQuery);
