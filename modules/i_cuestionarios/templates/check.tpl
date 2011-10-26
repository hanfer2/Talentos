{if !isset($cod_prueba)}
	{include_template file="simulacros_con_cuestionario" title="Revisar Ingreso de Notas"}
	<div class='ajax-response'></div>
{else}
	<div class="ui-widget decorated">
		<h1>Cuestionario - Prueba {$nombre_prueba}</h1>
		<h3>{$nombre_programa}</h3>
		{if $estaCalificada}
		<div class="notification-flash ui-widget ui-state-error ui-corner-all">
			<span class='ui-icon ui-icon-alert inline-icon'></span>
			<strong class="text-notice-label">Advertencia:</strong> Esta prueba tiene registros calificados. Por lo cual no es posible realizar modificaciones.
		</div>
		{/if}
		<div>
		 {if empty($preguntas)}
			<p>Este simulacro no tiene un cuestionario registrado</p>
			<div class="ui-toolbar">
				<a href="{url_for action=add cod_prueba=$cod_prueba}">Registrar Cuestionario a esta prueba</a>
			</div>
		 {else}
		 <form action="{url_for action=update}" method="post" id="form-registrarCuestionario" onsubmit="return confirmarCreacionCuestionario();" class='{if $estaCalificada}bloqueado{/if} ui-form'>
		 {foreach from=$preguntas item=pregunta name=preguntas}
				{include file='add.form.tpl' pregunta=$pregunta componentes=$componentes cualitativos=$cualitativos competencias=$competencias letras=$letras flag=$smarty.foreach.preguntas.iteration}
		 {/foreach}
		 			<div>
		 		{if !$estaCalificada}
				<span class='link-icon-plus'>+</span> <a href='#' id="link-adicionarPregunta">Agregar Nueva Pregunta</a>
				{/if}
			</div>
			<input type="hidden" name="cod_prueba" value="{$cod_prueba}"/>
			<br/>
			{if !$estaCalificada}
			<div class='ui-button-bar'>
				<button id="submit-actualizarCuestionario">Aceptar</button>
			</div>
			{/if}
		</form>
		 {/if}
		</div>
	</div>
{/if}
