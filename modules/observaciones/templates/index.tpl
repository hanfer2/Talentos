{if !isset($cod_programa)}
	{include_template file="programa.form" title="Listado de Observaciones"}
	<div class='ajax-response'></div>
{else}
<div class='ui-widget decorated'>
	<h1>Listado de Participantes con Observaciones</h1>
	<h2>{nombre_programa cod_programa=$cod_programa}</h2>
	{if empty($estudiantes)}
			{include_template file="no_results"}
	{else}
		<table class='table dataTable' id='table-listadoObservaciones'>
		<thead>
			<tr><th>Doc.ID</th><th>Nombre</th><th>Tel&eacute;fonos</th><th>Observaciones</th><th>Memos</th><th>TOTAL</th></tr>
		</thead>
		<tbody>
		{foreach from=$estudiantes item=estudiante}
			<tr>
				<td>{persona_url cedula=$estudiante.cedula}</td>
				<td>{link_to name=$estudiante.fullname action=view cedula=$estudiante.cedula}</td>
				<td>{$estudiante.telefono}</td>
				<td>{$estudiante.total_observaciones}</td>
				<td>{$estudiante.total_memos}</td>
				<td>{math equation="x+y" x=$estudiante.total_observaciones y=$estudiante.total_memos}</td>
			</tr>
		{/foreach}
		</tbody>
		</table>
	{/if}
</div>
{/if}
