eCtrl = App.createController('estudiantes');

// ******* INFORME *******************
eCtrl.addAction('informe', function(){
	
	this.addListener('informe.bt-informe', function(){
		
		$$("bt-informeDeParticipantes").click(function(){
			$(".ajax-response").ajax_img()
			$.get(url_for('estudiantes','informe'), {cod_programa:$F("#cod_programa")}, function(html){
				$(".ajax-response").html(html)
				eCtrl.triggerEvent('informe.display','');
				
			});// fin button click
		});
		return this;
	});
	
	helper_triggerToggleInformes = function(){
		if($("#wPanel-reporte-Participantes").length < 1)
			return false;
		eCtrl.triggerEvent('informe.toggleColegios','informe.toggleEstExcept','informe.toggleComunasPorCurso');
	}
	
	this.addListener('informe.display', function(){
		$("a","#menu-reporte-Participantes").click(function(){
			var target = this.hash;
			var jqTarget = $(target);
			if(jqTarget.is(':visible'))
				return false;
			$(".p-content-item:visible", "#content-reporte-participantes").fadeOut('fast');
			jqTarget.fadeIn(500);
			return false;
		});
		
		if($("#wPanel-reporte-Participantes").length < 1)
			return this

		helper_triggerToggleInformes();
		this.triggerEvent('informe.showChart');
		
		return this;
  });
  
  this.addListener('informe.toggleColegios', function(){
		var jqTabla = $("#table-informe-Colegios");
		var oTableColegios = jqTabla.dataTable();
		var prefix = {'row':"row-informe-colegios-",'table':"wrapper-informe-EstudiantesPorColegio-"};
		
		$("#table-informe-Colegios tbody tr").each(function(){
			var nTr = this;
			var sColegioID = nTr.id.substr(prefix.row.length)
			$("td.toggle-icon-cell span.ui-icon", nTr).click(function(){
				if($(this).hasClass("ui-icon-plusthick")){
					oTableColegios.fnOpen(nTr,$$(prefix.table + sColegioID).html(), "detalles-estudiantesPorColegio")
				}else{
					oTableColegios.fnClose(nTr);
				}
			})
		}); // fin  each
	}); // fin listener
	
	this.addListener('informe.toggleEstExcepc', function(){
		var oTableExcepciones = $$("table-informe-Excepciones").dataTable({
			'fnInfoCallback': function(){ return "";}
		});
		var Excepciones = ['Etnias','Discapacitados','Desplazados','Hijos', 'Embarazos'];
		Excepciones.each(function(excepcion){
			$$("icon-toggle-informe"+excepcion).click(function(){
				var nTr = $$("row-informe"+excepcion).get(0)
				if($(this).hasClass("ui-icon-plusthick")){
					oTableExcepciones.fnOpen(nTr, $$("wrapper-informe-"+excepcion).html(), "detalles-informeExcepcion")
				}else{
					oTableExcepciones.fnClose(nTr)
				}
			})
		})
	});
  
  this.addListener('informe.toggleComunasPorCurso', function(){
		var jqTabla = $("#table-informe-ComunaPredominante");
		var oTabla = jqTabla.dataTable({
			'fnInfoCallback': function(oSettings, iStart, iEnd, iTotal, iMax){return iTotal+" cursos"}
		})
		
		jqTabla.find("tbody .toggle-icon").each(function(){
			var jqToggleIcon = $(this);
			var nTr = jqToggleIcon.parents("tr")[0];

			jqToggleIcon.click(function(){
				var target = this.hash;
				if(jqToggleIcon.hasClass("ui-icon-plusthick")){
					oTabla.fnOpen(nTr, $(target).html(), "detalles-informeComunasPorCurso");
					jqToggleIcon.removeClass("ui-icon-plusthick").addClass("ui-icon-minusthick");
				}else{
					oTabla.fnClose(nTr);
					jqToggleIcon.removeClass("ui-icon-minusthick").addClass("ui-icon-plusthick");
				}
				return false;
			}); // fin click
		});
	})
	
	
      
  helper_showChart = function(categoria){
		var table =$("#table-informe-"+categoria) 
		var suma = 0;
		var column = table.getColumn(1)
		if(column == null)
			return; 
		table.getColumn(1).each(function(i){
			suma += parseInt(i)
		})
		
		var pieChartSettings = $.extend(true, {},Informe.chartSettings['default'],Informe.chartSettings[categoria]);
		pieChartSettings.chart.renderTo = 'chart-container-'+categoria;
		pieChartSettings.tooltip.formatter = function(){
			var percent = this.point.y * 100 / suma
			return "<strong> "+(Informe.chartSettings[categoria].tooltipLabel||'')+" "+
							this.point.name+" "+(Informe.chartSettings[categoria].postTooltipLabel||'')+
							":</strong> "+this.y+" estudiantes ("+percent.round(2)+" %)"
		};
		table.piechart(pieChartSettings)
	}
	
	this.addListener('informe.showChart', function(){
		if($("#wPanel-reporte-Participantes").length < 1)
			return this;
			
		['Estratos','Generos','Edades','Comunas'].each(function(categoria){helper_showChart(categoria)});
		
		var settingsEdadesResumen = $.extend(true,{},Informe.chartSettings['default'], Informe.chartSettings.Edades.resumen)
		settingsEdadesResumen.series =[{type:'pie',
			data:[['Mayores de Edad', parseInt($("#td-mayores-edad").text())],['Menores de Edad', parseInt($("#td-menores-edad").text())]]
		}]
		log(settingsEdadesResumen);
    new Highcharts.Chart(settingsEdadesResumen);
		
	});
  
  this.triggerEvent('informe.bt-informe','informe.display');
});
















