
var App = {
	'_oControllers': {},
	'controllers':{},
	'createController': function(name){
    name = name.toLowerCase();
		this['_oControllers'][name] = new AppController();
		return this['_oControllers'][name];
	}
};

App.paths = {
	'imgs':'templates/_public/img/',
	'js':'templates/_public/js/',
	'css':'templates/_public/css/'
}
App.constants = {
	'COD_CIUDAD_CALI':'76001',
	'INDEX_FILE': "index.php"
}

App.controllers={}
if(location.href.toURI != undefined)
  App.current_uri = location.href.toURI()

/**
 * Clase AppController.
 */
function AppController(){
	this.__construct();
	if(typeof this.init == 'function')
		this.init();
}

AppController.prototype.__construct = function(){
	this._makeObserver();
	this.Actions = {};
};// fin __construct

AppController.prototype.addAction = function(action, callback){
	this.Actions[action] = callback;
	return this.Actions[action];
}; // fin addAction
AppController.prototype.executeAction = function(action){
	if(typeof this.Actions[action] == "function")
	this.Actions[action].call(this);
}; // fin executeAction
AppController.prototype._makeObserver = function(){
	this.Events = {};
	this.addListener = function(event, callback){
		this.Events[event] = callback;
	}
	this.removeListener = function(event){
		delete this.Events[event];
	}
	this.triggerEvent = function(){
		var events = arguments;
		var _this = this;
		jQuery.each(events, function(){
			var event = this;
			if(typeof _this.Events[event] == "function")
			_this.Events[event].call(_this);	
		});
	}
};// fin _makeObserver



function url_for(){
	var params = {}
	var args_length = arguments.length

	var controller = App.current_uri.getData('controlador');
	var action = App.current_uri.getData('accion');
	if(action == null || action == '')
		action = 'index'
	switch(args_length){
		case 3:
			if(typeof arguments[2] == 'object')
				$.extend(params, arguments[2])
			params.accion = arguments[1]
			params.controlador = arguments[0]
			url = App.constants.INDEX_FILE+"?" + $.param(params)
			return unescape(url)
		case 2:
			if(typeof arguments[1] == 'object')
				return url_for(controller, arguments[0], arguments[1])
			else
				return url_for(arguments[0], arguments[1], {})
		case 1:
			if(typeof arguments[0] == 'object')
				return url_for(controller, action, arguments[0])
			else
				return url_for(controller, arguments[0], {})
		case 0:
			return url_for(controller, action, {})
	}
}

function url_script(jsFile){
	return App.paths.js+"custom/"+jsFile+".js";
}

function zeroPad(num,count){
	var numZeropad = num + '';
	while(numZeropad.length < count) {
		numZeropad = "0" + numZeropad;
	}
	return numZeropad;
}

function isBlank(object){
	if(object == undefined || object == null)
		return true;
	if(typeof object == 'string')
		return ! /\S+/.test(object)
}
	
function $F(selector){
	return $.trim(jQuery(selector).val())
}

function $$(selector,scope){
	if(typeof(scope) == 'undefined')
		return jQuery("#"+selector, scope)
	return jQuery("#"+selector)
}



/**
 * Valida si el valor de una variable es numerico. 
 */
function isNumber(e){
   e = parseFloat(e)
   return !isNaN(e)
}

function log(){
	if(typeof console == undefined)
		return false;
	console.log.apply(console, arguments);
}

Array.prototype.toSelect = function(){
	var html = "";
	$.each(this, function(idx, value){
		var values = []
		if($.isArray(value)){
			values = value
			if(value.length == 1)
				values[1] = value[0]
		}else if(typeof value == 'object'){
			values = Object.values(value);
		}
		html +="<option value='"+values[0]+"'>"+values[1]+"</option>\n";
	})
	return html;	
};


