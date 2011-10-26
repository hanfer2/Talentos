EstudiantesNotificaciones = {
	'resetNewForm' : function(){
		$("textarea,input.date", "#wrapper-new-notificacion").val("");
		var today = $.datepicker.formatDate($.datepicker._defaults.dateFormat, new Date());
		$("#notificacion_fecha_inicio").val(today);
	},
	'hideNewForm': function(){
		this.resetNewForm();
		$("#wrapper-new-notificacion").slideUp('fast');
		$("#link-nuevaNotificacion").show();
	}
}
var oENotifs = EstudiantesNotificaciones;

App.EstudiantesNotificacionesController = {
	'_view':{
		'onDelete' : function(){
			var link = this;
			jConfirm("Seguro que desea eliminar esta notificaci\u00F3n?","Confirmacion",function(r){
				if(r){
					var params = link.hash.substr(1).split("-");
          var dataParams = null;
          if(params[0] == 'g')
            dataParams = {'global':1, 'cod_mensaje':params[1]};
          else
            dataParams = {'param':params[0],'val':params[1], 'cod_mensaje':params[2]};
            
					var widget = $("#listado-notificaciones").ajax_img();
					$.ajax(url_for('estudiantes_notificaciones','delete'), {
						'data': dataParams , 'dataType' : 'html','type': 'post',
						'success': function(html){
							widget.replaceWith(html);
							App.EstudiantesNotificacionesController._view.onLoad();
						}
					})
				}
			});
		},//fin actionOnDelete
		'onLoad': function(){
			$("#listado-notificaciones").delegate('.link-delete','click', this.onDelete);
		}
	},
	'view': function(){
		var controller = App.EstudiantesNotificacionesController
		var $form = $("#wrapper-new-notificacion");
		var dates = $form.find("input.date")
		.datepicker(
			{'minDate':'-6m', 'maxDate':'+6m', 
			 'onSelect': function(selectedDate){
				 //Redefinimos las restricciones del rango al seleccionar una fecha.
					selectedDate = $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate);
					var option = (this.id == 'notificacion_fecha_inicio')? "minDate": "maxDate";
					dates.not(this).datepicker("option",option,new Date(selectedDate));
				}
			}
		);//fin dates
		
		//Definimos inicialmente al dia actual como fecha minima para el campo de la fecha fin de las notificaciones
		dates.filter("#notificacion_fecha_fin").datepicker("option","minDate","+0d");
		
		controller._view.onLoad();
		
		//------
		$("#bt-agregarNotificacion").click(function(){
			//validar fecha_inicio como campo requerido
			if($F("#notificacion_fecha_inicio") == ""){
				jAlert("Debe definir la fecha inicio desde la cual se mostrar\u00E1 la notificaci\u00F3n");
				return false;
			}
			//validar mensaje como campo requerido
			if($F("#notificacion_mensaje") == ""){
				jAlert("Debe definir el mensaje de la Notificaci\u00F3n");
				return false;
			}
			
			$("#listado-notificaciones").ajax_img({"text":null});
			$.post(url_for('estudiantes_notificaciones','add'), $form.find("input, textarea").serialize(), function(html){
				$("#listado-notificaciones").replaceWith(html);
				controller._view.onLoad();
			}); //fin $.post
			
			oENotifs.hideNewForm(); //ocultar el formulario.
			
		});// fin button click
		
		//------
		$("#bt-cancelarNuevaNotificacion").click(function(){
			oENotifs.hideNewForm(); 
			return false;
		})// fin button click;
		
		//------
		$("#wrapper-new-notificacion").hide();
		$("#link-nuevaNotificacion").click(function(){
			$("#wrapper-new-notificacion").slideDown(); 
			$(this).hide();
			return false
		});//fin link click;
			
	}// fin Controller.view
}
