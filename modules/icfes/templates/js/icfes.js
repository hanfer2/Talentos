var componentes = [
{	abbr:'Bio',	nombre:'Biología'}, {	abbr:'Fis',	nombre:'Física'},
{ abbr:'Qui',	nombre:'Química'}, {abbr:'Mat', nombre:'Matemáticas'},
{	abbr:'Geo',	nombre:'Geografía'}, {abbr:'Len',	nombre:'Lenguaje'},
{	abbr:'His',	nombre:'Historia'}, {	abbr:'Soc',	nombre:'C. Sociales'}]

var chart_default_options = {
	cht:'bvg',legend: 'none',	colors: ['#afccfa'],chds:'1,100',	chs:'550x400',	chg:'0,0',
	chm:'N*f2,000000,0,-1,10,0,tc:0:0'
}

Icfes ={
	Individual:{
		drawChart:function(){
      
			if($$("table-icfesIndividual").length > 0){
				$$("table-icfesIndividual").highchart()
			}
		}
	},
	'oaTableHeaders':{
		'General': {
			'info':['id','cedula','nombres','grupo','curso'],
			'icfes':['snp','leng','mat', 'soc','fil','bio','quim','fis','inter','idi','geo','hist','promedio'],
			'completo': function(){ return this.info.combine(this.icfes)}
		}
	},
	fnCalcularPromedioDeComponentes: function(nRow, aData){

		 var oLimites = {'min': 6, 'max': 17};
		 var aComponentesDescartables = ['idi','geo','hist']
		 var aHeader = Icfes.oaTableHeaders.General.icfes.slice(1, -1)
		 var aIcfes = aData.slice(oLimites.min, oLimites.max).map(function(item){ return parseFloat(item)});
		 var oIcfes = aIcfes.associate(aHeader)
		 
		 //Si Sociales es null, se calcula como el promedio entre Historia y Geografia
		 if(isNaN(oIcfes.soc))
		 	oIcfes.soc = (oIcfes['geo'] + oIcfes['hist']) / 2;
		 //Descartamos
  	 oIcfes = Object.filter(oIcfes, function(item, key){ 
				return !(aComponentesDescartables.contains(key) || isNaN(item))
			})
		 aIcfes =  Object.values(oIcfes)
		 var nAvg = aIcfes.average();
		 $("td:last",nRow).html(nAvg.round(3));
		 return nRow;
	},
	/**
	 * Calcula el porcentaje basandonse el numero de respuestas correctas.
	 */
	calcularPorcentajesPorCalificador: function (calificador){
		$(".table-reporteCalificador", "#widget-reporte-"+calificador).each(function(){
				console.log(this)
				var cantidadPreguntas = [];
				$(".cantidad-preguntas .valor",this).each(function(){
					cantidadPreguntas.push(parseInt(this.innerHTML));
				});
				var ListadoCantidadRespuestasCorrectas = [];
				$("tbody tr", this).each(function(){
					$(".porcentaje-preguntas-correctas", this).each(function(idx){
						var cantidadRespuestasCorrectas = parseInt($(".cantidad-preguntas-correctas",this.parentElement).html())
						if(ListadoCantidadRespuestasCorrectas[idx] == undefined)
							ListadoCantidadRespuestasCorrectas[idx] = 0;
						ListadoCantidadRespuestasCorrectas[idx]+=cantidadRespuestasCorrectas;
						this.innerHTML = (cantidadRespuestasCorrectas*100/cantidadPreguntas[idx]).format({"decimals":2, "suffix": "%"});
					})
				});
				var cantidadRegistros = $("tbody tr", this).length;
				$("tfoot td:gt(0)", this).each(function(idx){
					var cantidadRespuestasCorrectas = ListadoCantidadRespuestasCorrectas[idx];
					$(".cantidad-preguntas-correctas",this).html(cantidadRespuestasCorrectas);
					var porcentaje = cantidadRespuestasCorrectas * 100 / (cantidadRegistros * cantidadPreguntas[idx])
					$(".porcentaje-preguntas-correctas",this).html(porcentaje.formatPercentage());
				});
			});
	},
  'Comparativas':{
		'drawCharts': function(){
				if(jQuery(".table-icfesComparativas").length <  1)
					return;
			 var pruebas = [];
				$(".nombrePrueba").each(function(){
					pruebas.push(this.innerHTML)
				})
				var aSeriesAbsoluto = [];
				$("table#table-promediosAbsoluto tbody tr").each(function(){
					td = $(this).children("td:gt(0)")
					data = []
					$(td).each(function(){
						value = parseFloat(this.innerHTML)
						data.push(isNaN(value)? 0.0: value)
					})
					aSeriesAbsoluto.push({name:$(this).children("td:first-child").html(), data:data })
				})
				var aSeriesRelativo = [];
				$("table#table-promediosRelativo tbody tr").each(function(){
					td = $(this).children("td:gt(0)")
					data = []
					$(td).each(function(){
						value = parseFloat(this.innerHTML)
						data.push(isNaN(value)? 0.0: value)
					})
					aSeriesRelativo.push({name:$(this).children("td:first-child").html(), data:data })
				})

				new Highcharts.Chart({
					chart:{	renderTo: 'chart-container-absoluto',defaultSeriesType: 'line', margin: [50, 160, 50, 80],
						backgroundColor:'white',borderColor:'#DDD', borderWidth:'2',
						shadow: true,	zoomType:'xy'},
					title:{text:'Promedios Generales Icfes', style:{fontSize:'16pt'}},
					credits:{enabled:false},
					xAxis:{categories: pruebas, title:{text:'Pruebas'}},
					yAxis:{title:{text:'Puntajes'}, min:0, max:100, minorTickInterval:5, tickInterval:10},
					lang:{loading:'Cargando'},series: aSeriesAbsoluto,
					legend:{layout: 'vertical',style:{left:'auto', bottom:'auto', right:'10px', top:'100px'}, borderWidth:1, borderColor:"#CCC"},
					tooltip:{borderColor:'#DDD',
						formatter: function(){
							return "<strong class='center'>"+this.x+"</strong><br/>"+this.series.name+": "+this.y}}
				})

				new Highcharts.Chart({
					chart:{	renderTo: 'chart-container-relativo',defaultSeriesType: 'line', margin: [50, 160, 50, 80],
						backgroundColor:'white',borderColor:'#DDD', borderWidth:'2',
						shadow: true,	zoomType:'xy'},
					title:{text:'Promedios Generales Icfes', style:{fontSize:'16pt'}},
					credits:{enabled:false},
					xAxis:{categories: pruebas, title:{text:'Pruebas'}},
					yAxis:{title:{text:'Puntajes'}, min:0, max:100, minorTickInterval:5, tickInterval:10},
					lang:{loading:'Cargando'},series: aSeriesRelativo,
					legend:{layout: 'vertical',style:{left:'auto', bottom:'auto', right:'10px', top:'100px'}, borderWidth:1, borderColor:"#CCC"},
					tooltip:{borderColor:'#DDD',
						formatter: function(){
							return "<strong class='center'>"+this.x+"</strong><br/>"+this.series.name+": "+this.y}}
				})
		 }
	}
}

