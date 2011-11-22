/* ***SCRIPT*********/

function executeControllerAction(){
	var current_uri = location.href.toURI()
	var controller = current_uri.getData('controlador');
	if(controller == null)
		return false;
	var action = current_uri.getData('accion') || "index";
	if(action == '')
		action = 'index';
	if(App._oControllers[controller] != undefined && jQuery.isFunction(App._oControllers[controller].Actions[action]))
		App._oControllers[controller].Actions[action].call(App._oControllers[controller]);
		
	var controllerName = controller.camelize()+"Controller";
	if(App[controllerName] == undefined)
		return false;
	
	if(!jQuery.isFunction(App[controllerName][action]))
		return false;
	App[controllerName][action]();
	
	
}

function setup(){
   $('a[href=#top], .toTop').click(function(){
       $('html, body').animate({scrollTop:0}, 'slow');
        return false;
    });

	$('body').ajaxSend(function(e, xhr, settings) {
		if (settings.dataType == 'script') {
			settings.cache = false;
		}
	});
  
  $("body").ajaxError(function(e, xhr, settings, exception){
  	var errorMessage = {};
  	var genericErrorMessage = "<p>Un error ha ocurrido al intentar acceder a:\n<strong><em>"+settings.url+"</em></strong></p>";

  	switch(xhr.status){
  		case 404: 
  			errorMessage.title = "Recurso No Hallado";
  			errorMessage.text = "";
  			break;
  		case 403: 
  			errorMessage.title ="Acceso Restringido";
  			errorMessage.text ="<p>Usted no está autorizado para acceder a esta página.\n"+
  			 											"Es posible que se haya vencido su sesion.\n"+
  			 											"Por favor, Intente recargando la página!.\n</p>";
  			break;  			
  		case 200:
				errorMessage.title = "Error Desconocido /";
				errorMessage.text = "<p class='ui-state-error'>"+exception.toString().substr(0, 80)+"...</p>"
				break;
  		default:
	  		errorMessage.title ="Error Desconocido";
	  		errorMessage.text = "";
  	}
  	errorText = "<h2 class='ui-state-error-text border-bottom'>"+errorMessage.title+"</h2>"
  	errorText +="<div>"+genericErrorMessage+"</div>"
  	errorText +="<div>"+errorMessage.text||""+"</div>\n"
  	if(xhr.status != 200){
			errorText +="<div class='ui-state-error'>"+
										"<div><label>C&oacute;digo del Error:</label><span>"+xhr.status+"</span></div>"+
										"<div><label>Nombre del Error:</label><span>"+xhr.statusText+"</span></div>"+
									"</div>";
  	}
    jAlert(errorText, "Error - "+errorMessage.title)
    
    if(typeof console != 'undefined'){
    	console.log(e, xhr, settings, exception)
    }
    	
  })
  
  $(".tooltip").tooltip();
  
	if($.fn.multiselect != undefined)
		$("select.multiselect").multiselect()
  
  if($("input.date:not(.hasDatepicker)").length >0 && jQuery.fn.datepicker != undefined)
  	$("input.date:not(.hasDatepicker)").attr('readonly','readonly').datepicker();	
  	
  if($(".tabs").length > 0 && jQuery.fn.tabs != undefined)
  	$(".tabs").tabs()
  if(jQuery.fn.buttonset != undefined && jQuery(".user-buttonset").length > 0)
  	jQuery(".user-buttonset").buttonset();
  	
  $(".link-print").click(function(){window.print(); return false;})
  
  $(".toggle-icon-cell span.ui-icon").click(function(){
		if($(this).hasClass("ui-icon-plusthick"))
			$(this).removeClass('ui-icon-plusthick').addClass('ui-icon-minusthick')
		else
			$(this).removeClass('ui-icon-minusthick').addClass('ui-icon-plusthick')
		return false;
	});
	if(typeof jQuery.fn.dataTable !== "undefined")
		$("table.dataTable").each(function(){
      
			if(!$(this).data('hasDataTable'))
				$(this).dataTable();
	});
}
 
 COD_TIPO_PERSONA ={
	 'ESTUDIANTE': 1,
	 'DOCENTE': 2,
	 'MONITOR': 3
 }
 
 COD_ESTADO ={
	 'ACTIVO': 11,
	 'INACTIVO': 12,
	 'EGRESADO':13
 }
 
 BusquedaPorApellido={
	config:{
		dialog: {
			autoOpen:false, width: 600, title: "B\u00FAsqueda Por Apellido",
			afterOpen: function(){
				$("#q", this).focus()
			},
			close: function(){
				$("#ajax-porApellidos, #q", "#form-buscarPorApellido").html("");
				$("#q", "#form-buscarPorApellido").val("");
			},
		cod_tipo_per:null,
		cod_programa:null
		}
	},
	clickOnRow: function(){
		$(".row-buscarPorApellido").click(function(){
			var cedula = $("td:first", this).text()
			$("#input-buscarPorCedula").val(cedula)
			$("#form-buscarPorApellido").dialog('close')
		})
	},
	setup: function(){
		$("#form-buscarPorApellido").dialog(BusquedaPorApellido.config.dialog);
		
		$(".link-buscarPorApellido").click(function(){
			$("#form-buscarPorApellido").dialog('open')
			return false;
		})
		
		$("#bt-buscarPorApellido").click(function(){
			if($F("#q", "#form-buscarPorApellido").length < 4)
				return false;
			$("#ajax-porApellidos").ajax_img()
			$.ajax({
				url: url_for('personas','buscarPorApellido'),
				data: {
					'q': $F("#q", "#form-buscarPorApellido"),
					'cod_tipo_per': BusquedaPorApellido.config.cod_tipo_per,
					'cod_programa': BusquedaPorApellido.config.cod_programa,
					'cod_estado': BusquedaPorApellido.config.cod_estado
				},
				globals: false,
				success: function(html){
					$("#ajax-porApellidos").html(html); 
					if(typeof $.fn.dataTable != 'undefined')
						$(".dataTable").dataTable();
					BusquedaPorApellido.clickOnRow()
				}
			})
			return false;
		})
		$(".button-search", ".form-buscarPersona").click(function(){
			var cedula = $(".cedula:input", ".form-buscarPersona")
			cedula.val(cedula.val().trim())
		})
		$("#q","#form-buscarPorApellido").keyup(function(e){
			if(e.keyCode == '13')
				$("#bt-buscarPorApellido").click()
		})
		
	}
	
 }

