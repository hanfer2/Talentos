<ul class='list-componentes basic-list list-componentes-asignados'>
	{if empty($componentes)}
		<p>No hay aun componentes asignados<br/>a este semestre</p>
	{else}
		{foreach from=$componentes item=componente}
		<li title="{$componente.codigo} - {$componente.nombre|escape}" class="item-list componente-{$componente.codigo}">
		<span class="cod_componente-value hidden">{$componente.codigo}</span><span class="nombre_componente-value"> {$componente.nombre|escape|truncate:"35"}</span>
		{if isset($componentesSinHorario)}
			{if in_array($componente.codigo, $componentesSinHorario)}
			<span class="ui-icon ui-icon-close inline-icon right-icon" title="Desasignar Componente"></span>
			{else}
			<span class="ui-icon ui-icon-locked inline-icon right-icon" title="Componente Bloqueado"></span>
			{/if}
		{/if}
		</li>
		{/foreach}
	{/if}
</ul>
