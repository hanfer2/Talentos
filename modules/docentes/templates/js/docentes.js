var docentesCtrl = App.createController('docentes');

docentesCtrl.addAction('cursos',function(){
	this.addListener('docentes_cursos.list', function(){
		$("#table-cursosDocente").dataTable({
			'fnDrawCallback':DT_group_rows,
			"aaSortingFixed": [[ 0, 'asc' ]],
		  })
	});

  $("#bt-listadoDocentesCursos").click(function(){
    $("#ajax-listadoDocentesCursos").ajax_img();
		$.post(url_for(), {'cod_componente':$("#cod_componente").val(), 'cod_programa':$("#cod_programa").val() }, function(html){
			$("#ajax-listadoDocentesCursos").html(html);
			docentesCtrl.triggerEvent('docentes_cursos.list');
		});
	});
  
});

docentesCtrl.addAction('index', function(){
  this.addListener('docentes.list', function(){
    $(".dataTable").dataTable();
  });
  
  $("#bt-listadoDeDocentes").click(function(){
    $("#ajax-listadoDeDocentes").ajax_img();
    $.post(url_for(), {'cod_programa': $("#cod_programa").val()}, function(html){
      $("#ajax-listadoDeDocentes").html(html);
      docentesCtrl.triggerEvent('docentes.list');
    });
  });
	
});
