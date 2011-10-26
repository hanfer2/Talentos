{if !(isset($cod_curso) and isset($cod_curso))}
	{show_error message='Debe especificar el curso y el componente'}
{elseif empty($clases)}
	<div class='ui-widget decorated'>
		<h1>No se hallaron resultados</h1>
		<p>
			El componente {$nombre_componente} para el curso {$nombre_curso} a&uacute;n no tiene clases reportadas
		</p>
	</div>
{else}
	<h2>{$nombre_componente} - Curso {$nombre_curso}</h2>
	<div id='asistencias-clases-fechas'>
		{foreach from=$clases item=clase}
		<div class='{if in_array($clase.codigo, $clasesRegistradas)}clase-registrada{else}clase-noRegistrada{/if}'>
			<input type='radio' name='cod_clase' id='clase{$clase.codigo}' value='{$clase.codigo}'/>
			<label class='date' for="clase{$clase.codigo}">{$clase.fecha|date_format} </label><span class='ui-icon ui-icon-default ui-icon-check'></span>
		</div>
		{/foreach}
	</div>
	<div class='ui-button-bar'>
		<button id='bt-seleccionarFechaAsistencia'>Aceptar</button>
	</div>
{/if}
