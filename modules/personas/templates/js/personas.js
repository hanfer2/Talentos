
Persona = {
	setupForm : function(){
		$$("form-registrarPersona").slideDown().validity(function(){
			$("#persona_cod_tipo_per").greaterThanOrEqualTo(0, "Debe seleccionar el tipo de usuario");
			$(".required").require()
			$(".numeric").match("number")
			$(".email").match("email")
		})
		if($("#buttonset-cod_tipo_per :radio:checked").length == 0)
			$("#buttonset-cod_tipo_per :radio:first").setChecked(true);
			
		$$("ajax-load-registrarPersona").remove()
		$("#persona_fecha_nacimiento").datepicker({'maxDate':'-14y'})
		
		$("#bt-cancelarActualizacion").click(function(){
			location.href=url_for('personas','view',{'cedula':$$("header-link-cedula").text()});return false;
		})
		
		$(".autocompletable:input", "#form-registrarPersona").autocomplete({
			"minLength": 3,
			"source": function(request, response){
				var input = $(this.element);
				var q = request.q.toUpperCase();
				if(input.is(".ac-q-ciudad")){
					// ACCESO RAPIDO A CALI
					if(['CAL','CALI'].contains(q))
						response([{'codigo': App.constants.COD_CIUDAD_CALI,'nombre':'SANTIAGO DE CALI'}]);
					else
						$.getJSON(url_for("ciudades","index"),{"q":q},function(json){response(json)});
					}else if(input.is(".ac-q-barrio")){
					// ACCESO RAPIDO A CALI
						$.getJSON(url_for("barrios","index"),{"q":q},function(json){response(json)});
					}
			},  // fin autocomplete.source
			'select': function(ev, ui){
				$(this).val(ui.item.nombre).next().val(ui.item.codigo);
				return false;
			} // fin autocomplete.select
			
		})//fin Autocomplete
		.keyup(function(){
			this.nextElementSibling.value = "";
		})
	},
	checkPasswdForm: function(){
		$.validity.start();
			$("input","#form-edit_passwd").require()
			var passwd_matched = $F("#passwd_new") == $F("#passwd_confirmation")
			$("#passwd_new,#passwd_confirmation").assert(passwd_matched,"La nueva contrase&ntilde;a no coincide con la confirmaci&oacute;n")
		var result = $.validity.end();
		return result.valid;
	},
	status:{
		settings:{
			'ACTIVO':{'icon':'&#10004;', 'color':'#009900'},
			'INACTIVO':{'icon':'&#10008;', 'color':'#660000'},
			'EGRESADO':{'icon':'', 'color':'#0000CC'},
		},
		setup: function(){
			if($$("hv-field-status").length == 0)
				return 
			var status = $$("hv-field-status-text").text()
			var item = Persona.status.settings[status.toUpperCase()]
			$$("hv-field-status-icon").html(item.icon)
			$$("hv-field-status").css('color',item.color)
		}
	}
}

personasCtrl = App.createController('Personas');
personasCtrl.addAction('view', function(){
  this.addListener('notificaciones.view', function(){
    var $notificationsDialog = null;
    var jqNotificacionesLink = $("#link-verNotificaciones");
    
 
    
		jqNotificacionesLink.click(function(){
			var cedula = this.hash.substr(1);
      
			//Si no esta inicializado el cuadro de dialogo, crearlo;
			//de lo contrario, solo invocarlo
			if($notificationsDialog == null){
				$notificationsDialog = $("<div/>").ajax_img().dialog({
					'width': 600,
					'title': 'Listado de Notificaciones',
					'buttons':{
						'Aceptar': {'icons':'ui-icon-check', 'action':function(){$(this).dialog('close');}}
					},
					'close': function(){
						//al cerrar, vaciar el formulario.
						oENotifs.hideNewForm();
					}
				});
				
				$.when(
				//Cargamos las librerias necesarias.
					$.getScript(App.paths.js+"jquery.ui.datepicker.min.js"), 
					$.getScript(url_script("estudiantes_notificaciones"))
				).done(function(){
						//Al estar listas las librerias,
						//Invocamos el panel de notificaciones del participante.
           // location.reload();
						$.get(url_for('estudiantes_notificaciones','view'), {"cedula": cedula}, function(html){
							$.addStyleSheet('estudiantes_notificaciones');
							$notificationsDialog.html(html);
							App.EstudiantesNotificacionesController.view();
            
						})
           
				})// fin $.when
   
			}else{
				$notificationsDialog.dialog("open");
        return false;
			}// fin IF
    });
  })
  this.triggerEvent('notificaciones.view');
});
App.PersonasController={
	'add': function(){
		Persona.setupForm();
	},
	'edit': function(){
		Persona.setupForm();
	}
};// fin App.controller

