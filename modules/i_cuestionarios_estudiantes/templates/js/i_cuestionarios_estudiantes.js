
App.ICuestionariosEstudiantesController = {
	'add': function(){
		if(App.current_uri.getData("cod_prueba")== undefined){
			iCuestionariosEstudiantes.add.cod_prueba();
		}else if(App.current_uri.getData("cedula")== undefined){
			iCuestionariosEstudiantes.add.cedula();
		}else{
			iCuestionariosEstudiantes.add.notas();
		}//fin IF !cod_prueba
	},//fin add
	'view':function(){
			$("h5.header-nombreComponente").click(function(){
				var header = $(this);
				var next = header.next()
				$(".active-nombreComponente").removeClass("active-nombreComponente");
				header.addClass("active-nombreComponente");
				next.slideToggle();
			});// fin header click
			
			$("#link-eliminarCuestionario").click(function(){
				var param = this.hash.substr(1);
				var params = param.split("-");
				$.post(url_for("delete"), {"cedula": params[0], "cod_prueba":params[1]}, function(html){
					if(isBlank(html)){
						jAlert("FORMULARIO REMOVIDO");
						location.reload();
					}else{
						jAlert(html)
					}
				})// fin $.post
			})//fin link click
			
			$(".link-editarRespuesta").click(function(){
				var target = this.hash.substr(1);
				var parts = target.split("-");
				var numeral = parts[2];
				var dialog = $("<div id='dialog-editarRespuesta' class='center'>Pregunta "+numeral+": <input name='respuesta'/></div>").dialog({
					'title': 'Corregir Respuesta', 
					'buttons':{
						'Cancelar': {
							'icons': 'ui-icon-close','action': function(){ $("#dialog-editarRespuesta").dialog('destroy'); }
						},
						'Modificar':{
							'icons':'ui-icon-pencil', 
							'action': function(){
								var respuesta = $("#dialog-editarRespuesta input").val();
								$.post(url_for("edit"), {'cedula':parts[0], 'cod_prueba':parts[1], 'numeral':parts[2], 'respuesta':respuesta}, function(html){
									if(isBlank(html))
										location.href=url_for('view', {'cedula': parts[0], 'cod_prueba':parts[1]});
									else
										jAlert(html)
								});
							}
						}
					}
				});
				
				return false;
			});
	}
};//fin App

iCuestionariosEstudiantes = {
	'add':{
		
		/* Cuando se debe seleccionar la prueba*/
		'cod_prueba': function(){
			$("#bt-cargarNotas").click(function(){
				$.get(url_for(), {"cod_prueba": $F("#cod_prueba")}, function(html){
					$(".ajax-buscarUsuario").html(html);
					BusquedaPorApellido.config.cod_tipo_per = COD_TIPO_PERSONA.COD_TIPO_ESTUDIANTE;
					BusquedaPorApellido.config.cod_programa ="CURRENT";

					BusquedaPorApellido.setup();
					iCuestionariosEstudiantes.add.cedula();
				});// fin $.post
			}); //fin button click
		},// fin cod_prueba
		
		/* Cuando vamos a seleccionar la cedula*/
		'cedula': function(){
			$("#bt-cargarNotasSimulacro").click(function(){
				
				var cedula = $F("#input-buscarPorCedula");
				//validacion
				if(!(cedula =='' || isNaN(cedula))){
					$$("ajax-cargarNotasSimulacro").ajax_img();
					var cod_prueba = $F("#cod_prueba");
					
					$.get(url_for(), {'cedula': cedula, 'cod_prueba': cod_prueba}, function(html){
						$$("ajax-cargarNotasSimulacro").html(html)
						iCuestionariosEstudiantes.add.notas();
					});//fin get
					
				}// fin IF
				
			});// fin button click
		},// fin cedula
		
		/* Cuando vamos a ingresar las notas*/
		'notas': function(){
			$(".inner-respuestasComponente .questions-line-field:odd").addClass("odd-questions-line-field")
			$(".inner-respuestasComponente:first").show();
			$("h5.header-nombreComponente:first").addClass("active-nombreComponente")
			$(".input-helper:first", "#form-subirCuestionarioCalificado").focus()
			
			$("h5.header-nombreComponente").click(function(){
				var next = $(this).next()
				$(".header-nombreComponente").not(this).removeClass("active-nombreComponente")
				$(this).addClass("active-nombreComponente");
				var prev = $(".inner-respuestasComponente:visible").not(next).slideUp()
				if(!next.is(":visible")){
						var tieneSinResponder = false;
						jQuery(".questions-line-field", prev).each(function(){
							if(jQuery(":checked", this).length == 0){
								tieneSinResponder = true;
								return false;
							}
						})
						var headerComponent = $("h5.header-nombreComponente",prev.parent());
						if(!tieneSinResponder){
							$(".h-text",headerComponent).addClass("h-componenteIncompleto")
							.next().html("\u263A");
						}else{
							$(".h-text",headerComponent).removeClass("h-noCompleto")
							.next().html("");
						}

					next.slideDown()
					var input =$("input:first", next).focus()
					window.scrollTo(input.position().top, input.position().left)
				}
			})
			
		}// fin notas
	}
}

 function clickCheckbox(o){ 
      var row = $(o).parents(".questions-line-field")
			$(".status-icon", row).css({"color":"#555"})
			switch($(":checked", row).length){
				case 0: $(".status-icon", row).html(" "); break;
				case 1: $(".status-icon", row).html("\u2588").css({'color':"#006600"}); break;
				default:$(".status-icon", row).html("\u2588").css({'color':"#CC0000"});
			}
 }
     

