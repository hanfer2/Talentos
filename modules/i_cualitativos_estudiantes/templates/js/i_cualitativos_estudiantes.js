
$(function(){
	
	$$("link-contractAll").live("click", function(){
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
