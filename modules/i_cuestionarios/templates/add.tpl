{if !isset($cod_prueba)}
	{include_template file='simulacros_sin_cuestionario' title='Registrar Cuestionario'}
	<div class='ajax-response'></div>
{elseif isset($preguntas)}
	<p>{$message}</p>
{else}
	<div class='ui-widget decorated'>
		<h1>Creaci&oacute;n del Cuestionario</h1>
		<h2>{$nombre_prueba}</h2>
		<form action="{url_for action=add}" method="post" id="form-registrarCuestionario" >
			{include_partial file='add.form.tpl' module="i_cuestionarios" componentes=$componentes cualitativos=$cualitativos competencias=$competencias letras=$letras flag=1 }
			<div>
				<span class='link-icon-plus'>+</span> <a href='#' id="link-adicionarPregunta">Agregar Nueva Pregunta</a>
			</div>
			<input type="hidden" name="cod_prueba" value="{$cod_prueba}"/>
			<br/>
			<div class='ui-button-bar'>
				<button id="submit-registrarCuestionario">Aceptar</button>
			</div>
      <div class="date date-report">Realizado: {'now'|date_format:$smarty.const.TIMESTAMP_FORMAT|escape}</div>
		</form>
	</div>
{/if}