$(function(){
	$(".letras-respuestas :checkbox").live('click', function(){
			$(".active-questions-line").removeClass("active-questions-line");
      var row = $(this).parents(".questions-line-field")
      row.addClass("active-questions-line")
			clickCheckbox(this)
	})

	




	$$("bt-subirCuestionarioCalificado").live("click", function(){
		var preguntasSinRespuestas=0
		jQuery.each($(".questions-line-field", "#form-subirCuestionarioCalificado"), function(){
			if($(":checked", this).length == 0)
				preguntasSinRespuestas++;
		})
		var message ="Este cuestionario presenta <strong>"+preguntasSinRespuestas+" preguntas</strong> sin responder\n";
		message += "¿Confirma que desea enviar este cuestionario?\nTenga en cuenta que despúes no podrá ser modificado."

		if(preguntasSinRespuestas > 0){
			jConfirm(message, "Confirmacion", function(r){
				if(r)
					$("#form-subirCuestionarioCalificado").submit();
			})
			return false;
		}
		$("#form-subirCuestionarioCalificado").submit();
		return true;

	})
	$(".input-helper").live('keyup', function(e){
		if(e.keyCode == 13){
			var line = $(this).parents(".questions-line-field")
			$(".input-helper", $(line).next()).focus()
	}

	})


	$(".input-helper").live('focus', function(){
		 $(".active-questions-line").removeClass("active-questions-line");
     var row = $(this).parents(".questions-line-field")
     row.addClass("active-questions-line")
	})
	$(".input-helper").live('blur', function(){
		valor = this.value.toUpperCase()
		if(valor == null)
			return true;
		valor = valor.replace("1",'A')
		valor = valor.replace("2","B")
		valor = valor.replace("3","C")
		valor = valor.replace("4","D")
		valor = valor.replace("5","E")
		valores = valor.split("")
		var line = $(this).parents(".questions-line-field")
		$("label", line).each(function(){
			if($.inArray($(this).text(), valores)!= -1 )
				$(this).next().attr("checked","checked")
			else
				$(this).next().attr("checked","")
		})
		clickCheckbox(this);
	})

	$$("link-contractAll").live('click',function(){
		$(".inner-respuestasComponente").slideUp()
		$(".active-nombreComponente").removeClass("active-nombreComponente");
		return false;
	})
	$$("link-expandAll").live('click',function(){
		$(".inner-respuestasComponente").slideDown()
		$("h5.header-nombreComponente").addClass("active-nombreComponente")
		return false;
	})
	$(".placeholder",".letra-escogida:not(.letraConRespuestaCorrecta)").html("\u2717")
	$(".placeholder",".letraConRespuestaCorrecta.letra-escogida").html("\u2714");
})