$().ready(function(){
	/**
	 * MENU: Agrega los señaladores a los submenues
	 */
	$("a.jm-submenu").append("<span class='ui-icon jm-icon'/>")
	  
	$("#link-loginAs").click(function(){
		var loginAsDialog = $("<div class='ui-form' id='form-loginAs'>Doc.Id: <input name='login' id='login-as-username'/></div>").dialog({
			'title':'Ingresar como...', 'width':240, 'height':150,
			'buttons': {'Aceptar': function(){
				var login = $F("#login-as-username");
				if( login == ""){
					loginAsDialog.dialog('destroy').remove();
				}else	{
					$.post(url_for('sesion','login_as'), {'login': login}, function(html){
						if(html == 'USER_NOT_FOUND')
							jAlert("Usuario "+login+" No Hallado");
						else
							location.reload();
						loginAsDialog.dialog('destroy').remove();
					})
				}
			}}
		})
		return false;
	}); // fin link loginAs click

	  
	$("#link-unloginAs").click(function(){
		$.wDialog('show');
		$.post(url_for("sesion", 'unlogin_as'), function(){
			$.wDialog('hide');
			location.reload();
		})
		return false;
	}); // fin link unloginAs click


  
  /** SELECT CURSO **/
	$(".form-select-curso select#cod_programa").change(function(){
    var curso_settings = {url: url_for('grupos','cursos_segun_programa'), selector: "#cod_curso"};
    if($(".form-select-curso").hasClass("include-all-cursos"))
      curso_settings.params = {tipo: '*'};
		PNAT.fnPoblar(this, curso_settings);
		if($("select#cod_componente",".form-select-curso").length > 0)
			PNAT.fnPoblar(this,{url: url_for('componentes','componentes_segun_programa'), selector: "#cod_componente"})
	}).change()


 $(".form-select-curso-especial select#cod_programa").change(function(){
		PNAT.fnPoblar(this,{url: url_for('cursos_especiales','cursos_segun_programa'), selector: "#cod_curso"})		
	}).change()

	$(".form-programas-icfes select#cod_programa").change(function(){
		var form = $(this).parents("form, .ui-form")
    $.getJSON( url_for('icfes','icfes_segun_programa'), {cod_programa:$F(this)},
          function(json){$("select#cod_prueba", form).html(json.toSelect());})
	}).change()
  
	$(".ajax-response").ajaxSuccess(function(ev, xhr, settings){
			setup();
			return true;
	})
	
	$$("input-buscarPorCedula").focus()
	
	executeControllerAction();
	setup();
	BusquedaPorApellido.setup();
})


