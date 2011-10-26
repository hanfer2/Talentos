			
<h2 class="ui-state-default">Estados de Excepci&oacute;n</h2>
<table class='table dataTable table-reporte dt-non-paginable' id='table-informe-Excepciones' title='Informe de Excepciones'>
	<thead>
		<th class='dt-unorderable-column toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggleAll-icon'></span></th>
		<th>Estado</th><th>Cantidad</th>
	</thead>
	<tbody>
		<tr id='row-informeEtnias'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeEtnias'></span></td>
			<td>en Etnias</td>
			<td>{$oInforme->reporte.etnias.total}</td>
		</tr>
		<tr id='row-informeDesplazados'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeDesplazados'></span></td>
			<td>Desplazados</td>
			<td>{$oInforme->reporte.desplazados.total}</td>
		</tr>
		<tr id='row-informeDiscapacitados'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeDiscapacitados'></span></td>
			<td>Discapacitados</td>
			<td>{$oInforme->reporte.discapacidades.total}</td>
		</tr>
		<tr id='row-informeHijos'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeHijos'></span></td>
			<td>Con Hijos</td>
			<td>{$oInforme->reporte.hijos.total}</td>
		</tr>
		<tr id='row-informeEmbarazos'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeEmbarazos'></span></td>
			<td>En Embarazo</td>
			<td>{$oInforme->reporte.embarazos|@count}</td>
		</tr>
	</tbody>
</table>
			
	<div>
		<!-- ETNIAS -->
		<div class='hidden' id='wrapper-informe-Etnias'>
			{foreach from=$oInforme->reporte.etnias.estudiantes key=etnia item=estudiantes}
			<h3 class="ui-state-default">{$etnia|escape}</h3>
			<table class='table table-informe-Etnias table-informe-Excepciones'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				{foreach from=$estudiantes item=estudiante}
					<tr>
						<td>{persona_url cedula=$estudiante.cedula}</td><td>{$estudiante.fullname|escape}</td><td>{$estudiante.nombre_grupo}</td>
					</tr>
				{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td>Total<br/>{$etnia|escape}:</td><td>{$estudiantes|@count}</td>
						<td>{math equation="x*100/y" x=$estudiantes|@count y=$oInforme->total format=#PERCENT_FORMAT#}</td>
					</tr>
				</tfoot>
			</table>
			{foreachelse}
			<tr><td class='empty-result-message' colspan='3'>No hay estudiantes pertenecientes a etnias registrados</td></tr>
			{/foreach}
		</div>
		
		<!-- DISCAPACITADOS -->
		<div class='hidden' id='wrapper-informe-Discapacitados'>
			{foreach from=$oInforme->reporte.discapacidades.estudiantes key=discapacidad item=estudiantes}
			<h3 class="ui-state-default">{$discapacidad}</h3>
			<table class='table table-informe-Discapacitados table-informe-Excepciones'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				{foreach from=$estudiantes item=estudiante}
					<tr>
						<td>{persona_url cedula=$estudiante.cedula}</td><td>{$estudiante.fullname}</td><td>{$estudiante.nombre_grupo}</td>
					</tr>
				{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td>Total<br/>{$discapacidad}:</td><td>{$estudiantes|@count}</td>
						<td>{math equation="x*100/y" x=$estudiantes|@count y=$oInforme->total format=#PERCENT_FORMAT#}</td>
					</tr>
				</tfoot>
			</table>
			{foreachelse}
			<tr><td class='empty-result-message' colspan='3'>No hay estudiantes reportados con discapacidades</td></tr>
			{/foreach}
		</div>
		<!-- HIJOS -->
		<div class='hidden' id='wrapper-informe-Hijos'>
			{foreach from=$oInforme->reporte.hijos.estudiantes key=hijos item=estudiantes}
			<h3 class="ui-state-default">Participantes con {$hijos|pluralize:"hijo":"hijos"}</h3>
			<table class='table table-informe-Hijos table-informe-Excepciones'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				{foreach from=$estudiantes item=estudiante}
					<tr>
						<td>{persona_url cedula=$estudiante.cedula}</td><td>{$estudiante.fullname}</td><td>{$estudiante.nombre_grupo}</td>
					</tr>
				{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td>Total<br/>Con {$hijos|pluralize:"hijo":"hijos"}:</td><td>{$estudiantes|@count}</td>
						<td>{math equation="x*100/y" x=$estudiantes|@count y=$oInforme->total format=#PERCENT_FORMAT#}</td>
					</tr>
				</tfoot>
			</table>
			{foreachelse}
			<tr><td class='empty-result-message' colspan='3'>No hay estudiantes pertenecientes a etnias registrados</td></tr>
			{/foreach}
		</div>
		
		<!-- EMBARAZOS -->
		<div class='hidden' id='wrapper-informe-Embarazos'>
			<h3 class="ui-state-default">Participantes en Embarazo</h3>
			<table class='table table-informe-Embarazos'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				{foreach from=$oInforme->reporte.embarazos item=estudiante}
					<tr>
						<td>{persona_url cedula=$estudiante.cedula}</td><td>{$estudiante.fullname}</td><td>{$estudiante.nombre_grupo}</td>
					</tr>
				{foreachelse}
					<tr><td colspan='3'>No hay estudiantes reportadas en embarazo</td></tr>
				{/foreach}
				</tbody>
			</table>
		</div>
		<!-- DESPLAZADOS -->
		<div class='hidden' id='wrapper-informe-Desplazados'>
			{foreach from=$oInforme->reporte.desplazados.estudiantes key=ciudad item=estudiantes}
			<h3 class="ui-state-default">Participantes Desplazados<br/>de {$ciudad}</h3>
			<table class='table table-informe-Desplazados table-informe-Excepciones'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				{foreach from=$estudiantes item=estudiante}
					<tr>
						<td>{persona_url cedula=$estudiante.cedula}</td><td>{$estudiante.fullname}</td><td>{$estudiante.nombre_grupo}</td>
					</tr>
				{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td>Total {$ciudad}</td><td>{$estudiantes|@count}</td>
						<td>{math equation="x*100/y" x=$estudiantes|@count y=$oInforme->total format=#PERCENT_FORMAT#}</td>
					</tr>
				</tfoot>
			</table>
			{foreachelse}
			<tr><td class='empty-result-message' colspan='3'>No hay estudiantes reportados como desplazados</td></tr>
			{/foreach}
		</div>
	</div>

	
