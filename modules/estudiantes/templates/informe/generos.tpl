<div class="wrapper-informe">
	<h2 class="ui-state-default">Por G&eacute;neros</h2>
	<table class='table dataTable dt-non-paginable table-reporte' id='table-informe-Generos'  title='Informe por Géneros'>
		<thead><tr><th>G&eacute;neros</th><th>Cantidad</th><th>%</th></tr></thead>
		<tbody>
			{foreach from=$oInforme->reporte.generos key=genero item=cantidad}
				<tr>
					<td>{$genero}</td><td>{$cantidad}</td><td>{$cantidad*100/$oInforme->total|string_format:"%.2f%%"}</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</div>
<div class="wrapper-chart">
	<h2 class="ui-state-default">Gr&aacute;ficas</h2>
	<div id="chart-container-Generos"></div>
</div>
<div class="clear"></div>
