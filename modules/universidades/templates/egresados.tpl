	<div class="ui-widget decorated">
	{capture assign='links'}
			{link_to name='Listado Total de Egresados' controller='egresados'} | 
			{link_to name='Listado de Universidades'} | 
			{link_to name='Registrar Egresado' controller='egresados' action='add'}
	{/capture}
	{if empty($egresados)}
		{include_template file=error message="No se hallaron egresados en esta Universidad" links=$links}
	{else}

		<h1>Listado de Egresados </h1>
		<h2>{$cod_universidad} - {link_to name=$nombre_universidad action='carreras' cod_universidad=$cod_universidad cod_ciudad=$cod_ciudad}</h2>
		<h3>{if !is_blank($cod_carrera)} {info classname='TCarrera' func='nombre' args=$cod_carrera} {/if}</h2>
		<table class="table dataTable" id="table-egresadosIES">
			<thead>
				<tr>
					<th>Doc. Id.</th>
					<th>Nombre</th>
					<th>Plan</th>
					{if !isset($cod_universidad)}
					<th class='column-select-filter long-select'>Inst. Educ. Sup.</th>
					{elseif !isset($cod_carrera)}
					<th class='column-select-filter long-select'>Carrera</th>
					{/if}
					{if !isset($cod_universidad)}
					<th class='column-select-filter'>Ciudad</th>
					{/if}
				</tr>
			</thead>
			<tbody>
			{foreach from=$egresados item=egresado}
				<tr>
					<td>{persona_url cedula=$egresado.cedula}</td>
					<td>{link_to name=$egresado.fullname action='view' cedula=$egresado.cedula}</td>
					<td>{link_to name=$egresado.cod_programa cod_programa=$egresado.cod_programa tipo='IES'}</td>
					{if !isset($cod_universidad)}
					<td>{$egresado.nombre_universidad}</td>
					{elseif !isset($cod_carrera)}
					<td>{$egresado.nombre_carrera}</td>     
					{/if}
					{if !isset($cod_universidad)}
					<td>{$egresado.nombre_ciudad}</td>     
					{/if}
				</tr>
			{/foreach}
			</tbody>
		</table>
		<div class="ui-toolbar">
			{$links}
		</div>
	</div>
{/if}
