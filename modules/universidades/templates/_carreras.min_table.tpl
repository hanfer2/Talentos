<table class="table table-minified" id="table-listadoCarreras">
	<thead class="ui-widget-header"><tr><th>Carreras {if !is_blank($pattern)}<span class='fn-idx fn-alert'>*</span>{/if}</th></tr></thead>
	<tbody>
		{foreach from=$carreras item=carrera}
		<tr>
			<td><span class="cod_carrera codigo ui-helper-hidden">{$carrera.codigo}</span>{link_to name=$carrera.nombre action='egresados' cod_universidad=$cod_universidad cod_carrera=$carrera.codigo}</td>
		</tr>
		{/foreach}
	</tbody>
</table>
{if !is_blank($pattern)}
<div class="footnote fn-alert" title="Este listado está bajo un filtro">Filtro actual: *<em>{$pattern}</em>*</div>
{/if}
	
