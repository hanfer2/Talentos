<div class='questions-line-field ui-form-inline {if $pregunta.valida neq 't'}ui-state-disabled{/if}'>
	<div class='ui-field cabecera-pregunta'>
    
		<label>Pregunta:</label>
		<input name="preguntas[{$flag}][numeral]" class="pregunta-numeral" value="{$pregunta.numeral|default:1|zeropad:3}" maxlength="3" size="10" id="numeral"/>
         <!---->
	</div> 
	<div class='ui-field'><label>Área:</label>
		{html_select name="preguntas[$flag][cod_componente]" options=$componentes  class="pregunta-componente"  selected=$pregunta.cod_componente|default:1}
	</div>
	<div class='ui-field'><label>Componente:</label>
		{html_select name="preguntas[$flag][cod_cualitativo]" options=$cualitativos  class="pregunta-cualitativo" selected=$pregunta.cod_cualitativo}
	</div>
	
	<div class='ui-field'><label>Competencia:</label>
		{html_select name="preguntas[$flag][cod_competencia]" options=$competencias class="pregunta-competencia" selected=$pregunta.cod_competencia}
	</div>
	<div class='ui-field inline'>
	<label class='label-title'>Respuesta Correcta:</label>
	{foreach from=$respuestas item=letra}
		{assign var=respuestasCorrectas value=","|explode:"`$pregunta.respuesta`"}
		<span>{$letra} <input type='checkbox' name='preguntas[{$flag}][respuesta][]' value="{$letra}" class="pregunta-respuesta" {if in_array($letra, $respuestasCorrectas)}checked="checked"{/if}/></span>
	{/foreach}
	</div>
	<div class='ui-field'>
	<label>V&aacute;lida</label>
	<input type='checkbox' name='preguntas[{$flag}][valida]' {if $pregunta.valida neq 'f'}checked="checked{/if}" value="t" class="pregunta-valida"/>
	</div>
	{if not $estaCalificada}
	<div class="inline"> <a href="#" class='link-removerPregunta' title="Eliminar Pregunta"><span class='ui-icon ui-icon-close ui-icon-error inline-icon'></span></a></div>
	{/if}
	<input  name="preguntas[{$flag}][codigo]" value="{$pregunta.codigo}" class="pregunta-codigo" id="codigoo"/>
</div>
{literal}
 <script>

  $("input[id='numeral']").change(function () {
   // alert("aqui");
      var id = $(this).attr('name'); 
   
    var total= id.substring(0,12)+"[codigo]";

  var codigo= $("input[name='"+total+"']").val();
  var caracter = codigo.indexOf("-");
  caracter = codigo.substring(0,caracter+1)
    $("input[name='"+total+"']").val(caracter+$("input[name='"+id+"']").val());
})

</script>
{/literal}

