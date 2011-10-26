{if !isset($cod_programa) && $cod_curso == null}
	{if !isset($cod_curso)}
    {include_template file='programa.form' title='Listado de Inasistencias Colectivo'}
	{else}
			{include_template file='curso.form' title='Listado de Inasistencias Colectivo por Curso'}
	{/if}
	<div class='ajax-response' id='ajax-listadoDeInasistenciasColectivo'></div>
{elseif empty($inasistencias)}
	<p>No hay Inasistencias Reportadas</p>
{else}
<div class='ui-widget decorated'>
{link_open_external}
<h1>Reporte Global de Inasistencias</h1>
<h2>{nombre_programa cod_programa=$cod_programa}</h2>
{if isset($cod_curso)}<h3>Curso {$nombre_curso}</h3>{/if}
{assign var=cantidadMotivosJustificados value=$motivos.t|@count}
{assign var=cantidadMotivosInjustificados value=$motivos.f|@count}
{*
<div class='sub-header-text'>Cantidad de Clases Dictadas: {$inasistencias[0].reporte.total}</div>	
*}
<div class="ui-toolbar table-toolbar">
	<span class="ui-icon nuvola-ui-icon ui-nuvola-tools"></span>
</div>
<table class='table dataTable non-paginable' id='table-inasistenciasGeneral'>
<thead>
	<tr>
		<th rowspan='3'>Doc. Id</th><th rowspan='3'>Nombres</th><th rowspan='3'>Tel&eacute;fono</th>
		<th rowspan='3'>G&eacute;nero</th><th rowspan='3'>Edad</th>
		{if !isset($cod_curso)}<th rowspan='3'>Curso</th>{/if}<th  rowspan='3'>Asistencias</th>
		<th colspan='{$cantidadMotivosJustificados+$cantidadMotivosInjustificados+3}'>INASISTENCIAS</th>

	</tr>
	<tr>
		<th colspan='{$cantidadMotivosJustificados+1}'>JUSTIFICADAS</th>
		<th colspan='{$cantidadMotivosInjustificados+1 }'>INJUSTIFICADAS</th>
		<th class='column-total' title='Total de Inasistencias' rowspan='2'>TOTAL</th>
	</tr>
	<tr>
		{foreach from=$motivos.t item=motivo}
		<th>{$motivo.nombre|escape}</th>
		{/foreach}
		<th class='column-total' title='Total de Inasistencias Justificadas'>TOTAL</th>
		{foreach from=$motivos.f item=motivo}
		<th>{$motivo.nombre|escape}</th>
		{/foreach}
		<th class='column-total'>TOTAL</th>
	</tr>
</thead>
<tbody>

	{foreach from=$inasistencias key=cedula item=estudiante}
	<tr>
		<td>{persona_url cedula=$cedula}</td>
		<td>{link_to name=$estudiante.fullname|escape action=view cedula=$cedula}</td>
		<td>{join parts="`$estudiante.telefono`;`$estudiante.tel_celular`"|escape sep=', '}</td>
		<td>{$estudiante.genero}</td><td>{$estudiante.edad}</td>
		{if !isset($cod_curso)}<td>{link_to name=$estudiante.nombre_curso action=general cod_curso=$estudiante.cod_curso}</td>{/if}
		<td class='total total-clasesAsistidas'>{$clasesAsistidas.$cedula[0].n_asistencias}</td>
		{foreach from=$motivos.t item=motivo}
			<td class='asistenciaJustificada'>{$estudiante.inasistencias[$motivo.codigo]|default:0}</td>
		{/foreach}
		<td class='total total-asistenciasJustificadas'></td>
		{foreach from=$motivos.f item=motivo}
			<td class='asistenciaInjustificada'>{$estudiante.inasistencias[$motivo.codigo]|default:0}</td>
		{/foreach}
		<td class='total total-asistenciasInjustificadas'></td>
		<td class='total total-clasesInasistidas'></td>
	</tr>
	{/foreach}
</tbody>
</table>

<div class='date-report'>Generado: <span class='date'>{'now'|date_format}</span></div>
</div>
{/if}
