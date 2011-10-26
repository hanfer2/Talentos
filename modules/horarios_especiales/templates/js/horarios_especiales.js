hCtrl = App.createController('horarios_especiales');

hCtrl.addAction('view', function(){
  $("#bt-horariosCursosEspeciales").click(function(){
    var jqAjax = $("#ajax-horarios").ajax_img();
    $.get(url_for(), {'cod_curso': $F("#cod_curso")}, function(html){
      jqAjax.html(html);
      hCtrl.triggerEvent('view.showCalendar');
    })
  });
    
  this.addListener('view.showCalendar', function(){
      $("#fullcalendar-horarios_especiales").fullCalendar({event:[]});
  })
    
  this.triggerEvent('view.showCalendar');    
});

hCtrl.addAction('edit', function(){
  $("#bt-editarHorariosEspeciales").click(function(){
    var jqAjax = $("#ajax-horarios").ajax_img();
    $.get(url_for(), {"cod_curso":$F("#cod_curso")}, function(html){
      jqAjax.html(html);
      hCtrl.triggerEvent('edit.showCalendar');
      App.HorariosController.edit();
    })
  });
  
  this.addListener('edit.showCalendar', function(){
      $("#fullcalendar-horarios_especiales").fullCalendar({ });
  })
});