var  Informe ={
	'chartSettings':{
		'default':{
			'chart': {'width':350},'tooltip':{},
			'subtitle':{'text':"Generado: "+new Date().toString("MMM dd yyyy - h:mm:sstt")},
      'plotOptions':{'pie':{'dataLabels':{'formatter': function(){return this.point.name}}}}
		},
		'Comunas':{
			'chart':{'height':620,'width':390, marginTop:0}, 'tooltipLabel': 'Comuna',
            'legend':{'labelFormatter': function(){return "Comuna "+this.name}},
			'plotOptions':{'pie':{'dataLabels':{'formatter': function(){if(this.point.y >30) return this.point.name}}}}
		},
		'Estratos':{'tooltipLabel': 'Estrato', 
		 'legend':{'labelFormatter': function(){return "Estrato "+this.name}},
		 'plotOptions':{'pie':{'dataLabels':{'formatter': function(){return this.point.name+"<br/>"+this.point.y}}}}
		},
		'Generos':{'tooltipLabel': 'Género',
			'plotOptions':{'pie':{'dataLabels':{'formatter': function(){return this.point.name+"<br/>"+this.point.y}}}}
		},
		'Edades':{'tooltipLabel': '',postTooltipLabel:" años",'legend':{'labelFormatter': function(){return this.name+" años"}},
			'plotOptions':{'pie':{'dataLabels':{'formatter': function(){if(this.point.y > 50) return this.point.name+" años<br/>"+this.point.y}}}},
			'resumen':{
					'chart':{'renderTo':'chart-container-EdadesResumen', width: 350},
					'title':{'text':'Informe por Edades'},
					'plotOptions':{'pie':{'dataLabels':{'enabled':true,'color':'#CCC','formatter': function(){return this.point.name+"<br/>"+this.point.y}}}}
			}
		}
	}
 }

App.EstudiantesController = {
	'index': function(){
		$("#bt-listadoDeParticipantes").click(function(){
			
			var _this = $(this)
			var jqForm = $("#form-listadoDeParticipantes")
			
			if(jQuery(":checked", jqForm).length == 0)
				jAlert("Debe seleccionar al menos un tipo de Listado: Activo, Inactivo, Egresado");
			else{
				var status = [];
				jQuery(":checked", jqForm).each(function(){
					status.push(this.value);
				})// fin jq each
				status = status.join("|");
				var cod_programa = jQuery("#cod_programa").val();
				location.href = url_for({"cod_programa":cod_programa, 'st':status})
			}
			
		})//fin click
		
		var oTable = $("#table-listadoEstudiantes").dataTable(); //fin DATATABLE
		function addListener_estadoFilterButton (){
			var jqButtonset = jQuery("#buttonset-filtro-estados");
			
			$(".fg-button",jqButtonset).click(function(){
				var _this = $(this);
				_this.toggleClass("ui-state-active");
				var filters = [];
				var buttonsChecked = $(".ui-state-active", jqButtonset)
				
				buttonsChecked.each(function(){
					filters.push("^"+this.hash.substr(1, this.hash.length - 2)+"$");
				});
				filters = filters.join("||");
				log(filters)
				oTable.fnFilter(filters, -2, true);
				return false;
			}); // fin click
		}// fin listener
		
		addListener_estadoFilterButton();
	}
}



$(function(){
    
  $$("bt-informeDeInactivos").click(function(){
		$(".ajax-request").ajax_img()
		$.get(url_for(),{'cod_programa': $F("#cod_programa")}, function(html){
			$(".ajax-request").html(html)
				$(".dataTable").dataTable()
		})
	})
	
})
