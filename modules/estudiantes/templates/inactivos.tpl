{if empty($cod_programa)}
	{include_template file="programa.form" title="Informe de Inactivos"}
		<div class='ajax-request'></div>
{else}
	<div class='ui-widget decorated'>
		<h1>Informe de Inactivos</h1>
		<h2>{nombre_programa}</h2>
		<h4>{"now"|date_format}</h4>
		{if empty($inactivos)}
			<p>No se hallaron estudiantes inactivos</p>
		{else}
			<table id='table-listadoEstudiantesInactivos' class='table dataTable'>
			<thead>
				<tr>
					<th>Doc. Id</th><th>Nombres</th>
					<th class='column-select-filter'>Curso</th>
					<th class='column-select-filter'>Causa de Bloqueo</th>
					<th class='column-select-filter'>Registrado Por</th>
					<th>Fecha</th><th class='column-select-filter'>Autorizado Por</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$inactivos item=inactivo}
				<tr>
					<td>{persona_url cedula=$inactivo.cedula}</td>
					<td>{$inactivo.fullname|escape}</td><td>{$inactivo.nombre_grupo}</td>
					<td>{$inactivo.nombre_motivo|default:"NO DEFINIDO"|escape}</td>
					<td>{$inactivo.nombre_actualizado_por|default:"NO DEFINIDO"|escape}</td>
					<td class='date'>{$inactivo.fecha|date_format}</td>
					<td>{$inactivo.autorizado_por|default:"NO DEFINIDO"|escape}</td>
				</tr>
			{/foreach}
			</tbody>
			</table>
		{/if}
		<div class='date date-report'>
			realizado: {"now"|date_format:#TIMESTAMP_FORMAT#}
		</div>
	</div>
{/if}
