<div class="wrapper-informe">
	<h2 class="ui-state-default">Por Edades</h2>
	<table class='table dataTable dt-non-paginable table-reporte' id='table-informe-Edades'  title='Informe por Edades'>
		<thead><tr><th>Edad</th><th>Cantidad</th><th>%</th></tr></thead>
		<tbody>
			{foreach from=$oInforme->reporte.edades key=edad item=cantidad}
				<tr>
					<td>{$edad}</td><td>{$cantidad}</td><td>{$cantidad*100/$oInforme->total|string_format:"%.2f%%"}</td>
				</tr>
			{/foreach}
		</tbody>
		<tfoot  class='non-printable'>
			<tr><td>Menores de Edad</td><td id='td-mayores-edad'>{$oInforme->reporte.rangoEdades.m}</td><td>{$oInforme->reporte.rangoEdades.m*100/$oInforme->total|string_format:"%.2f%%"}</td></tr>
			<tr><td>Mayores de Edad</td><td id='td-menores-edad'>{$oInforme->reporte.rangoEdades.M}</td><td>{$oInforme->reporte.rangoEdades.M*100/$oInforme->total|string_format:"%.2f%%"}</td></tr>				
			<tr>
				<td colspan='3'>
					<a href='#' class='showChart' id='link-verGraficaInformeEdadesResumen'>Ver Gr&aacute;fica Resumen</a>						
				</td>
			</tr>
		</tfoot>
	</table>
</div>
<div class="wrapper-chart">
	<h2 class="ui-state-default">Gr&aacute;ficas</h2>
	<div id="chart-container-EdadesResumen"></div>
	<div id="chart-container-Edades"></div>
</div>
<div class="clear"></div>
