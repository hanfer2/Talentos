Observaciones = {
	checkNew: function(){
		$$("form-nuevaObservacion").validity(function(){
      alert("textarea.value")
			$("input.required, textarea").require()
      
		})
	}
}

$(function(){
	$$("bt-listadoDeObservaciones").click(function(){
		$(".ajax-response").ajax_img()
		$.get(url_for(), {"cod_programa":$F("#cod_programa")}, function(html){
			$(".ajax-response").html(html)
		})
	})
	
	$(".link-eliminarObservacion").live("click", function(){
   var prueba1 = document.getElementById("prueba1");

   var posicion= prueba1.href.indexOf('#');
   
    var codigoEnviar = prueba1.href.substring(posicion+1, prueba1.href.length);

		jConfirm("Está seguro de eliminar esta observacion?", "Confirmacion", function(r){
			if(r)
    
				$.post(url_for('delete'), {"cod_observacion":codigoEnviar}, function (){$$("observacion-"+codigoEnviar).slideUp(function(){$(this).remove()})})
		
      })
		
		return false;
	})
	
	$$("bt-listadoDeObservacionesIndividual").click(function(){
		cedula = $F("#input-buscarPorCedula")
		if(cedula.length > 3 && !isNaN(cedula)){
			$(".ajax-request").ajax_img()
			$.post(url_for('view'), {"cedula":cedula}, function(html){
				$(".ajax-request").html(html)
			})
		}
	})
	
	$$("link-toggleNuevaObservacion").live('click', function(){
		$$("wrapper-form-nuevaObservacion").slideToggle()
	})

/*	Observaciones.checkNew()
	$(".ajax-request").ajaxSuccess(function(){
		Observaciones.checkNew()
	})*/
})

