<div class="wrapper-informe">
	<h2 class="ui-state-default">Comunas Predominantes por Curso</h2>
	<table class='table dataTable dt-non-paginable table-reporte' id='table-informe-ComunaPredominante' title='Informe de Comunas Predominantes por Curso'>
		<thead>
			<tr>
				<th>Curso</th><th>Comuna</th><th>Cantidad</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$oInforme->reporte.comunasPredominantes key=curso item=comuna}
				<tr>
					</td>
					<td class="toggle-icon-cell"><a href="#outer-informeDetallado-comunasPredominantes-{$curso}" class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon left-icon'></a> {$curso|default:"Sin Comuna"}</td><td>{$comuna[0].comuna}</td><td>{$comuna[0].cantidad}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>

	<div id='wrapper-informeDetallado-comunasPredominantes' class="ui-helper-hidden">
		{foreach from=$oInforme->reporte.comunasPredominantes key=curso item=comunas}
			<div class='informeDetallado-comunasPredominantes' id='outer-informeDetallado-comunasPredominantes-{$curso}'>
			<h2 class="ui-state-default">Curso {$curso}</h2>
			<table id='table-informeDetallado-comunasPredominantes-{$curso}' class='table dataTable dt-non-paginable table-comunasPorCurso'>
				<thead><tr><th>Comuna</th><th>Cantidad</th></tr></thead>
				<tbody>
					{foreach from=$comunas item=comuna}
						<tr>
							<td>{$comuna.comuna|default:"Sin Comuna"}</td><td>{$comuna.cantidad}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
			</div>
		{/foreach}
	 </div>
</div>
<div class="wrapper-chart">
	<h2 class="ui-state-default">Gr&aacute;ficas</h2>
	<div id="chart-container-comunasPredominantes"></div>
</div>
<div class="clear"></div>
