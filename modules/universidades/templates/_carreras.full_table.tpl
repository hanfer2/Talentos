<table class="table dataTable" id="table-listadoCarreras">
	<thead>
		<tr>
		<th>C&oacute;digo</th>
		<th>Nombre</th>
		<th class='column-select-filter'>Modalidad</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$carreras item=carrera}
		<tr>
			<td>{$carrera.codigo}</td>
			<td>{link_to name=$carrera.nombre action='egresados' cod_universidad=$cod_universidad cod_carrera=$carrera.codigo}</td>
			<td>{$carrera.modalidad}</td>
		</tr>
		{/foreach}
	</tbody>
</table>

