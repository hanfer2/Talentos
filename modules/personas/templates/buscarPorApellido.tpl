{if !isset($q)}
<h2>Buscar Por Apellido</h2>
<div class='ui-field ui-field-inline center'>
	<label>Apellido</label>
	<input name='q' id='q' title='Ingrese parte del Apellido'/>
	<button id='bt-buscarPorApellido'>Buscar</button>
</div>
<div id='ajax-porApellidos'></div>
{elseif is_array($personas)}
	<table id='table-listadoPorApellidos' class='table dataTable'>
		<thead>
			<tr>
				<th>Doc. Id</th><th>Apellidos</th><th>Nombres</th>
				<th class='column-select-filter' id='column-tipo_per'>Tipo</th>
				<th class='column-select-filter' id='column-pnat'>{#PNAT#}</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$personas item=persona}
			<tr class='row-buscarPorApellido clickable'>
				<td>{$persona.cedula|escape}</td>
				<td>{$persona.apellidos|escape}</td>
				<td>{$persona.nombres|escape}</td>
				<td>{$persona.tipo_persona|escape}</td>
				<td>{$persona.cod_programa|escape|default:"-"}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
{else}
<div class='ui-widget decorated'>
	<h1>No se hallaron registros</h1>
</div>
{/if}