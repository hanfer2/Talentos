<div class="wrapper-informe">
	<h2 class="ui-state-default">Por Comunas</h2>
	<table class='table dataTable dt-non-paginable table-reporte' id='table-informe-Comunas' title='Informe por Comunas'>
		<thead><tr><th>Comuna</th><th>Cantidad</th><th>%</th></tr></thead>
		<tbody>
			{foreach from=$oInforme->reporte.comunas key=comuna item=cantidad}
				<tr>
					<td>{$comuna|default:"Sin Comuna"}</td>
					<td>{$cantidad}</td>
					<td>{$cantidad*100/$oInforme->total|string_format:"%.2f%%"}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>
<div class="wrapper-chart">
	<h2 class="ui-state-default">Gr&aacute;ficas</h2>
	<div id="chart-container-Comunas"></div>
</div>
<div class="clear"></div>
