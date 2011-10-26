{if !isset($cedula)}
	{include_template file='persona.form' title='Asistencia Individual'}
	<div class='ajax-response' id='ajax-asistenciaIndividual'></div>
{else}
<div class='ui-widget decorated'>
	<h1>Listado de Inasistencias</h1>
	<h2>{persona_url cedula=$cedula} - {$nombre_persona}</h2>
	{if !empty($curso) && !is_student_login()}
		<h3>Curso {link_to name=$curso.nombre_grupo action=general cod_curso=$curso.cod_grupo}  [{$status}]</h3>
	{/if}
	{if empty($inasistencias)}
	<p> En el momento, Este usuario no reporta inasistencias</p>
	{else}
	<div class='ui-box' id='wrapper-inasistenciasIndividual'>
		{foreach from=$inasistencias key=componente item=inasistencia name=inasistencia}
			<div class='wrapper-componentes-inasistencias' id='componentes-inasistencias-{$componente|escape}'>
				<h4 class='ui-state-default'>{$componente|escape}</h4>
				<table class='table table-inasistencias-individual'>
				<thead >
					<tr>
						<th class='column-idx'>#</th>
						<th>D&iacute;a</th><th>Motivo</th><th>V&aacute;lida</th>
					</tr>
				</thead>
				<tbody>
				{foreach from=$inasistencia item=clase name=inasistencia_componente}
					<tr>
						<td>{$smarty.foreach.inasistencia_componente.iteration|zeropad:2}</td>
						<td><span class='date'>{$clase.fecha}</span></td>
						{assign var=motivo value=$motivos|@array_item:$clase.cod_motivo:0}
						<td>{$motivo.nombre|escape} </td>
						<td>
							{if $motivo.valida eq 't'}
								<span class='claseConInasistencia asistencia-justificada'>&#10004;</span>
							{else}
								<span class='claseConInasistencia	 asistencia-injustificada'>&#10008;</span>
							{/if}
						</td>
					</tr>
				{/foreach}
				</tbody>
				<tfoot>
					<tr><th></th><th></th><th></th><th></th></tr>
				</tfoot>
				</table>
			</div>
			{if $smarty.foreach.inasistencia.iteration % 3 eq 0}<div class="clear"></div>	{/if}
		{/foreach}
		<div class="clear"></div>
		<div class='wrapper-componentes-inasistencias' id='wrapper-resumen-inasistencias-individual'>
			<h4 class='ui-state-default'>Resumen</h4>
			<table id='table-resumen-inasistencias-individual' class='table table-inasistencias-individual'>
				<thead>
					<tr><th >Inasistencias</th><th>Cantidad</th></tr>
					</thead>
					<tbody>
						<tr>
							<td>(<abbr title="No Justificadas" >-J</abbr>) No Justificadas</td>
							<td id='total-asistenciasIndividualInjustificadas'></td>
						</tr>
						<tr>
							<td>(<abbr title="Justificadas">+J</abbr>) Justificadas</td>
							<td id='total-asistenciasIndividualJustificadas'></td>
						</tr>
					</tbody>
					<tfoot>
					<tr><th colspan="3">TOTALES</th></tr>
					<tr><td>Total de Clases Reportadas</td><td id="total-clasesReportadas">{$nClasesReportadas}</td></tr>
					<tr><td>Total de Inasistencias</td><td id='total-inasistencias'>{$nClasesInasistencias}</td></tr>
					</tfoot>
			</table>
		</div>
	</div>
	{/if}
</div>
{/if}
