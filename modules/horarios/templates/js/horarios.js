
function InterpretaClaseHorario(clase) {
	this.content ="";		
	this.className="";
	
	this.content += ""+unescape(clase.nombre_componente);

	if(clase.sede != null && clase.sede != "")
		this.content += "\n"+Horario.sedes[clase.sede];
	if(clase.edificio != null && clase.edificio != "")
		this.content += "\nEdif. "+clase.edificio;
	if(clase.salon != null && clase.salon != "")
		this.content += " Salón "+clase.salon;
	if(typeof clase.es_docente != 'undefined')
		this.content += "\nCurso: "+ clase.nombre_grupo
	else if(clase.nombre_docente != null && clase.nombre_docente != "-"){
		this.content +="\nDocente: "+clase.nombre_docente
	}
	if(clase.anuncios != null && !clase.anuncios.isBlank()){
		if(clase.anuncios == 'PENDIENTE')
			this.className += ' fc-event-disabled ';
		else
			this.className += ' fc-event-with-alert ';
	}
	if(clase.asistencia){
		this.className += " fc-event-con-asistencia "
	}
	
}

Horario = {
	sedes:['','Meléndez','San Fernando','Aulas SF','Sta. Mariana'],
	CalendarSettings:{
		fnRenderEvent: 
			function(event, element){
				var title = jQuery(".fc-event-title", element)
				if(event.clase == undefined)
					return;
				if(event.clase.anuncios != null && !event.clase.anuncios.isBlank())
					title.append("<span class= 'event-observacion'>*("+event.clase.anuncios+")</span>")
				if(event.clase.asistencia)
					title.append("<span class='icon-claseConAsistencia'>&#10004;</span>")
			}
		},
	Grupos:{
		_sGrupoActual : null,
		slideComponenteSettings:{
			normal:{
				'font-size':'12pt',
				'color':"#666666"
			},
			selected:{
				'font-size':'18pt',
				'color':"#CC0000"
			}
		},
		fnCreateCalendars: function(){
			$(".full-calendar").fullCalendar(this.calendarSettings)
			$('.wrapper-list-componentes .nombre_componente').draggable({
				revert:true,
				zIndex: 5,
				revertDuration: 0
			})
		},
		fnConfigurarSlideComponente: function(){
			var settings = this.slideComponenteSettings
			$(".nombre_componente").click(function(){
				if($(this).next().is(':visible'))
					return false;
				$(".nombre_componente").css(settings.normal)
				$(this).css(settings.selected)
				$(".wrapper-inner-componente").slideUp()
				$(this).next().slideToggle()
				return false;
			})
			$(".nombre_componente:first").css(settings.selected)
			$(".wrapper-inner-componente::gt(0)").hide()
		},
		fnInit: function(){
			this.fnConfigurarSlideComponente()

			var nGrupoSeleccionado = $("#buttonset-selectGrupos input:radio:checked")
			if(nGrupoSeleccionado.length == 0)
				nGrupoSeleccionado = $("#buttonset-selectGrupos input:radio:first").setChecked(true)
			this.fnOcultarCalendarios()
			this.fnMostrar(nGrupoSeleccionado)
		},
		fnOcultarCalendarios: function(){
			$(".wrapper-full-calendar").fadeOut()
		},
		fnMostrar : function(element){
			var elementID = $(element).id()
			if(elementID == this._sGrupoActual)
				return false;
			this.grupoActual = elementID
			this.fnOcultarCalendarios()
			var letraGrupo = elementID.charAt(elementID.length-1);
			$$("wrapper-full-calendar-"+letraGrupo).fadeIn()
			return true;
		},
		fnRestringirRangoHoras: function(input){
			var $input = $(input)
			var settings = {}
			settings.minTime = $input.hasClass('hora-fin')?
			$input.parent().parent().prev().find('.hora-inicio').timeEntry('getTime') : '06:00'
			settings.maxTime = $input.hasClass('hora-inicio')?
			$input.parent().parent().next().find('.hora-fin').timeEntry('getTime') : '20:00'
			return settings;
		},
		fnProcesarClases: function(clases){
			if(clases == null)
				return null;
			var horarios = [];
			$.each(clases, function(i, clase){
			  if(clase.hora_inicio == null)
			  	return true;
			  
			  var o = new InterpretaClaseHorario(clase);
  
				var observacion = null;

				var date_format = "yyyy-MM-dd,HH:mm:ss"
				var startDay = Date.parseExact(clase.fecha+','+clase.hora_inicio, date_format)
				var end =  Date.parseExact(clase.fecha+','+clase.hora_fin, date_format)
				
				var evento = {
					'id':clase.cod_horario,
					'title': o.content,
					'start': startDay,
					'end': end,
					'allDay': false,
					'cod_clase':clase.cod_clase,
					'className': o.className,
					'clase': clase
				}

				horarios.push(evento)
			})
			return horarios
		},
		fnConfigurarLeerHorario: function(){
			if(typeof $.fn.fullCalendar != 'undefined'){
				if($("#link-cedula").length == 0)
					Horario.Grupos.fnLeerHorario({
						'cod_curso':$("#sp-cod_curso").text()
					});
				else
					Horario.Grupos.fnLeerHorario({
						'cedula':$("#link-cedula").text()
					});
			}
		},
		fnLeerHorario : function(param){
			var horarios = null;
			$(".fullCalendar").ajax_img();
			$.getJSON(url_for('horarios','view'),$.extend({
				'load':true
			},param),function(json){
				horarios = Horario.Grupos.fnProcesarClases(json)
				if(horarios != null)
					$(".fullCalendar").fullCalendar({
						editable: false,
						aspectRatio:1.96, 
						defaultView:'agendaWeek',
						events: horarios,
						eventRender: Horario.CalendarSettings.fnRenderEvent,
						eventClick: function(ev){
							var timeWindow = $(this).find(".fc-event-time").text()
							var title = ev.title.replace(/\n/g,"<br/>")
							var text = "<div class='popup-info-horario'>"+title+"</div><div>"+"Hora: "+timeWindow+"</div>"
							if(ev.clase.observaciones_horario != null)
								text += "<div class='popup-observacion observacion'>Nota: "+ev.clase.observaciones_horario+"</div>"
							if(ev.clase.asistencia)
								text += "<span class='text-asistenciaRegistrada'> &#10004; Asistencia Registrada</span>"
							if(ev.clase.sede == 3)
								text += "Dir: Cra 36 N° 4 - 12"
							var popup = $("<div class='wrapper-popup-infoClase'/>").html(text)
							popup.dialog({
								modal:true, height:270,
								title : 'Horario '+ev.clase.nombre_componente,
								dialogClass: ' fc-event-popup',
								onClose: function(){
									$(popup).remove()
									}
							})
						}
					})
				else{
					$(".fullCalendar").html("NO TIENE HORARIOS ASIGNADOS")
				}
				$(".fullCalendar .wrapper-loading-ajax").remove();
			})

		}
	}
}

$(function(){
	$$("bt-horariosPorCursos").click(function(){
		$.get(url_for('horarios','view'),{
			'cod_curso':$F("#cod_curso","#form-horariosPorCursos")
			},
		function(html){
			$(".ajax-response").html(html)
			Horario.Grupos.fnConfigurarLeerHorario()
		})
	})
	Horario.Grupos.fnConfigurarLeerHorario()
	$$("bt-horarios").click(function(){
		$.get(url_for('horarios','index'),{
			cod_curso:$("#cod_curso","#form-horarios").val()
		})
	})
})