$(function(){
	Persona.status.setup();
	
	$$("form-edit_passwd").dialog({'autoOpen':false, modal:true})
	$$("link-edit_passwd").click(function(){
		$$("form-edit_passwd").dialog('open'); 
		return false;
	})
	$$("form-delete-estudiante").dialog({'autoOpen': false, modal:true})
	$$("link-delete-estudiante").click(function(){
		$$("form-delete-estudiante").dialog('open')
		return false;
	})
	$$("bt-delete-persona").click(function(){
		jConfirm("Esta seguro de querer dar de baja a este participante","Confirmación", function(r){
			if(r){
				$.post(
					url_for('estudiantes','delete'),
					$("input, select","#form-delete-estudiante").serialize(),
					function(){location.reload()})
			}
		})
	})
	$$("bt-edit_passwd").click(function(){
		
		if(Persona.checkPasswdForm()){
			$$("form-edit_passwd").dialog('close'); 
			$.post(url_for('personas','edit_passwd'), 
				$("input","#form-edit_passwd").serialize(),
				function(html){
					html = html || "Fall&oacute Actualizaci&oacute;n de Contrase&ntilde;a";
					jAlert(html);
					$("input","#form-edit_passwd").not(":hidden").val("")
				})
		}
	})

	$$("bt-buscarPersona").click(function(){
		var cedula = $F("#input-buscarPorCedula")
		return  /^\d+$/.test(cedula)
	})

	$$("form-editarDesplazamiento").dialog({autoOpen:false, modal:true})
	$$("link-editarDesplazamiento").click(function(){
		$$("form-editarDesplazamiento").dialog('open')
		return false;
	})
	
	$$("form-editarEmbarazo").dialog(
		{autoOpen:false, modal:true, buttons:{
			'Cancelar': function(){$( this ).dialog( "close" )},
			'Aceptar': function(){
				$( this ).dialog( "close" )}
		}}
	)
	$$("link-editarEmbarazo").click(function(){
		$$("form-editarEmbarazo").dialog('open')
	})
	
	$$("bt-editDesplazamiento").click(function(){
		$.post(
			url_for('personas','editDesplazamiento'), 
			$(":field","#form-editarDesplazamiento").serialize(),
			function(html){location.reload()})
	})

	$$("form-cambiarCurso").dialog({autoOpen:false, modal:true})
	$$("link-cambiarCurso").click(function(){
		$$("form-cambiarCurso").dialog('open')
		return false;
	})
	
	$$("form-asignarCurso").dialog({autoOpen:false, modal:true})
	$$("link-asignarCurso").click(function(){
		$$("form-asignarCurso").dialog('open')
		return false;
	})
	
	$$("bt-cambiarCurso").click(function(){
		$.post(url_for('estudiantes','cambiarCurso'),$(":field","#form-cambiarCurso").serialize(), function(){location.reload()})
	})
	
	$$("bt-asignarCurso").click(function(){
		$.post(url_for('estudiantes','asignarCurso'),$(":field","#form-asignarCurso").serialize(), function(){/*location.reload()*/})
	})
	
})
