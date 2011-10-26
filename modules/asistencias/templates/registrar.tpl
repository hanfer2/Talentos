{if !isset($cod_clase)}
  {if $siat_request->getParam('t') eq 'ce'}
    {include_template file='curso_especial.form' title='Registrar Asistencia'}
  {else}
    {include_template file='cursos_componentes' title='Registrar Asistencia'}
  {/if}
<div id='wrapper-asistencias-fechas'></div>
<div class='ajax-response' id='ajax-registrarAsistencia'></div>
{else}
<div class='ui-widget decorated'>
	<h1>Registrar Asistencia</h1>
	<h2>{$nombre_componente} - Curso {$nombre_curso}</h2>
	<h3> Fecha de la Clase: {$clase.fecha|date_format}</h3>
	{if !empty($asistencias)}
		<h3 id='header-text-asistenciaRegistrada'>YA HA SIDO REGISTRADA</h3>
		&Uacute;ltima actualizaci&oacute;n: {$clase.updated_at|date_format:$smarty.const.TIMESTAMP_FORMAT|escape}  (por: <strong>{$clase.updated_by|escape}</strong>)
	{/if}
	<form action="{url_for action=save}" method="post">
		<table id='table-registrarAsistencia' class='table dataTable non-paginable'>
			<thead>
				<tr>
					<th>#</th><th>Doc. Id</th><th>Nombre</th>
					<th class='column-chbx'>Asisti&oacute;</th><th>Justificaci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$estudiantes item=estudiante name=estudiantes}
				<tr>
					{assign var=cod_interno_estudiante value=$estudiante.cod_interno}
					<td>{$smarty.foreach.estudiantes.iteration}</td>
					<td>{persona_url cedula=$estudiante.cedula}</td>
					<td {if in_array($estudiante.cedula,$estudiantesFlotantes)} class="estudiante-flotante" {/if}>{$estudiante.fullname|escape}</td>
					<td><input type='checkbox' class='chk-asistencia-asiste' name='asistencia[{$estudiante.cod_interno}][asiste]' value='t' {if $asistencias.$cod_interno_estudiante.asiste neq 'f' } checked='checked'{/if} /></td>
					<td>{html_select name="asistencia[`$estudiante.cod_interno`][justificacion]" options=$justificaciones selected=$asistencias.$cod_interno_estudiante.cod_motivo disabled=disabled}</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
		<div>
			<label class='textarea-label'>Observaciones:</label>
			<textarea cols="100" rows="5" name='clase[observaciones]'>{$clase.observaciones}</textarea>
		</div>
		<input type='hidden' name='clase[codigo]' value="{$cod_clase}"/>
		<div class='ui-button-bar'>
			<button id='bt-guardarAsistencia'>Aceptar</button>
		</div>
	</form>
	{if isset($alert_message)}
		{link_to name='Registrar nueva Asistencia' action='registrar'}
		<script type='text/javascript'>
			jAlert("{$alert_message}");
		</script>
	{/if}
</div>

{/if}
