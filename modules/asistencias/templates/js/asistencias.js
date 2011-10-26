Asistencia = {
	consultarClases: true,
	fnVerificarMotivoInasistencia: function(){
		$("select","#table-registrarAsistencia tbody").each(function(){
			var chbx = $(this).parents("tr").find(":checkbox")
			$(this).setEnabled(!chbx.is(":checked"));
		})
	},
	fnHabilitarMotivoInasistencia: function(checkbox){
		var select = $(checkbox).parents("tr").find("select")
		select.toggleEnabled()
	},
	fnContarInasistenciasIndividual: function(){
		var wrapperInasistencias = "#wrapper-inasistenciasIndividual"
		if($(wrapperInasistencias).length = 0)
			return false;
		$$("total-asistenciasIndividualInjustificadas").html($(".asistencia-injustificada", wrapperInasistencias ).length)
		$$("total-asistenciasIndividualJustificadas").html($(".asistencia-justificada",wrapperInasistencias).length)
    var iInasistencias = $(".claseConInasistencia", wrapperInasistencias ).length;
    var iClasesReportadas = parseInt($("#total-clasesReportadas").html());
    var iPorcentaje = (iInasistencias * 100) / iClasesReportadas;
    iPorcentaje = Math.round(iPorcentaje * 100)/100;
		$$("total-inasistencias").html( iInasistencias + "( "+iPorcentaje+"%)");
	}
}
$(function(){
	$$("wrapper-asistencias-fechas").dialog({
		autoOpen:false,
		modal:true,
		'title': 'Seleccione la clase'
	})
	$$("bt-registrarAsistencia").click(function(){
//		if(Asistencia.consultarClases){
			$$("wrapper-asistencias-fechas").ajax_img().dialog('open')
			$.get(url_for('asistencias','clases'),
				$("select","#form-registrarAsistencia").serialize(),
				function(html){
					$$("wrapper-asistencias-fechas").html(html)
					Asistencia.consultarClases = false
				})
//		}else{
//			$$("wrapper-asistencias-fechas").dialog('open')
//		}
	})
	$("#cod_componente, #cod_programa").live('change',function(){
		Asistencia.consultarClases = true;
	})

	$$("bt-seleccionarFechaAsistencia").live("click",function(){
		var fechas = $$("wrapper-asistencias-fechas")
		if($(":checkbox", fechas).length > 0){
			fechas.dialog('close');
		}else if($(":checked", fechas).length == 1 ){
			fechas.dialog('close');
			$(".ajax-response").ajax_img();
			$.ajax(url_for('asistencias','registrar'),{
				'type': 'get',
				'data': $(":field","#form-registrarAsistencia, #asistencias-clases-fechas").serialize(),
				'success': function(html){
					$(".ajax-response").html(html)
					Asistencia.fnVerificarMotivoInasistencia()
				},
				'globals':false})
		}else{
			jAlert("Debe seleccionar una clase")
		}
	})

	$(".chk-asistencia-asiste").live('click', function(){
		Asistencia.fnHabilitarMotivoInasistencia(this)
	})
	$$("bt-listadoDeInasistenciasColectivo").click(function(){
		$(".ajax-response").ajax_img()
		$.get(url_for("asistencias",'general'),
					{'cod_programa':$F("#cod_programa")}, 
					function(html){
						$(".ajax-response").html(html);
						App.AsistenciasController.general();
					});
	})
	
	BusquedaPorApellido.config.cod_tipo_per = [1]
	$$("bt-asistenciaIndividual").click(function(){
    var jqMainContent = $("#ajax-asistenciaIndividual").ajax_img();
		$.get(url_for('asistencias','view'), {'cedula':$F("#input-buscarPorCedula")},function(html){
			jqMainContent.html(html)
			Asistencia.fnContarInasistenciasIndividual()
			return false;
		})
	})
	/*nombre dek boton del formulario, evento al presionarlo,  llama la funcion que hara la operaciones de sumar los totales*/
	$$("bt-listadoDeInasistenciasColectivoPorCurso").click(function(){
		$(".ajax-response").ajax_img()	
		$.get(url_for('asistencias','general'),
					{'cod_curso':$F("#cod_curso")}, 
					function(html){
						$(".ajax-response").html(html);
						App.AsistenciasController.general();
					})
	})
	
  
  
	$$("bt-formatosDeAsistencia").click(function(){
		$(".ajax-response").ajax_img()
		$.get(url_for(), $(":field","#form-formatosDeAsistencia").serialize(), function(html){
			$(".ajax-response").html(html)
			$(".table-formatoAsistencia").last().css('page-break-after','avoid')
		})
	})
	
	Asistencia.fnContarInasistenciasIndividual()
})

App.AsistenciasController = {
	'general': function(){
		$("#table-inasistenciasGeneral").dataTable(
		
			{"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull){
				var totales = {'j':0, 'i':0};
				$(".asistenciaJustificada", nRow).each(function(){
					totales.j += parseInt(this.innerHTML);
				})
				$(".total-asistenciasJustificadas",nRow).html(totales.j);
				$(".asistenciaInjustificada", nRow).each(function(){
					totales.i += parseInt(this.innerHTML);
				})
				$(".total-asistenciasInjustificadas",nRow).html(totales.i);
				$(".total-clasesInasistidas",nRow).html(totales.i + totales.j);
				return nRow;
			}}
		);
	}
}

function componentes(){
    alert("hola");
		$("#table-inasistenciasGeneral").dataTable(
		
			{"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull){
				var totales = {'j':0, 'i':0};
				$(".asistenciaJustificada", nRow).each(function(){
					totales.j += parseInt(this.innerHTML);
				})
				$(".total-asistenciasJustificadas",nRow).html(totales.j);
				$(".asistenciaInjustificada", nRow).each(function(){
					totales.i += parseInt(this.innerHTML);
				})
				$(".total-asistenciasInjustificadas",nRow).html(totales.i);
				$(".total-clasesInasistidas",nRow).html(totales.i + totales.j);
				return nRow;
			}}
		);
	}

