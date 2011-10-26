{if !isset($cod_prueba)}
	{include_template file="simulacros_con_cuestionario" title="Cargar Notas"}
	<div class='ajax-response ajax-buscarUsuario'></div>
{else}
	{if !isset($cedula)}
		{include_template file="persona.form" title="Cargar Notas Simulacro"}
		<input type="hidden" name="cod_prueba" id="cod_prueba" value="{$cod_prueba}"/>
		<div class='ajax-response' id='ajax-cargarNotasSimulacro'></div>
	{else}
	<div class='decorated ui-widget'>
		{if $nombre_persona == null}
			{include_template file='error' message="USUARIO **$cedula** NO HALLADO"|markdown}
		{else}
		<h1>Subir Notas {$nombre_prueba}</h1>
		<h2>{$cedula} - {$nombre_persona}</h2>
			{if $estudianteCalificado}
				<p>El cuestionario de este participante ya ha sido registrado</p>
				<a href="{url_for action=view cod_prueba=$cod_prueba cedula=$cedula}" target="_blank">Consultar Formulario de este Participante</a>
			{elseif $preguntas == null}
				<p>Esta prueba no tiene asociado un cuestionario aún</p>
			{else}
				<form action="{url_for action=save}" method="post" id="form-subirCuestionarioCalificado">
					<input type="hidden" value="{$cedula}" name="cedula"/>
					<input type="hidden" value="{$cod_prueba}" name="cod_prueba"/>
					{foreach from=$preguntas key=nombre_componente item=preguntasComponente}
					<div class="wrapper-respuestasComponente">
						<h5 class='header-nombreComponente ui-state-default'><span class="h-text">{$nombre_componente}</span><span class="icon-status"></span></h5>
						<div class="inner-respuestasComponente hidden">
						{foreach from=$preguntasComponente item=pregunta name="pregunta_componente"}
						<div class="questions-line-field">
							<div  class="ui-field inline pregunta-numeral">
								Pregunta {$pregunta.numeral|zeropad:3}: <input class='input-helper' tabindex="{$smarty.foreach.pregunta_componente.iteration}" style="width:10mm"/>
							</div>
							<div class='letras-respuestas ui-field inline'>
							{foreach from=$letras item=letra}
								<label class="lb-letraRespuesta" for="respuestas_{$pregunta.codigo}_{$letra}">{$letra}</label> 
								<input type="checkbox" value="t" name="respuestas[{$pregunta.codigo}][{$letra}]" id="respuestas_{$pregunta.codigo}_{$letra}"/>
							{/foreach}
							</div>
							<div class='status-icon inline'></div>
						</div>
						{/foreach}
						</div>
					</div>
					{/foreach}
					<div class='ui-button-bar'>
						<button type="button" id="bt-subirCuestionarioCalificado">Aceptar</button>
					</div>
				</form>
			{/if}
		{/if}
	</div>
	{/if}
{/if}
