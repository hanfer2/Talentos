<h2 class="ui-state-default">Por Colegios</h2>
<table class='table dataTable table-reporte' id='table-informe-Colegios' title='Informe por Colegios'>
	<thead>
		<tr>
			<th class='column-unsortable toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggleAll-icon'></span></th>
			<th>Colegios</th><th>Cantidad</th><th>%</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$oInforme->reporte.colegios.colegios key=cod_colegio item=colegio}
			<tr id='row-informe-colegios-{$cod_colegio}'>
				<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon'></span></td>
				<td>{$cod_colegio} - {$colegio.info.nombre_colegio|escape} ({$colegio.info.tipo_colegio|default:"NO DEFINIDO"|escape})</td>
				<td>{$colegio.estudiantes|@count}</td>
				<td>{math equation="cantidad*100/nTotal" format=#PERCENT_FORMAT# cantidad=$colegio.estudiantes|@count nTotal=$oInforme->total }</td>
			</tr>
		{/foreach}
	</tbody>
	<tfoot>
		<tr><td></td><td>TOTAL Instituciones Oficiales: </th><td>{$oInforme->reporte.colegios.totales.OFICIAL}</td><td></td></tr>
		<tr><td></td><td>TOTAL Instituciones Privadas: </th><td>{$oInforme->reporte.colegios.totales.PRIVADO}</td><td></td></tr>
	</tfoot>
</table>

<div class='ui-helper-hidden' id='wrapper-informe-EstudiantePorColegios'>
	{foreach from=$oInforme->reporte.colegios.colegios key=cod_colegio item=colegios}
	<div id='wrapper-informe-EstudiantesPorColegio-{$cod_colegio}'>
	<table class='table table-helper-estudiantesPorColegio' >
		<thead><tr><th>Doc. Id</th><th>Nombre</th><th>Curso</th></tr></thead>
		<tbody>
		{foreach from=$colegios.estudiantes item=estudiante}
			<tr><td>{persona_url cedula=$estudiante.cedula}</td><td>{$estudiante.fullname|escape}</td><td>{$estudiante.nombre_grupo}</td></tr>
		{/foreach}
		</tbody>
	</table>
	</div>
	{/foreach}
</div>