Competencias={
		configs:{
			'low':{'limit':4.0,'color':'#CC1111'}, 
			'middle':{'limit':7.0,'color':'#cd853f'},
			'high':{'limit':10, 'color':'#282'}
		},
		highlight: function(){
			$("tbody tr", ".table-reporteIndividualIcfesCompetencias").each(function(){
				$("td:last", this).each(function(){
					var configs = Competencias.configs;
					valor = parseFloat(this.innerHTML)
					if(valor < configs.low.limit){
						this.style.color = configs.low.color;
						return true;
					}else if(valor < configs.middle.limit){
						this.style.color = configs.middle.color;
						return true;
					}else{
						this.style.color = configs.high.color;
						return true;
					}
				})
			})
		}
	}



ICalificador ={
 mostrarReporteGeneralPorGrupo: function(grupo){
	 var $wrapper = $$("outer-"+calificador+"-reporteGeneral-"+grupo)
	 $(".outer-i_calificador-reporteGeneral").not($wrapper).slideUp();
	 $wrapper.slideDown();
	 $("a.ui-state-active","#menu-toggleGrupo").removeClass("ui-state-active")
	 $("a[href=#"+grupo+"]").addClass("ui-state-active")
 },
 configuraReporteGeneral: function(){
	 
	 $(".outer-i_calificador-reporteGeneral:first").slideDown();
	 $("a:first","#menu-toggleGrupo").addClass("ui-state-active");
	 
},
 addActionListeners: function(){
	 $(".fg-button", "#menu-toggleGrupo").live('click',function(){
		 var grupo = this.hash.replace(/^#/,"")
		 calificador = ""
		 if($("#reporteGeneral-cualitativos-main").length == 0)
			calificador = "competencias";
		else
			calificador = "cualitativos";
  	 ICalificador.mostrarReporteGeneralPorGrupo(grupo,calificador); 
		 return false;
		})
	$(".link-irAComponente").live('click',function(){
		 var componente = this.hash.replace(/^#/,"");
		 var $target = $(this).parent().next().find("h4.area-"+componente);
		 if($target == null)
			return false;
		 $("html,body").animate({scrollTop: $target.offset().top},'slow')
		 return false;
	 })
	$(".link-goUp", ".inner-i_calificador-reporteGeneral").live('click', function(){
		$target = $(this).parents(".widget-reporteGeneral").find(".title-reporteGeneral");
		$target.scrollToMe()
		return false;
	})
	$("h4",".inner-i_calificador-reporteGeneral").live("click",function(){
		$(this).next().slideToggle()
	 })
 }
}

function addListener_registrarPromedioIcfes(){
  $("#bt-registrarPromedioIcfes").click(function(){
    var jqAjax = $("#ajax-registrarPromedioIcfes").ajax_img();
    $.get(url_for(), {'cod_prueba': cod_prueba, 'cedula':$F("#input-buscarPorCedula")}, function(html){
        jqAjax.html(html);
    });
  });
}

$(function(){

$$("bt-reporteIcfesIndividual").click(function(){
 $$("ajax-reporteIcfesIndividual").ajax_img()
 $.get(url_for('icfes','reporteIndividual'),{'cedula':$F("#input-buscarPorCedula")}, function(html){$$("ajax-reporteIcfesIndividual").html(html)})
})		


$("#bt-reporteIcfesEstudiantes").click(function(){
 $("#ajax-reporteIcfesEstudiantes").ajax_img();
 $.get(url_for(),{'cod_prueba': $F("#cod_prueba")}, function(html){
   $$("ajax-reporteIcfesEstudiantes").html(html);
   });
})

	$$("bt-generarReporteGeneralPorCompetencias").live('click', function(){
		$$("ajax-reporteInformeGeneral-competencias").ajax_img()
		$.get(url_for("i_competencias_estudiantes","reporte"), $(":field","#form-reportePorCompetencias").serialize(), function(html){
			$.getScript(url_script("i_competencias_estudiantes"));
			$$("ajax-reporteInformeGeneral-competencias").html(html)
			Icfes.calcularPorcentajesPorCalificador("competencias");
		})
	})
	
	$$("bt-generarReporteGeneralPorCualitativos").live('click', function(){
		$$("ajax-reporteInformeGeneral-cualitativos").ajax_img()
		$.get(url_for("i_cualitativos_estudiantes","reporte"), $(":field","#form-reportePorCualitativos").serialize(), function(html){
			$.getScript(url_script("i_cualitativos_estudiantes"));
			$$("ajax-reporteInformeGeneral-cualitativos").html(html)
			Icfes.calcularPorcentajesPorCalificador("cualitativos");
		})
	})
	
	Competencias.highlight()

	$("a[id|=link-icfesCompetencias]").click(function(){
		var currentID = $(this).id()
		//Extraigo la cedula
		currentID.match(/(?:-)(\d+)(?:-)/)
		var cedula=RegExp.$1
		//Extraigo el codigo de la prueba
		var cod_prueba = currentID.match(/\d+$/)
		var wrapper = $("#wrapper-competencias-"+cod_prueba)
		if(wrapper.html().trim()==''){

			$.ajax({
				url: url_for('icfes', 'competenciasIndividual'),
				data:{'cedula':cedula,'cod_prueba':cod_prueba[0]},
				global:false,
				async:false,
				success:function(html){
					wrapper.html(html);
					Competencias.highlight()
				}
			})
	}
	wrapper.dialog({width:380})
		return false;
	})
	
	Icfes.Individual.drawChart()
	Icfes.Comparativas.drawCharts()
	
	$$("ajax-reporteIcfesIndividual").ajaxSuccess(function(){
		Icfes.Individual.drawChart()
	})
	
	$(".chk-resumen").live('click', function(){
		$(this).parents(".field-tipoReporte").find(".container-cod_curso").hide().find("select").disable()
	})
	
	$(".chk-detallado").live('click', function(){
		$(this).parents(".field-tipoReporte").find(".container-cod_curso").show().find("select").enable()
	})
	
	$(".chk-resumen").click()
	

	$$("bt-generarReporteGeneralPorComponentes").live('click', function(){
		$$("ajax-reporteInformeGeneral-componentes").ajax_img()
		$.ajax({
			url:url_for('reporteComponentes'), 
			context:$$("ajax-reporteInformeGeneral-componentes")[0],
			success:function(html){$(this).html(html)}, 
			data: $(":field","#form-reportePorComponentes").serialize()
			})
	})
	$$("table-reporteIcfes").dataTable({fnRowCallback: Icfes.fnCalcularPromedioDeComponentes})
	$(".ajax-response").ajaxSuccess(function(){
		$$("table-reporteIcfes").dataTable({fnRowCallback: Icfes.fnCalcularPromedioDeComponentes})
	})

	
	$$("bt-reporteDeComparativasIcfes").click(function(){
			$(".ajax-request").ajax_img();
			$.get(url_for(), {'cod_programa':$F("#cod_programa")}, function(html){
				var ajaxWrapper = $(".ajax-request").html(html)
				$("table.dataTable").each(function(){ $(this).dataTable()	});
				$(".tabs", ajaxWrapper).tabs();
				Icfes.Comparativas.drawCharts()
			})
	});
  
  
  addListener_registrarPromedioIcfes();
})

