App.UniversidadesController = {
	add: function(){
		 $("#bt-crearUniversidad").click(function(){
				if($F("#universidad_nombre")=='')
					jAlert("Debe Indicar algun nombre")
				else
					$.post(url_for('universidades','add'),$(":field","#form-crearUniviersidad").serialize(),
								function(html){jAlert(html)})
			})
	}
}

$(function(){
	$("#link-adicionarCarrera").click(function(){
		$("#form-adicionarCarrera").slideToggle('medium')
		return false;
	})
	$("#bt-registrarCarrera").click(function(){
		if($F('#nombre_carrera')=='')
			jAlert('Ingrese un nombre válido para la carrera')
		else{
			$("#nombre_carrera").val(escape($F('#nombre_carrera')).toUpperCase())
			$.post(url_for('carreras','add'),$("input, select","#form-adicionarCarrera").serialize(),
			function(html){jAlert(html,'Transacci\u00F3n Exitosa', function(){
					location.reload()
				})}
		)
		}
	})
})
