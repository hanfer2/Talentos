App.EgresadosController._configurarFormulario = function(){
	var $form = $("#form-ies");
	if ($form.length == 0)
		return false;

	Ciudad = {
		"onSearch": url_for("ciudades","index"),
		"onSelect": function(ev, ui){
			$("#nombre_ciudad").val(ui.item.nombre).removeClass("error");
			$("#cod_ciudad").val(ui.item.codigo);
			Universidad.onReset();
			return false;
		},
		"onReset":  function(){
			$("#panel-Universidad input").val("");
		}
	};
	Universidad = {
		'onSearch': function(request, response){
				var q = request['q'].toUpperCase();
				//comprobar si es alguna de las universidades principales.
				var cod_ciudad = $F("#cod_ciudad");
				if(cod_ciudad == App.constants.COD_CIUDAD_CALI){
					if(alias_universidades[q] != undefined){
						response(new Array(universidades_info[alias_universidades[q]]));	
						return;	
					}
					if(universidades_info[q] != undefined){	
						response(new Array(universidades_info[q]));	
						return;	
					}
				}
				//En caso contrario, buscar en la BD
				$.getJSON(url_for('universidades','index'), {"q": q, 'cod_ciudad': cod_ciudad}, function(data){response(data)});
			},
		"onSelect": function(ev, ui){
			$("#nombre_universidad").val(ui.item.nombre).removeClass("error");
			$("#cod_universidad").val(ui.item.codigo);
			Carrera.onReset();
			return false;
		},
		"onReset": function(){
			$("#panel-Universidad input").val("");
			Carrera.onReset();
		}
	};
	Carrera = {
		'onSearch': function(request, response){
				var cod_ciudad = $F("#cod_ciudad");
				var cod_universidad  = $F("#cod_universidad");
				var q = request['q'].toUpperCase();
				
				$.getJSON(url_for('carreras','index'), 
					{"q": q, 'cod_ciudad': cod_ciudad, 'cod_universidad':cod_universidad}, 
					function(data){ response(data)}
				);
			},
		"_onSelect": function(item){
			$("#nombre_carrera").val(item.nombre).removeClass("error");
			$("#cod_carrera").val(item.codigo);
			return false;
		},
		"onSelect": function(ev, ui){
			return Carrera._onSelect(ui.item);
		},
		"onReset": function(){
			$("#panel-Carrera input").val("");
		}
	};
	
	// informacion de las universidades mas empleadas.
	var $nombre_ciudad = $("#nombre_ciudad");
	var universidades_info = {
		'UNIVALLE':{'codigo': '1203', 'nombre': 'UNIVERSIDAD DEL VALLE'}, 
		'SENA':{'codigo':'9111', 'nombre':'SERVICIO NACIONAL DE APRENDIZAJE-SENA'}
	};
	
	var alias_universidades = {'VAL':'UNIVALLE','VALL':'UNIVALLE','VALLE':'UNIVALLE', 'SEN':'SENA'};
	
	/* AUTOCOMPLETAR CIUDADES*/
	
	$("#nombre_ciudad").autocomplete({
		"source": Ciudad.onSearch, 'minLength': 3,
		"select": Ciudad.onSelect	})
	.keydown(function(){$("#cod_ciudad").val(""); Universidad.onReset();});
	
	/* AUTOCOMPLETAR UNIVERSIDADES*/
	var $nombre_universidad = $("#nombre_universidad")
	$("#nombre_universidad").autocomplete({
		"source": Universidad.onSearch, 'minLength': 3,
		"search": function(){if(isBlank($F("#cod_ciudad"))) return false;},
		'select': Universidad.onSelect
		
	}).keydown(function(ev){
		if(ev.keyCode == '9')
			return true;
		if(isBlank($F("#cod_ciudad"))){
			$nombre_ciudad.addClass("error")
			return false;
		}
		$("#cod_universidad").val(""); 
		Carrera.onReset();
	});
	
	/* AUTOCOMPLETAR CARRERAS*/
	var $nombre_carrera = $("#nombre_carrera")
	$("#nombre_carrera").autocomplete({
		"source": Carrera.onSearch, 'minLength': 3,
		"search": function(){if(isBlank($F("#cod_universidad"))) return false;},
		'select': Carrera.onSelect
	}).keydown(function(ev){
		if(ev.keyCode == '9')
			return true;
		if(isBlank($F("#cod_universidad"))){
			$nombre_universidad.addClass("error")
			return false;
		}
		$("#cod_carrera").val(""); 
	});
	
	//Configurar la ventana de dialogo "Mostrar todas las carreras".
	(function($widget){
		$widget.dialog({'autoOpen': false, 'title':'Listado de Universidades', "width":700});
	})($("#widget-mostrarTodasCarreras"));
	
	//Adicionar validaciones antes de enviar el formulario.
	$("#bt-registrarEgresadoIES").click(function(){
		var iVacios = $("#panel-campos-dinamicos :hidden:blank").length;
		if(iVacios != 0 ){
			jAlert("Se debe indicar la Universidad y la Carrera a la que ingresa el estudiante");
			return false;
		}
		else{
			$("#loading-message").ajax_img({text:"Registrando Egresado"});
			$.post(url_for('egresados','create'), $("input, select","#form-ies").serialize(), function(html){
				$(".ajax-response").html(html);
				App.EgresadosController.view();
			})
		}
	})
	
	$("#fecha_ingreso").datepicker({'maxDate':'+0'});
	$("#icon-mostrarTodasCarreras").click(function(){
		var cod_universidad = $F("#cod_universidad");
		var cod_ciudad = $F("#cod_ciudad");
		var pattern = $F("#nombre_carrera");
		if(isBlank(cod_universidad)){
			jAlert("Se debe seleccionar primero la Universidad", "Alerta");
			return false;
		}
		$.get(url_for("universidades","carreras"), 
					{"cod_universidad": cod_universidad,'display_format':'min', 'cod_ciudad': cod_ciudad, 'pattern':pattern}, 
					function(html){
						var $widget = $("#widget-mostrarTodasCarreras");
						$widget.html(html).dialog("open")
						.find("td a").click(function(){
							var item = {};
							item.nombre = this.innerText;
							item.codigo = this.previousSibling.innerText;
							Carrera._onSelect(item);
							$widget.dialog('close');
							return false;
						});
						
					}
		);
		return false;
	});
}

$(function(){
	App.EgresadosController._configurarFormulario();
})
