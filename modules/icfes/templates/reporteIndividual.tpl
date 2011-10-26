{if is_blank($cedula)}
	{include_template file='persona.form' title='Reporte Icfes Individual'}
	<div id="ajax-reporteIcfesIndividual" class='ajax-response'></div>
{	elseif empty($pruebas)}
	<div class="ui-widget decorated">
		<h1>No se Hallo Ningun Registro</h1>
	</div>
{else}
	<div class="ui-widget decorated">
		<h1>Reporte Icfes Individual </h1>
		<h2>{persona_url cedula=$cedula} - {$nombre_persona}</h2>
		<h3>{#PNAT#} {$cod_programa} - Curso {$nombre_curso}</h3>
		<table class="table dataTable dt-non-paginable" id="table-icfesIndividual" title='Reporte Icfes Individual'>
			<thead>
				<tr>
					<th>Componente</th>
					{foreach from=$pruebas item=prueba}
					{assign var=info_prueba value=$info_pruebas|@array_item:"`$prueba.tipo`"}
					<th {if $info_prueba.visible eq "f"} class="err-item-oculto prueba-oculta" {/if}>
						<div class='column-title'>{if $info_prueba.visible eq "f"}<span class="ui-icon ui-icon-info error-icon inline-icon" title="Prueba Oculta"></span>{/if}{$info_prueba.nombre|escape}</div>
						<div class="date inline">{$info_prueba.fecha|date_format}</div>
					</th>
					{/foreach}
				</tr>
			</thead>
			<tbody>
				<!-- SNP -->
				<tr class='no-chart'>
					<td><abbr title="Servicio Nacional de Pruebas">SNP</abbr></td>
					{foreach from=$pruebas item=prueba}
					<td >{$prueba.num_registro_icfes}</td>
					{/foreach}
				</tr>
				<!-- Componentes por Prueba-->
		 {foreach from=$componentes item=componente}
				<tr>
					<td>{info classname=IComponente func=nombre args=$componente}</td>
					{foreach from=$pruebas item=prueba}
					{assign var=low_componente value=$componente|lower}
					<td>{$prueba.$low_componente|default:"-"}</td>
					{/foreach}
				</tr>
		 {/foreach}
			</tbody>
			<tfoot>
				<tr>
					<td></td>
			{foreach from=$pruebas item=prueba}
					<td>
            {if in_array($prueba.tipo, $simulacros)}
						<div><a href="{url_for controller=i_cuestionarios_estudiantes action=view cod_prueba=$prueba.tipo cedula=$cedula}" id="link-icfesRespuestas-{$cedula}-{$prueba.tipo}" target="_blank">Respuestas</a></div>
						<div><a href="{url_for controller=i_competencias_estudiantes action=view cod_prueba=$prueba.tipo cedula=$cedula}" id="link-icfesCompetencias-{$cedula}-{$prueba.tipo}">Competencias</a></div>
            {/if}
					</td>
			{/foreach}
				</tr>
			</tfoot>
		</table>
	</div>
	<div>
		{foreach from=$pruebas item=prueba}
		<div id='wrapper-competencias-{$prueba.tipo}'></div>
		<div id='wrapper-respuestas-{$prueba.tipo}'></div>
		{/foreach}
		<div id='chart-container'></div>
	</div>
{/if}
