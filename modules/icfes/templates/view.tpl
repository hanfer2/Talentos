<div class="ui-widget decorated">
 {if empty($estudiantes)}
	 <h1>No se hallaron registros</h1>
	 <p>No se hallaron registros de Icfes para el {nombre_programa cod_programa=$cod_programa}</p>
 {else}
	 <h1>Reporte General Icfes</h1>
	 <h2>{$nombre_prueba}</h2>
	 <h3>
			{nombre_programa cod_programa=$cod_programa} -
			{capture assign=nombreAgrupacion}
			{if isset($cod_curso)}
			 Curso {$nombre_curso}
			{elseif isset($cod_grupo)}
			 Grupo {info classname=TGrupo func=nombre args=$cod_grupo}
			{/if}
			{/capture}
			{$nombreAgrupacion}
	 </h3>

		{if !is_xhr()}
	 <div class="ui-toolbar">
		{foreach from=$pruebas item=prueba name=prueba}
			 {*Saltarse la prueba actual*}
			 {if $prueba.codigo neq $cod_prueba}
				{*Enviar el codigo del curso o grupo*}
				{if isset($cod_curso)}
				 {link_to name=$prueba.nombre action=view cod_prueba=$prueba.codigo cod_curso=$cod_curso}
				{elseif isset($cod_grupo)}
				 {link_to name=$prueba.nombre action=view cod_prueba=$prueba.codigo cod_grupo=$cod_grupo}
				{/if}
				{*Agregar separador*}
				{if !$smarty.foreach.prueba.last} | {/if}
			 {/if}
		{/foreach}

		 {if isset($cod_curso)}
			{if ($pruebas|@count - 1) > 0}	<br/> {/if}
			{link_to name='Reporte Por Niveles' action='reporteComponentes' cod_curso=$cod_curso cod_prueba=$cod_prueba  componentes=$param_componentes}
		 {/if}
	 </div>
		{/if}
	 <table class="table dataTable non-paginable" id="table-reporteIcfes">
		<thead>
		 <tr>
			<th>#</th>
			<th>Doc Id.</th>
			<th>Nombre</th>
			<th>Grupo</th>
			<th>Curso</th>
			<th><abbr title="Servicio Nacional de Pruebas">SNP</abbr></th>
			{foreach from=$componentes item=componente}
			<th title='{$componente}'>{$componente|upper|truncate:12}</th>
			{/foreach}
			<th>Promedio</th>
		 <tr>
		</thead>
		<tbody>
		 {foreach from=$estudiantes item=estudiante name=estudiante}
		 
		 <tr>
			<td>{$smarty.foreach.estudiante.iteration}</td>
			<td>{persona_url cedula=$estudiante.cedula}</td>
			<td>{link_to name=$estudiante.fullname action='view' cedula=$estudiante.cedula}</td>
			<td>{link_to name=$estudiante.nombre_grupo|substr:0:1 action=view cod_grupo=$estudiante.nombre_grupo|substr:0:1 cod_prueba=$cod_prueba cod_programa=$cod_programa}</td>
			<td>{link_to name=$estudiante.nombre_grupo|substr:2 action=view cod_curso=$estudiante.cod_grupo cod_prueba=$cod_prueba cod_programa=$cod_programa}</td>
			<td>{$estudiante.num_registro_icfes}</td>
			{foreach from=$componentes item=componente}
				<td>{$estudiante.$componente}</td>
			{/foreach}
			<td></td>
		 </tr>
		 {/foreach}
		</tbody>
		{if isset($cod_grupo) and $cod_grupo neq '-'}
		<tfoot>
		 <tr>
			<td colspan="6">PROMEDIOS <strong>{$nombreAgrupacion|upper}</strong></td>
			{foreach from=$componentes item=componente}
			<td>{$promedios.$componente|string_format:"%.2f"}</td>
			{/foreach}
			<td></td>
		 </tr>
		</tfoot>
		{/if}
	 </table>
	 <div class="ui-toolbar">
		{link_to name='Resumen Reporte Promedios Icfes' action=reporteComponentes componentes=$param_componentes cod_prueba=$cod_prueba}
	 </div>
 {/if}
</div>
