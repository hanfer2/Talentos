{if isset($cod_curso)}
	<div class='non-printable'><a href='#' onclick='print(); return false' class='link-print'>Imprimir</a></div>
	{foreach from=$cursos item=curso key=nombre_cur}
	<table border='1' class='table-formatoAsistencia'>
		<thead>
		<tr class='h5'><th class='column-contador' colspan='7'>Grupo {$nombre_cur}</th></tr>
		<tr><th class='column-contador'>#</th><th>DOC. ID</th><th>APELLIDOS</th><th>NOMBRES</th>
		<th colspan='2'>ASISTI&Oacute;</th><th class='tiny'>CUMPLIMIENTO<br>DE TAREAS</th></tr>
		</thead>
		<tbody>
		{foreach from=$curso item=estudiante name=estudiantes}
			<tr>
				<td class='column-contador'>{$smarty.foreach.estudiantes.iteration}</td>
				<td>{$estudiante.cedula}</td><td>{$estudiante.apellidos|escape}</td><td>{$estudiante.nombres|escape}</td>
				<td>SI</td><td>NO</td><td></td>
			</tr>
		{/foreach}
		</tbody>
		<tfoot>
		<tr><td class='column-contador' colspan='3'>Total Estudiantes Grupo {$nombre_cur}: {$smarty.foreach.estudiantes.total}</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td><td></td></td><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td class='column-contador'colspan='2'>Profesor(a)</td><td>Firma</td><td>Fecha</td><td colspan='2'>Hora</td><td></td></tr>
		<tr><td>&nbsp;</td><td></td></td><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td class='column-contador'colspan='2'>Monitor(a)</td><td>Firma</td><td>Fecha</td><td colspan='2'>Hora</td><td></td></tr>
		<tr><td>&nbsp;</td><td></td></td><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td><td>&nbsp;</td></tr>
		{* <tr class='observaciones column-contador'><td colspan='7'>Observaciones:</td></tr> *}
		<tr><td colspan='7'>OBSERVACIONES</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		</tfoot>
	</table>
	{/foreach}
{else}
	{include_template file='curso.form' title='Formatos de Asistencia' extra=TRUE}
	<div class='ajax-response'></div>
{/if}

