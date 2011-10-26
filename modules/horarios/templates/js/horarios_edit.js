
var dateFormat = $.datepicker._defaults.dateFormat;
var jsDateFormat = "yyyy-MM-dd";

App.HorariosController = (function($, oController){
  var oCalendar = null;
  var DialogsFactory = {
    'id': "dialog-nuevoHorario",
    'getButtons': function(type, calEvent){
      switch(type){
        case 'new':
          return {
            "Aceptar": function(){
              if(oController.actions._validateNuevoHorarioForm(calEvent)){
                oController.actions.fnCrearHorario();
                $(this).dialog('close');
              }else{
                $.notify("Formulario Invalido");
              }
            }
          };
        case 'edit':
          return {
            "Aceptar": function(){
              var clase = oController._fnAsignarValoresParaClase();
              var events = jQuery("#calendar-editHorarios").fullCalendar("clientEvents", calEvent.id);
              var horario = null;
              events.each(function(item){
                jQuery.extend(item.clase, clase)
                var o = new InterpretaClaseHorario(item.clase);
                item.title = o.content;
                item.className = o.className;
                $("#calendar-editHorarios").fullCalendar("updateEvent", item);
                horario = oController.actions.fnParseToHorario(item);
              })
              Listener.onEditInfoEvent(horario);
              $(this).dialog("close");
            }
          };
      }
    },
    'show': function(type){
      switch(type){
        case 'new':
          return this.showNuevoHorarioDialog;
        case 'edit':
          return this.showEditHorarioDialog;
      }
    },
    /** Reinicia las configuraciones y valores del Formulario*/
    'reset': function(){
      $("input, select, textarea", "#dialog-nuevoHorario").val("");
      $("h3", "#dialog-nuevoHorario").html("");
      var optionDatePicker = {
        "minDate":oController.fecha_inicio,
        "maxDate":oController.fecha_cierre
        };
      $("#horario_fecha_inicio, #horario_fecha_cierre").datepicker("option",optionDatePicker);
			
      jQuery("#horario_fecha_inicio").val(oController.fecha_inicio.toString(jsDateFormat));
      jQuery("#horario_fecha_cierre").val(oController.fecha_cierre.toString(jsDateFormat));
				
    }
  }
  DialogsFactory.defaultSettings = {
    "autoOpen": false,
    "width":320,
    "buttons":DialogsFactory.getButtons('new'),
    "close" : function(){
      DialogsFactory.reset()
      }
  }
	
  DialogsFactory.showNuevoHorarioDialog = function(componenteElement, fechaSeleccionada){

    var dialog = document.getElementById(DialogsFactory.id);
    var cod_componente = jQuery(".item-cod_componente",componenteElement).html();
    var nombre_componente = jQuery(".item-nombre_componente", componenteElement).html();
		
    jQuery("h3", dialog).html(nombre_componente);
		
    document.getElementById("nuevoHorario-cod_componente").value = cod_componente;
    document.getElementById("nuevoHorario-hora_inicio").value = fechaSeleccionada;
		
    jQuery("#wrapper-horario-fechas").show();
    var buttons = DialogsFactory.getButtons('new');
    $(dialog).dialog("option",{
      "title":nombre_componente,
      "buttons": buttons
      }).dialog("open");
				
  };
	
  DialogsFactory.showEditHorarioDialog = function(calEvent){
    var dialog = document.getElementById(DialogsFactory.id);

    $("#wrapper-horario-fechas").hide();
    document.getElementById("horario_sede").value = calEvent.clase.sede;
    document.getElementById("horario_cod_docente").value = calEvent.clase.cod_docente;
    document.getElementById("horario_edificio").value = calEvent.clase.edificio;
    document.getElementById("horario_salon").value = calEvent.clase.salon;
    document.getElementById("horario_anuncios").value = calEvent.clase.anuncios;
		
    $(dialog).dialog("option",{
      "title":calEvent.clase.nombre_componente,
      "buttons":DialogsFactory.getButtons('edit', calEvent)
      }).dialog("open");
		
  }
	
  oController = {
    "semestre":null,
    "cod_curso":null,
    "edit": function(){
      oController._fnInitConfigurarHorarios();
    },
	 
    "actions": {
      "_validateNuevoHorarioForm": function(){
        if($F("#horario_fecha_inicio") ==""){
          jAlert("La fecha de inicio es un campo obligatorio");
          return false;
        }
        var fecha_inicio = $.datepicker.parseDate($.datepicker._defaults.dateFormat,$F("#horario_fecha_inicio"));
        if($F("#horario_fecha_cierre") ==""){
          jAlert("La fecha de cierre es un campo obligatorio");
          return false;
        }
        var fecha_cierre =  $.datepicker.parseDate($.datepicker._defaults.dateFormat,$F("#horario_fecha_cierre"));

        if(fecha_inicio >= fecha_cierre){
          jAlert("La fecha de cierre debe ser posterior a la fecha de inicio");
          return false;
        }
        return true;
      },
      "fnParseToHorario":function(ev){
        return {
          "codigo" : ev.id,
          "cod_docente" : ev.clase.cod_docente,
          "edificio" : ev.clase.edificio,
          "sede" : ev.clase.sede,
          "salon" : ev.clase.salon,
          "hora_inicio" : ev._start.toString("HH:mm:ss"),
          "hora_fin" : ev._end.toString("HH:mm:ss"),
          "dia" : ev._end.getDay()
        }
      },
      "fnExtraerClase": function(ev){
        return{
          "codigo" : ev.cod_clase,
          "fecha" : ev._start.toString(jsDateFormat),
          "anuncios" : ev.clase.anuncios
        };
      },
      "fnCrearHorario": function(dialog){
        var $widget = jQuery("#dialog-nuevoHorario");
        var nombreComponente = $widget.dialog("option","title");
        var codComponente = document.getElementById("nuevoHorario-cod_componente").value;
        var periodicidad = document.getElementById("horario_periodicidad").value;
        var fecha = new Date(document.getElementById("nuevoHorario-hora_inicio").value);
        var dia = fecha.getDay();
					
        var fecha_inicio = Date.parseExact($("#horario_fecha_inicio").val(),jsDateFormat);
        var fecha_cierre = Date.parseExact($("#horario_fecha_cierre").val(),jsDateFormat);
					
        fecha_inicio.addHours(fecha.getHours()).addMinutes(fecha.getMinutes());
        fecha_cierre.addHours(fecha.getHours()).addMinutes(fecha.getMinutes());
        if(fecha_inicio.getDay() != dia)
          fecha_inicio.moveToDayOfWeek(dia);
					
        var clase = oController._fnAsignarValoresParaClase();
        clase['nombre_componente'] = nombreComponente ;
					
        var eventID_counter = 0;
        var eventID = codComponente+oController.cod_curso+oController.semestre;
        var cod_componente_curso = eventID
        do{
          eventID_counter++;
          var eventsInUse = $("#calendar-editHorarios").fullCalendar('clientEvents', eventID+eventID_counter);
        }while(eventsInUse.length > 0)
        eventID +=eventID_counter;
					
        var interpretaClase = new InterpretaClaseHorario(clase);
					
        if(periodicidad=="0")
          fecha_inicio = fecha;
        var cantidadClases = 0;
					
        while(fecha_inicio <= fecha_cierre){
          var eventObject = {
            "id": eventID,
            "title": interpretaClase.content,
            "cod_clase": ""+eventID +zeroPad(cantidadClases,2),
            "clase": clase,
            "start": new Date(fecha_inicio),
            "end": new Date(fecha_inicio.clone().add(2).hours()),
            "className": interpretaClase.className
          };
          $("#calendar-editHorarios").fullCalendar('renderEvent', eventObject, true);
          cantidadClases++;
          if(periodicidad == "0") break;
          fecha_inicio.moveToDayOfWeek(dia);
          if(periodicidad == "2")	fecha_inicio.moveToDayOfWeek(dia);
        }
					
        clases = oCalendar.fullCalendar('clientEvents', eventID);
        var data = [];
					
        var horario = oController.actions.fnParseToHorario(clases[0]);
        horario.cod_componente_curso = cod_componente_curso;
					
					
        jQuery.each(clases, function(i, item){
          data.push(oController.actions.fnExtraerClase(item));
        })
					
        Listener.onCreateHorario(horario, oController.cod_curso, data);
					
        $.notify("Se crearon "+cantidadClases+" clases");
      },
      /** Configura el Datepicker**/
      "_fnSetupDatepicker": function(minimumDate, maximumDate){
        jQuery("#horario_fecha_inicio").val(minimumDate.toString(jsDateFormat))
        jQuery("#horario_fecha_cierre").val(maximumDate.toString(jsDateFormat))
        var dates = jQuery("#horario_fecha_inicio, #horario_fecha_cierre");
        dates.datepicker('option',{
          "onSelect": function(selectedDate){
            selectedDate = $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate);
            var option = null, date=null;
            if(this.id == "horario_fecha_inicio"){
              option =  "minDate";
              date = Math.max(selectedDate, minimumDate);
            }else{
              option =  "maxDate";
              date = Math.min(selectedDate, maximumDate);
            }
            dates.not(this).datepicker("option",option,new Date(date));
          },
          "minDate":minimumDate,
          "maxDate": maximumDate,
          "changeMonth": true,
          "changeYear": false
        });
        return dates;
      },
      "fnConfirmDelete": function(event){
			 
        $("<div class='center'>Selecciona la opción que desee realizar:</div>").appendTo("body").dialog({
          title: "Eliminar Clase",
          width: 700,
          "dialogClass": "confirm-eliminarClase",
          buttons:{
            "Borrar SOLO esta Clase": function(){
              $("#calendar-editHorarios").fullCalendar('removeEvents', function(e){
                return (e.start == event.start && e.id == event.id);
              });
              Listener.onRemoveOneEvent(event.cod_clase);
              $(this).dialog("destroy").remove();
            },
            "Borrar TODA esta serie": function(){
							$("#calendar-editHorarios").fullCalendar('removeEvents', function(e){
								return e.id == event.id && !e.clase.asistencia;
							});
							Listener.onRemoveAllEventsSerie(event.id);
							$(this).dialog("destroy").remove();
            },
            "Cancelar": function(){
              $(this).dialog("destroy").remove();
            }
          }
        })
        $(".confirm-eliminarClase").find(".ui-dialog-buttonpane button:last-child").css("clear","both")
      }
    },
    "_fnAsignarValoresParaClase": function(){
      var clase = {};
      new Array("sede","edificio","salon","cod_docente").each(function(item){
        clase[item] = jQuery("#horario_"+item).val();
      })
      clase['anuncios'] = jQuery("#horario_anuncios").val();
      var codDocenteElement = document.getElementById("horario_cod_docente")
      var idxSelectedOption = codDocenteElement.selectedIndex;
      clase['nombre_docente'] = codDocenteElement.options[idxSelectedOption].text
      return clase;
    },
    "_fnInitConfigurarHorarios": function(){
      var widget = jQuery('#widget-configurar-horarios');
      oCalendar = $("#calendar-editHorarios");
				
      //Confirma que el widget para configurar horarios, esté cargado.*/
      if(widget.length == 0) return false;
					
      //Cargar curso y semestre
      oController.semestre = document.getElementById("horario-semestre-valor").innerHTML;
      oController.cod_curso = document.getElementById("horario-cod_curso").innerHTML;
				
      oController.fecha_inicio = fecha_inicio = Date.parseExact(jQuery("#horario-fechaInicio-valor").html(),jsDateFormat);
      oController.fecha_cierre = fecha_cierre = Date.parseExact(jQuery("#horario-fechaCierre-valor").html(),jsDateFormat);
				
      if(oController.fecha_inicio == null){
        alert("Fecha de Inicio no ha sido aun definida para este semestre. Por favor llene ese campo, para poder definir los horarios ");
        return false;
      }
      if(oController.fecha_cierre == null){
        alert("Fecha de Cierre no ha sido aun definida para este semestre. Por favor llene ese campo, para poder definir los horarios");
        return false;
      }
      var dates = oController.actions._fnSetupDatepicker(fecha_inicio, fecha_cierre);
				
      jQuery(".draggable").draggable({
        zIndex:5,
        revert: true,
        revertDuration: 0
      });
      jQuery("#dialog-nuevoHorario").dialog(DialogsFactory.defaultSettings);
				
      jQuery("#calendar-editHorarios").ajax_img({
        'text':"Cargando Horario"
      });
				
      jQuery.getJSON(url_for('horarios'),
      {
        'cod_curso':$("#horario-cod_curso").text(),
        "semestre":$("#horario-semestre-valor").html()
        },
      function(json){
        horarios = Horario.Grupos.fnProcesarClases(json)
        HorarioEditor.oSettings.events = horarios;
        oCalendar.fullCalendar(HorarioEditor.oSettings).find(".wrapper-loading-ajax").remove()
      });
    }
  }

  HorarioEditor = {
    'oSettings' : {
      "droppable":true,
      "editable": true,
      dropAccept:'#inner-listadoDeComponentes .item-componente',
      "header": {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek'
      }
    }
  };
	
  var oSettings = HorarioEditor.oSettings;
	
  /** When component drops on a day*/
  oSettings.drop = function(date, allDay){
    if(allDay){
      $.notify("Solo es posible crear clases en la Vista 'Semanal'","error");
      return false;
    }
    var fechas = {
      'inicio': oController.fecha_inicio,
      'cierre': oController.fecha_cierre
      };
    if(!date.between(fechas.inicio, fechas.cierre)){
      $.notify('La fecha seleccionada <em>'+date.toString('dd MMM yyyy')+'</em> no pertenece a este semestre', "error");
      return false;
    }
   
    DialogsFactory.show('new')(this, date);
  };
	
  oSettings.eventResize = function(event,dayDelta,minuteDelta,revertFunc){
    if(event.clase.asistencia){
      revertFunc();
      return false;
    }
    var horario = {
      "codigo": event.id,
      "hora_fin": event.end.toString("HH:mm:ss")
    }
    Listener.onResizeEvent(horario);
  },
	
  oSettings.eventDblClick = function(calEvent){
    DialogsFactory.show('edit')(calEvent);
  };
			
  oSettings.eventDrop = function(event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view){
    var hayAsistencia = false;
    events = oCalendar.fullCalendar('clientEvents', event.id);
		
    var clases = [];
    jQuery.each(events, function(i, item){
      if(item.clase.asistencia){
        hayAsistencia = true;
        return false;
      }
      var clase ={
        'codigo': item.cod_clase,
        'fecha': item.start.toString(jsDateFormat)
      };
      clases.push(clase);
    })
    if(hayAsistencia){
      $.notify("No es posible mover clases con asistencias", 'error');
      return revertFunc();
    }
		
    var horario = {
      "codigo": event.id,
      "hora_inicio": event.start.toString("HH:mm:ss"),
      "hora_fin": event.end.toString("HH:mm:ss"),
      "dia":event.start.getDay()
    }
    Listener.onMoveEvent(horario, clases);
  };
	
  oSettings.eventRender = function(event, element){
    Horario.CalendarSettings.fnRenderEvent(event, element);
    var closeIcon = element.find(".ui-icon-close");
    if(event.clase.asistencia == undefined || !event.clase.asistencia){
      closeIcon.click(function(){
        oController.actions.fnConfirmDelete(event);
      })
    }else{
      closeIcon.removeClass('ui-icon-close').addClass('ui-icon-locked')
    }
  }
	
  oSettings.dayDblClick = function(date, allDay, jsEvent, view){
    if(view.name !="month")
      return false;
    oCalendar.fullCalendar('changeView', 'agendaWeek');
    oCalendar.fullCalendar('gotoDate', date);
  }
	
  var Listener = {
		_onSend: function(){
			$.wDialog('show');
		},
		_onComplete: function(){
			$.wDialog('close');
		},
    onCreateHorario: function(horario, cod_curso, data){
			Listener._onSend();
      $.post(url_for("add"),{
        "horario": horario,
        'cod_curso':cod_curso,
        "clases":data
      }, function(){
				Listener._onComplete();
      })
    },
    onRemoveOneEvent: function(cod_clase){
			Listener._onSend();
      $.post(url_for('delete'),{
        "cod_clase":cod_clase
      }, function(){
				Listener._onComplete();
        $.notify("Horario Removido");
      });
    },
    onRemoveAllEventsSerie: function(cod_horario){
			Listener._onSend();
      $.post(url_for('delete'),{
        "cod_horario":cod_horario
      }, function(){
				Listener._onComplete();
        $.notify("Serie Removida");
      });
    },
    onResizeEvent: function(horario){
			Listener._onSend();
      $.post(url_for('update'),{
        "horario":horario,
        'option':'resize'
      }, function(){
				Listener._onComplete();
        $.notify("Horario Actualizado Resize");
      })
    },
    onMoveEvent: function(horario, clases){
			Listener._onSend();
      $.post(url_for('update'),{
        "horario":horario,
        'clases': clases
      }, function(){
				Listener._onComplete();
        $.notify("Horario Actualizado");
      })
    },
    onEditInfoEvent: function(horario){
			Listener._onSend();
      $.post(url_for('update'),{
        "horario":horario
      }, function(){
				Listener._onComplete();
        $.notify("Horario Actualizado");
      })
    }
  }
	
  jQuery(function(){
    $("#bt-configurarHorarios").click(function(){
      var ajaxElement = document.getElementById("ajax-horarios-edit");
      jQuery("#dialog-nuevoHorario").dialog("destroy").remove();
      jQuery(ajaxElement).ajax_img();
      $.ajax({
        "url":url_for(),
        "data": jQuery("#form-configurarHorarios :field").serialize(),
        "context": ajaxElement,
        "success": function(html){
          this.innerHTML = html;
          $("input.date").not(".hasDatepicker").datepicker();
          oController.edit();
        }
      })
      return false;
    });
    
    
		
  })
  
  jQuery(function(){
    $("#bt-configurarHorariosEspeciales").click(function(){
      var ajaxElement = document.getElementById("ajax-horarios-edit");
      jQuery("#dialog-nuevoHorario").dialog("destroy").remove();
      jQuery(ajaxElement).ajax_img();
      $.ajax({
        "url":url_for(),
        "data": jQuery("#form-configurarHorariosEspeciales :field").serialize(),
        "context": ajaxElement,
        "success": function(html){
          this.innerHTML = html;
          $("input.date").not(".hasDatepicker").datepicker();
          oController.edit();
        }
      })
      return false;
    });
		
  })
	
  return {
    edit: oController.edit
    };
})(jQuery, App.HorariosController)

