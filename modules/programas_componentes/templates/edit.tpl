<div class="widget-programas-componentes-edit">
	<!-- LISTADO DE COMPONENTES YA ASIGNADOS -->
	<div class="wrapper-programas-componentes  wrapper-list-componentes-asignados">
		<h4 class="ui-state-default">Componentes Asignados</h4>
		{include_partial file="_list.tpl" componentes=$componentesAsignados componentesSinHorario=$componentesSinHorario}
	</div>
	<!-- LISTADO DE COMPONENTES DISPONIBLES -->
	<div  class="wrapper-programas-componentes">
		<h4 class="ui-state-default">Componentes Disponibles</h4>
		{if empty($componentesDisponibles)}
			<p>No hay aun componentes asignados<br/>a este semestre</p>
		{else}
			<div class='list-componentes list-componentes-disponibles'>
				{foreach from=$componentesDisponibles item=componente}
				<div title="{$componente.nombre|escape}" class="item-list ui-corner-all componente-{$componente.codigo}">
					<span class="cod_componente-value hidden">{$componente.codigo}</span>
					<span class="nombre_componente-value">{$componente.nombre|truncate:"35"|escape}</span>
					<span title="Agregar" class="ui-icon ui-icon-plus inline-icon right-icon clickable"></span>
				</div>
				{/foreach}
			</div>
		{/if}
	</div>
	<div class="clear"></div>
</div>
