<div class="ui-widget decorated">
	{if empty($componentes)}
		{include file=#EMPTY_RESULTS_FILE#}
	{else}
	<h1>Listado de Componentes</h1>
	<table class='table dataTable' id="table-listadoComponentes">
		<thead>
			<tr>
				<th>C&oacute;digo</th><th>Nombre</th>
				<th class='column-select-filter'>Modalidad</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$componentes item=componente}
			<tr>
				<td>{$componente.codigo}</td>
				<td>{$componente.nombre|escape}</td>
				<td>{$componente.modalidad|escape}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
	{/if}
	<div class='ui-toolbar'>
		{if is_super_admin_login()}
		<a href="#" id="link-registrarNuevoComponente">Registrar Nuevo Componente</a>
		{/if}
	</div>
	<div class='ui-helper-hidden toggable' id='wrapper-nuevoComponente'>
		{if is_super_admin_login()}
		{include_partial file="add.tpl" module='componentes'}
		{/if}
	</div>
</div>
