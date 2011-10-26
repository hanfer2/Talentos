actions = {
	add: {
		'_aSeleccionarParaIES': function(){
			if($F("#cedula-IES")==''){jAlert('Ingrese una cedula valida',"Advertencia");}
			else{
				$("#widget-mostrarTodasCarreras, .ui-autocomplete").remove();
				var place = $("#ajax-egresado-ies").ajax_img();
				ajaxResponse = function(html){
					place.html(html);	App.EgresadosController._configurarFormulario();
				}
				$.get(url_for('egresados','add'),{cedula:$F("#cedula-IES")},ajaxResponse);
			}	
		},
		'_aSeleccionarParaTrabajar': function(){
			if($F("#cedula-trab")==''){jAlert('Ingrese una cedula valida',"Advertencia");}
			else{
				var place = $("#ajax-egresado-lab").ajax_img();
				ajaxResponse = function(html){
					place.html(html);	
				}
				$.get(url_for('egresados','registrar_trabajador'),{cedula:$F("#cedula-trab")},ajaxResponse);
			}	
		}
	}
}


App.EgresadosController = {
	'add': function(){
		BusquedaPorApellido.config.cod_tipo_per = COD_TIPO_PERSONA.ESTUDIANTE;
		BusquedaPorApellido.config.cod_estado = COD_ESTADO.ACTIVO;
		
		$("#tabs-registrarEgresados").tabs();

		jQuery("#bt-seleccionarEstudiante-ies").click(actions.add._aSeleccionarParaIES);
		jQuery("#bt-seleccionarEstudiante-lab").click(actions.add._aSeleccionarParaTrabajar);
		
		$("#cedula-IES").focus();
	},
	'view': function(){
		jQuery("#link-eliminarRegistro-IES").click(function(){
			var cedula = this.hash.substr(1);
			if(cedula == null) return false;;
			jConfirm("Realmente desea eliminar este registro", "Confirmacion", function(r){
				if(r){
					$.post(url_for("egresados","del"), {"cedula": cedula, 'source': 'IES'}, function(){
						location.reload();
					});
				}
			});
			return false;
		})
 	 $(".ui-title-section").click(function(){ $(this).next().slideToggle("medium") })
	}
}



Informe = {
	setup : function(){
		informeID = "#ajax-informe-egresados"
		$$("link-expandAll", informeID).click(function(){
			$("table:not(:last) tbody tr", informeID).css('display','')
			return false;
		})

		$$("link-collapseAll", informeID).click(function(){
			$("table:not(:last) tbody tr", informeID).css('display','none')
			return false;
		})
		$("tfoot", informeID).click(function(){
			var tbody = $('tr',$(this).prev())
			if(tbody.css('display')!='none')
				tbody.css('display','none')
			else
				tbody.css('display','')
		})
	}
}

$(function(){
	$$("bt-listadoEgresados").click(function(){
		$(".ajax-response").ajax_img()
		$.get(url_for('egresados','index'),$("input, select","#form-listadoEgresados").serialize(), function(html){
			$(".ajax-response").html(html);
			})
  })
	
	$$("bt-informeDeEgresados").click(function(){
			$.get(url_for('egresados','informe'), {'cod_programa':$F("#cod_programa")},
			function(html){
        $("#ajax-informe-egresados").html(html);
        Informe.setup();
      })
		})
  

  $("#cedula-IES, #cedula-trab").change(function(){
    $("#ajax-form-Add").removeClass("decorated").html("").slideUp();
  })


    $("#bt-seleccionarEstudiante-trab").click(function(){
      $(".ajax-response").html("").slideUp('fast', function(){
        if($F("#cedula-trab")=='')
          jAlert('Ingrese una cedula valida')
        else
         $(".ajax-response").load(url_for("egresados","registrar_trabajador")+"&"+$.param(
            {cedula:$F("#cedula-trab")}))
      })
    })
    $("#cedula-IES").keydown(function(event){
      if(event.keyCode=='13')
        $("#bt-seleccionarEstudiante-IES").click()
    })
})

