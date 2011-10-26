$(function(){
	Componente={
		codigos: [],
		esValido: function(){
			$.validity.start()
			$(".required").require().nonHtml()
			$("#componentes_codigo").match(/^\d{6}$/, "#{field} deben ser 6 numeros")
			if($.isArray(Componente.codigos))
				$("#componentes_codigo").assert(!Componente.codigos.contains($F("#componentes_codigo")), "Este código ya está en uso")
			var result = $.validity.end();
			return result.valid
		}
	}
	if($("#table-listadoComponentes").length==0)
		$.getJSON(url_for('componentes','index'), {
			format:'js'
		}, function(json){
			$.each(json, function(idx, componente){
				Componente.codigos.include(componente.codigo)
			})
		})
	else
		Componente.codigos = $("#table-listadoComponentes").getColumn(0);
	
	

	$("#link-registrarNuevoComponente").click(function(){
		$("#wrapper-nuevoComponente").slideToggle();
		return false;
	})
	$("#bt-registrarNuevoComponente").click(function(){
		$("#componentes_nombre").val($F("#componentes_nombre").toUpperCase())
		if(Componente.esValido())
			$.post(url_for('componentes','create'),$(':field',"#form-registrarNuevoComponente").serialize(),
				function(html){
					jAlert(html, "Alerta", function(r){
						if(r)
							location.reload()
					});
				
				}
				);
	})
})

