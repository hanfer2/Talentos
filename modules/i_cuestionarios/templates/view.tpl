{if !isset($cod_prueba)  or !isset($cod_componente)}
	{capture assign=componentes_field}
		<div class="ui-field">
      <label for="cod_componente">Componente</label>
      {html_select name='cod_componente' options=$componentes}
    </div>
	{/capture}
	{include_template file="simulacros_con_cuestionario" title="Consultar Cuestionario" moreFields=$componentes_field}
	<div class='ajax-response'></div>
{else}
	<div class="ui-widget decorated" id="wp-verCuestionario">
		<h1>Cuestionario - Prueba {$nombre_prueba}</h1>
		<h2>{$nombre_componente|default:"TODOS LOS COMPONENTES"}</h2>
		<h3>{$nombre_programa}</h3>
		{if $estaCalificada}
		<div class="notification-flash ui-widget ui-state-error ui-corner-all">
			<span class='ui-icon ui-icon-alert inline-icon'></span>
			<strong class="text-notice-label">Advertencia:</strong> Esta prueba tiene registros calificados. Por lo cual no se podrá adicionar ni eliminar preguntas.
		</div>
		{/if}
		<div>
		 {if empty($preguntas)}
			<p>Este simulacro no tiene un cuestionario registrado</p>
			<div class="ui-toolbar">
				<a href="{url_for action=add cod_prueba=$cod_prueba}">Registrar Cuestionario a esta prueba</a>
			</div>
		 {else}
		 <form action="{url_for action=update cod_prueba=$cod_prueba cod_componente=$cod_componente}" method="post" id="form-registrarCuestionario" onsubmit="return confirmarCreacionCuestionario();" class='ui-form'>
		 {foreach from=$preguntas item=pregunta name=preguntas}
				{include file='add.form.tpl' pregunta=$pregunta letras=$letras flag=$smarty.foreach.preguntas.iteration}
		 {/foreach}
		 			<div>
		 		{if !$estaCalificada}
				<span class='link-icon-plus'>+</span> <a href='#' id="link-adicionarPregunta">Agregar Nueva Pregunta</a>
				{/if}
			</div>
			<input type="hidden" name="cod_prueba" value="{$cod_prueba}"/>
			<input type="hidden" name="cod_componente" value="{$cod_componente}"/>
			<br/>
			<div class='ui-button-bar'>
				<button id="submit-actualizarCuestionario">Aceptar</button>
			</div>
		</form>
		 {/if}
		</div>
	</div>
{/if}
