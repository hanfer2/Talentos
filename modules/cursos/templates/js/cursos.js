cursosCtrl = App.createController('Cursos');

function verNotificaciones(){
   var $notificationsDialog = null;
      
      $("#link-verNotificaciones").click(function(){
        var target = this.hash.substr(1);
        var param = {};
        if(isBlank(target))
          param['global'] = 1;
        else if(target.match(/^\d+$/)){
          param['cod_curso'] = target;
        }else if(target.match(/^[A-Z]$/)){
          param['cod_grupo'] = target;
        }
        //Si no esta inicializado el cuadro de dialogo, crearlo;
        //de lo contrario, solo invocarlo
        if($notificationsDialog == null){
          $notificationsDialog = $("<div/>").ajax_img().dialog({
            'width': 600,
            'title': 'Listado de Notificaciones',
            'buttons':{
              'Aceptar': {'icons':'ui-icon-check', 'action':function(){$(this).dialog('close');}}
            },
            'close': function(){
              //al cerrar, vaciar el formulario.
              oENotifs.hideNewForm();
            }
          });
          
          $.when(
          //Cargamos las librerias necesarias.
            $.getScript(App.paths.js+"jquery.ui.datepicker.min.js"), 
            $.getScript(url_script("estudiantes_notificaciones"))
          ).done(function(){
              //Al estar listas las librerias,
              //Invocamos el panel de notificaciones.
              $.get(url_for('estudiantes_notificaciones','view'), param, function(html){
                $.addStyleSheet('estudiantes_notificaciones');
                $notificationsDialog.html(html);
                App.EstudiantesNotificacionesController.view();
              })
          })// fin $.when

        }else{
          $notificationsDialog.dialog("open");
        }// fin IF
        return false;
      });// fin click
}

cursosCtrl.addAction('index', function(){
    this.addListener('verNotificaciones',verNotificaciones);
    
    this.addListener('bt-listadoCursos', function(){
      $("#bt-listadoDeCursos").click(function(){
        $(".ajax-response").ajax_img()
        $.get(url_for('cursos','index'),{cod_programa:$F("#cod_programa","#form-listadoDeCursos")}, function(html){
          $(".ajax-response").html(html);
          cursosCtrl.triggerEvent("verNotificaciones");
        })
      })
    })
    this.triggerEvent('bt-listadoCursos');
    this.triggerEvent("verNotificaciones");
})
cursosCtrl.addAction('view', function(){
  this.addListener('verNotificaciones',verNotificaciones);
  this.triggerEvent("verNotificaciones");
});
$(function(){
    cursosCtrl.triggerEvent('bt-listadoCursos');
    cursosCtrl.triggerEvent("verNotificaciones");
})
