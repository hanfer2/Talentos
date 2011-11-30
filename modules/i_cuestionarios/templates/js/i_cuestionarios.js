 App.ICuestionariosController = {
	 'check': function(){
		 $("#bt-revisarIngresoDeNotas").click(function(){
			 var cod_prueba = $F("#cod_prueba");
			 //comprobamos que se haya seleccionado una prueba.
			 if( cod_prueba== ''){
				 $.notify("No se ha seleccionado ninguna prueba");
				 return false;
			 }else{
				var ajaxPanel = $(".ajax-response").ajax_img();
				$.get(url_for(), {'cod_prueba':cod_prueba}, function(html){
					ajaxPanel.html(html);
				})// fin $.get
			 };//fin IF
			 
		 });// fin button click
	 }
}
 
var cod_pregunta=1;

$(function(){
  
	cod_pregunta = $(".questions-line-field").length;
	$("#cod_programa",".form-simulacrosSinCuestionario").change(function(){
		jQuery.getJSON(url_for('simulacros_sin_cuestionario'), {'cod_programa': this.value}, function(json){
			json = json || []
			$$("cod_prueba").html(json.toSelect())
		})
	})
	$("#cod_programa",".form-simulacrosConCuestionario").change(function(){
		jQuery.getJSON(url_for('simulacros_con_cuestionario'), {'cod_programa': this.value}, function(json){
			json = json || []
			$$("cod_prueba").html(json.toSelect())
		})
	})
$$("bt-registrarCuestionario").click(function(){
		if($F("#cod_prueba")== ""){
			jAlert("Debe seleccionar una prueba")
			return false;
		}
		$(".ajax-response").ajax_img();
		$.get(url_for(), $("select", "#form-registrarCuestionario").serialize(), function(html){
			$(".ajax-response").html(html)
			cod_pregunta = 1;
		})
	})


/*	
	$$("bt-registrarCuestionario").click(function(){
  var id = $(this).attr('name'); 
   
  var total= id.substring(0,12)+"[codigo]";

  var codigo= $("input[name='"+total+"']").val();
  var caracter = codigo.indexOf("-");
  caracter = codigo.substring(0,caracter+1)
    $("input[name='"+total+"']").val(caracter+$("input[name='"+id+"']").val());

		if($F("#cod_prueba")== ""){
			jAlert("Debe seleccionar una prueba")
			return false;
		}
		$(".ajax-response").ajax_img();
		$.get(url_for(), $("select", "#form-registrarCuestionario").serialize(), function(html){
			$(".ajax-response").html(html)
			cod_pregunta = 1;
     
		})
   
	})*/
	
	$$("bt-consultarCuestionario").click(function(){
			if($F("#cod_prueba") == "")
				jAlert("Debe seleccionar una prueba!", "Error");
			else{
				$(".ajax-response").ajax_img()
				$.get(url_for(), $("#form-consultarCuestionario select").not("#cod_programa").serialize(), function(html){
					$(".ajax-response").html(html)
					cod_pregunta = $(".questions-line-field").length;
					$("input, select","form.bloqueado").attr("disabled", "disabled")
				})
  
			}
	})
	$("input, select","form.bloqueado").attr("disabled", "disabled");
	
	$$("link-adicionarPregunta").live("click", function(){
		cod_pregunta++;
		var zeropadded = zeroPad(cod_pregunta,3);
		var cod_prueba = $("[name=cod_prueba]:hidden","#form-registrarCuestionario").val();
		var question = $(".questions-line-field:last");
   
		var newQuestion = question.clone().insertAfter(".questions-line-field:last")
	
		$("select, input", newQuestion).each(function(){
				var name = this.name.replace(/preguntas\[\d{1,3}\]/, "preguntas["+cod_pregunta+"]")
        //alert(name);
				this.name = name;
        	 
		});
		$(".pregunta-numeral", newQuestion).val(zeropadded)
		$(".pregunta-codigo", newQuestion).val(cod_prueba+"-"+zeropadded)
		$(".pregunta-respuesta:checkbox", newQuestion).attr("checked","")
    $("input[id='numeral']").change(function () {
      var id = $(this).attr('name'); 
   
    var total= id.substring(0,12)+"[codigo]";

  var codigo= $("input[name='"+total+"']").val();
  var caracter = codigo.indexOf("-");
  caracter = codigo.substring(0,caracter+1)
    $("input[name='"+total+"']").val(caracter+$("input[name='"+id+"']").val());
})
		return false;
	})
	
	
	$(".link-removerPregunta").live("click",function(){
		var question = jQuery(this).parents(".questions-line-field")
		if($(this).parents("form").hasClass("bloqueado"))
			return false;
		jConfirm("¿Desea remover esta pregunta?", "Confirmación", function(r){
			if(r){
				question.slideUp(function(){ $(this).remove();})
			}
		})
		return false;
	})
	
	
	$$("bt-reporteDeCuestionarios").click(function(){
		if($F("#cod_prueba")!=""){
			$(".ajax-response").ajax_img();
			$.get(url_for(), {'cod_prueba':$F("#cod_prueba")}, function(html){
				$(".ajax-response").html(html)
			})
		}else{
			jAlert("Debe seleccionar una prueba")
		}
		
	})
	
	$("#submit-actualizarCuestionario").live('click', function(){
		var $form = $("#form-registrarCuestionario")
		var wPanel = $("#wp-verCuestionario");
		var cod_prueba = $("[name=cod_prueba]:hidden", $form).val();
		var cod_componente = $("[name=cod_componente]:hidden", $form).val();
		
		wPanel.ajax_img();
		$.post(url_for('update', {'cod_prueba': cod_prueba , 'cod_componente': cod_componente }), $("select, input", $form).serialize(), function(html){
			wPanel.replaceWith(html);
		})
		return false;
	})
})
