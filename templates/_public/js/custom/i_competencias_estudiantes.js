

$(function(){
	$("h3","#wrapper-reporteCompetenciasPorCurso").live('click', function(){
			$(this).next().slideToggle("fast")
	})
	$$("link-contractAll").live("click", function(){
		console.log(this)
		$(".dataTables_wrapper").slideUp()
		return false;
	})
	$$("link-expandAll").live("click", function(){
		$(".dataTables_wrapper").slideDown()
		return false;
	})

  Icfes.calcularPorcentajesPorCalificador();
  
  $$("reporteGeneral-competencias-main").ajaxSuccess(ICalificador.configuraReporteGeneral);
  ICalificador.addActionListeners();
  ICalificador.configuraReporteGeneral();
})
