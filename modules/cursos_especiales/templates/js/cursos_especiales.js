ceCtrl = App.createController("cursos_especiales");

ceCtrl.addAction("index", function(){
  this.addListener('index.display', function(){
    $("#bt-listadoCursosEspeciales").click(function(){
      var jqAjax = $("#ajax-listadoCursosEspeciales").ajax_img();
      $.get(url_for(),{"cod_programa":$F("#cod_programa")}, function(html){
        jqAjax.html(html);
        $(".dataTable").dataTable();
        ceCtrl.triggerEvent('add.display');
      })
    });
  });
  this.addListener('add.display', function(){
    $("#link-agregarCursoEspecial").click(function(){
      $("#form-agregarCursoEspecial").slideToggle();
      return false;
    });
  });
  this.triggerEvent('index.display','add.display');
})
