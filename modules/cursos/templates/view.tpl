<div class='ui-widget decorated'>
{if empty($estudiantes)}
	<h1>No se hallaron Registros</h1>
	<p>Este curso no tiene a&uacute;n estudiantes registrados</p>
{else}
	<h1>Listado de Participantes</h1>
	<h2>{nombre_programa cod_programa=$cod_programa}</h2>
	<h3>Curso {$nombre_curso}</h3>
	<table class='table dataTable dt-non-paginable' id='table-participantesPorCurso'>
		<thead>
			<tr>
				<th>Doc. Id.</th><th>Nombre</th>
				<th class='column-select-filter'>Grupo</th>
				<th class='column-select-filter'>Curso</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$estudiantes item=estudiante}
			<tr>
				<td>{persona_url cedula=$estudiante.cedula}</td>
				<td>{$estudiante.fullname|escape}</td>
				<td>{$estudiante.grupo|escape}</td>
				<td>{$estudiante.nombre_grupo|escape}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
{/if}
	<div class='ui-toolbar'>
    <a href="#{$cod_curso}" id="link-verNotificaciones">Ver Notificaciones</a> | 
		{link_to name='Consultar Horario' controller='horarios' action='view' cod_curso=$cod_curso }
	</div>
</div>
