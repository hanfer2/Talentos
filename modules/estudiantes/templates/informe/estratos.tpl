<div class="wrapper-informe">
	<h2 class="ui-state-default">Por Estratos</h2>
	<table class='table dataTable dt-non-paginable table-reporte' id='table-informe-Estratos'  title='Informe por Estratos'>
		<thead><tr><th>Estrato</th><th>Cantidad</th><th>%</th></tr></thead>
		<tbody>
			{foreach from=$oInforme->reporte.estratos key=estrato item=cantidad}
				<tr>
					<td>{$estrato}</td><td>{$cantidad}</td><td>{$cantidad*100/$oInforme->total|string_format:"%.2f%%"}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>
<div class="wrapper-chart">
	<h3 class="ui-state-default">Gr&aacute;ficas</h3>
	<div id="chart-container-Estratos"></div>
</div>	
<div class="clear"></div>	
