
(function($){
		//al seleccionar un reporte general de areas
		function onAreasGn(){
			if($("#panel-iReporteResumenNiveles").length > 0){
				onAreasGnNiv();
			}
			
			/**
			 * REPORTE RESUMEN GENERAL DE PROMEDIOS ICFES - TOOLBAR 
			 */
			$("#toolbar-mostrarReporte .fg-button").click(function(){
				var target = this.hash;
				var _target = jQuery(target);
				//comprobar que no se esta llamando al panel que ya esta visible.
				if(_target.is(":visible"))
					return false;
				$(".accdn-item:visible","#accdn-i_promedios-r").slideUp()
				_target.slideDown();
				//actualizar el estilo del boton seleccionado
				$("#toolbar-mostrarReporte .ui-state-active").removeClass("ui-state-active");
				$(this).addClass("ui-state-active");
				
				return false;
			});//fin click toolbar
			
			$("#table-i_promedios-r-cursos, #table-i_promedios-r-nEstudiantes").dataTable({
				'fnDrawCallback':DT_group_rows,
				"aaSortingFixed": [[ 0, 'asc' ]],
				"fnInfoCallback": function(oSettings, iStart, iEnd, iMax, iTotal, sPre){
					return iMax+" cursos en Total";
				}
			})
		}
		
		//al seleccionar un reporte general de areas por niveles
		function onAreasGnNiv(){
			$(".table", "#panel-iReporteResumenNiveles").not(".convenciones").dataTable({
				'fnDrawCallback': 	DT_group_rows		}); // fin dataTable
			
			$(".fg-button","#tbnav-i_niveles-r").click(function(){
				var _this = $(this);
				var target = this.hash;
				$("#tbnav-i_niveles-r").find(".ui-state-active").removeClass("ui-state-active");
				_this.addClass("ui-state-active");
				$(".accdn-item:visible","#accdn-i_niveles-r").slideUp();
				$(target).slideDown();
				return false;
			})// fin click fg-button
			$(".accdn-item","#accdn-i_niveles-r").not(".accdn-summary").hide();
			
			$("#link-i_niveles-r-convenciones").click(function(){
				var target = this.hash
				$(target).slideToggle();
				return false;
			})
		}
		
		function onRpteGn(){
			$("#bt-generarReporteGeneralPorComponentes").click(function(){
				$("#ajax-reporteInformeGeneral-componentes").ajax_img()
				$.ajax({
					url:url_for('reporteComponentes'), 
					context:$$("ajax-reporteInformeGeneral-componentes")[0],
					success:function(html){
            $(this).html(html); 
            onAreasGn();
            mostrarGraficas();
          }, 
					data: $(":field","#form-reportePorComponentes").serialize()
					})
				return false;
			})
		}
    
    function mostrarGraficas()
    {
      _mostrarGrafica_PromediosConsolidado();
    }
    
    function _mostrarGrafica_PromediosConsolidado()
    {
      var oTable = $("#table-i_promedios-r-consolidado").dataTable({
        'fnInfoCallback' : function(oSettings, iStart, iEnd, iMax){
          return iMax + ' Grupos';
        }
      });
      var aComponentesMostrables = []
      var aComponentes = [];
      var aoSeries = [];
      
      $("tfoot tr:first", oTable).each(function(){
        $("td:gt(0)", this).each(function(i){
          var jqTd = $(this);
          if(parseFloat(jqTd.html()) > 0)
            aComponentesMostrables.push(i);
        })
      });
      
      $("thead tr:last", oTable).each(function(){
        $("th:gt(0)", this).each(function(i){
          if(aComponentesMostrables.contains(i))
            aComponentes.push($(this).text());
        });
      });
      
      $("tbody tr", oTable).each(function(){
        var jqTr = $(this);
        var oPromedios = {'name': jqTr.find('td:first').text(), 'data': [], 'dataLabels': {'enabled': true,y:50, color:'#FFFFFF', 'formatter': function(){ return this.series.name+'<br/><span style="font-size: 6pt">'+this.y+'</span>'} }};
        jqTr.find("td:gt(0)").each(function(i){
          if(aComponentesMostrables.contains(i)){
            var jqTd = $(this);
            oPromedios.data.push(parseFloat(jqTd.text()));
          }
        });
        aoSeries.push(oPromedios);
      });
      
      var oChartOptions = {
        'chart': {
          'renderTo': 'chart-i_promedios-resumen-consolidado',
          'defaultSeriesType': 'column'
          },
        'title': {'text':'Consolidado Promedios Icfes'},
        'subtitle':{'text': nombre_prueba},
        'xAxis': {'categories': aComponentes, 'title': {'text': '\u00C1reas'}},
        'yAxis': {'title': {'text': 'Promedio Puntajes'}},
        'series': aoSeries,
        'plotOptions': {'column':{'groupPadding':0.05, 'pointPadding':0}},
        'legend':{'floating':true, 'labelFormatter': function(){ return 'Grupo '+this.name}, 'shadow': true, 'y':50 ,'verticalAlign':'top'}
      };
      new Highcharts.Chart(oChartOptions);
    }

  function createReporteDetalladoTabs(){
    var jqTabReporteDetallado = $("#tabs-ReporteDetallado").tabs();
    if(jqTabReporteDetallado.is(".prueba-prueba_oficial"))
      jqTabReporteDetallado.tabs("option", "disabled", [1,2]);
  }
		
	$(function(){
    
		createReporteDetalladoTabs();
		$("#bt-reporteIcfesGeneral").click(function(){
			$$("ajax-form-reporteIcfesGeneral").ajax_img()
			$.get(url_for('reporteDetallado'),$(":field","#form-reporteIcfesGeneral").serialize(), 
				function(html){
					$$("ajax-form-reporteIcfesGeneral").html(html);
					$(".chk-resumen").click()
          createReporteDetalladoTabs();
					onRpteGn();
				});
		})// fin button click

		$("#cod_programa","#form-reportePorCompetencias").change(function(){
			$.get(url_for('icfes','icfes_segun_programa'),{'cod_programa':$F(this)},
			function(html){
				$("#cod_prueba","#form-reportePorCompetencias").replaceWith(html)
			})
			$.get(url_for('icfes','icfes_segun_programa'),{
				'cod_programa':$F(this)
				},
			function(html){
				$("#cod_curso","#form-reportePorCompetencias").replaceWith(html)
				if($("input[value=resumen]","#form-reportePorCompetencias").is(":checked"))
					$("#cod_curso","#form-reportePorCompetencias").disable()
			})
		})

		$("#cod_programa","#form-reportePorComponentes").change(function(){
			$.get(url_for('icfes','icfes_segun_programa'),{
				'cod_programa':$F(this)
				},
			function(html){
				$("#cod_prueba","#form-reportePorComponentes").replaceWith(html)
			})
			$.get(url_for('grupos','cursos_segun_programa'),{'cod_programa':$F(this)},
			
			function(html){
				$("#cod_curso","#form-reportePorComponentes").replaceWith(html)
				if($("input[value=resumen]","#form-reportePorComponentes").is(":checked"))
					$("#cod_curso","#form-reportePorComponentes").disable()
			})
		})

		var formComponente = $("#form-reportePorComponentes")
		var formCompetencia = $("#form-reportePorCompetencias")

		$("#bt-generarReporteDetalladoPorComponentes").click(function(){
			
			if($("#cod_curso",formComponente).is(":enabled") && $F("#cod_curso",formComponente)=='')
				jAlert('DEBE SELECCIONAR UN GRUPO');
			else{
				$("#ajax-reporte").ajax_img();
				$.get(url_for('icfes','reporteComponentes'), $("select, input","#form-reportePorComponentes").serialize(),
					function(msg){
						$("#ajax-reporte").html(msg)
						onAreasGn();
					})
			}
		})

		
		onRpteGn();
		onAreasGn();
	})
	
})(jQuery); //fin funcion anonima