(function($){
	$.extend(
		$.expr[':'],
		{
			blank: function(a){
				if($(a).is('select'))
					return $(a).val() == '-1'
				else
					return $.trim($(a).val()) == ''
			},
			field: function (a){
				return $(a).is('input')||$(a).is('select')
			}
		}
	)

	/**
	 * Muestra una imagen de "Procesando".
	 * Util para indicar que se esta enviando una solicitud por Ajax.
	 */
	$.fn.ajax_img = function(options){
		options = options || {}
			
		img = options['image'] || 'ajax-loader-ring.gif'
		text = options['text'] === undefined ? 'Procesando...': options['text'];
		html = "<div class='wrapper-loading-ajax'><img class='loading-ajax' src='"+App.paths.imgs+img+"' />";
		if(!isBlank(text))html += "<p>"+text+"</p>";
		html +="</div>";
		return $(this).html(html).css('text-align', 'center').show();
	};
	
	$.fn.id = function(){
		return $(this).attr("id")
	}

	$.fn.setChecked = function(bChecked){
		if(bChecked)
			return $(this).attr("checked", "checked")
		else
			return $(this).removeAttr("checked")
	}
	
	$.addStyleSheet = function(module,cssFile){
	var $ = document; // shortcut
		if (!$.getElementById(cssFile))
		{
				var head  = $.getElementsByTagName('head')[0];
				var link  = $.createElement('link');
				link.id   = cssFile;
				link.rel  = 'stylesheet';
				link.type = 'text/css';
				link.href = 'modules/'+module+"/templates/"+cssFile+'.css';
				link.media = 'all';
				head.appendChild(link);
		}
	}
	
	$.fn.scrollToMe = function(){
		$("html,body").animate({scrollTop: $(this).offset().top},'slow')
	}
	$.fn.reset = function () {
		$(this).find("input").each(function(){this.value=""})
	}

	$.fn.enable = function(){
		return $(this).removeAttr("disabled")
	}
	$.fn.disable = function(){
		return $(this).attr('disabled', 'disabled')
	}
	$.fn.setEnabled = function(enabled){
		if(enabled)
			return $(this).enable()
		else
			return $(this).disable()
	}
	$.fn.toggleEnabled = function(){
		var enabled = $(this).is(":enabled")
		return $(this).setEnabled(!enabled)
	}
	$.fn.getColumn = function(iCol, sSelectorFilter){
		if(!$(this).is("table"))
			return null;
		if(typeof iCol == "undefined")
			throw "ArgumentError: el indice de la columna debe ser un numero."
		if(typeof sSelectorFilter == 'undefined')
			sSelectorFilter = '';
		var aCol = []
		$("tbody tr"+sSelectorFilter, this).each(function(){
			aCol.push($("th, td",this).filter(":eq("+iCol+")").text())
		})
		return aCol;
	}
	$.fn.processingIcon = function(operation, icon){
		icon = icon || "ui-loading-longbar";
		switch(operation){
			case "show": 
				if($(this).is(".ui-dialog")){
					var buttonPane = jQuery(this).find(".ui-dialog-buttonpane")
					if(jQuery(".ui-loading-icon",buttonPane).length > 0) return false;
					jQuery("<div/>").addClass("left-icon ui-loading-icon "+icon).appendTo(buttonPane);
				}
				break;
			case "remove":
				if($(this).is(".ui-dialog")){
					jQuery(this).find(".ui-dialog-buttonpane .ui-loading-icon").remove()
				}
				break;
		}
		
	}
	$.waitLoading = {
		show: function(object, options){
			options = options || {}
			options.image = options.image || "ajax-loader.gif";
			$object = jQuery(object)
			objectOffset = $object.offset();
			$object.hide()
			icon = jQuery("<span class='loading-icon'/>").html("<img src='"+App.paths.imgs+options.image+"'/>").css(objectOffset).insertAfter(object)
		},
		close: function(object){
			jQuery(object).show().next().remove();
		}
	},
	
	$.fn.tooltip = function(text, title){
		var o = $(this)
		var tpl = "<div class='ui-tooltip'>"
		if(title != undefined){
			tpl += "<h1 class='ui-tooltip-title'>"+title+"</h1>";
		}
		text = text || o.attr("title");
		o.removeAttr("title");
		tpl +="<div class='ui-tooltip-message'>"+text+"</div>";
		tpl += "</div>";
		
		var tooltip = jQuery(tpl).appendTo(o).hide()
		
		var fnMouseIn = function(){tooltip.show();}
		var fnMouseOut = function(){tooltip.hide();}		
		var fnMouseMove = function(ev){tooltip.offset({top:ev.pageY+15, left:ev.pageX+15})}

		return o.hover(fnMouseIn, fnMouseOut).mousemove(fnMouseMove);
	}
	
	$.fn.vmenu = function(target){
		return $(this).click(function(){
			$(target).slideToggle();
		});
	}
	
	$.wDialog = function(action){
		switch(action){
			case 'close': 
				$("#w-dialog").remove(); 
				break;
			case 'show':
				$("<div id='w-dialog'><img src='"+App.paths.imgs+"ajax-loader-tinybar.gif' alt='Procesando'/><br/>Procesando...</div>")
				.insertAfter("body")
				break;
		}
	};
})(jQuery)

//
PNAT = {
	fnPoblar: function(element, oSettings){
		if(typeof oSettings == 'undefined')
			throw "ArgumentError: Se Requiere la URL y el objeto."
		var oForm = $(element).parents("form, .ui-form")
		var sUrl = oSettings.url
		var sSelector = oSettings.selector
   
		var oParams = oSettings.params
		if(typeof oParams == 'undefined' && typeof PNAT.oParams == 'object')
			oParams = PNAT.oParams[sSelector]
		if($(sSelector).hasClass('with-extra') && typeof oParams == 'undefined')
			oParams = {'extra':{'0': 'TODOS'}}
		if(typeof oParams == 'undefined')
			oParams = {}
		$.extend(oParams, {
			'cod_programa':$F(element)
			})
	var fnSuccess = function(json){
		$(sSelector, oForm).html(json.toSelect())
	}

	$.ajax({'url':sUrl, 'data':oParams, 'success':fnSuccess, "error": function(){console.log(arguments)}, 'global':false, 'dataType':'json'})
	return false;
}
}
