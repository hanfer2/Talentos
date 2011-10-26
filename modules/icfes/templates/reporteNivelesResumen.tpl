<div class='decorated ui-widget' id="panel-iReporteResumenNiveles">
  <h1>Reporte Consolidado por Grupos por Niveles</h1>
  <h2>{$nombre_prueba}</h2>
  
	<!-- NAV TOOLBAR -->
	<div class="fg-toolbar ui-helper-clearfix tb-main" id="tbnav-i_niveles-r">
		<a href="#panel-i_niveles-r-consolidado" class="fg-button ui-state-default ui-state-active ui-corner-all">Consolidado</a>
		{foreach from=$grupos item=grupo name=toggle_grupos}<a href="#panel-i_niveles-r-{$grupo|underscorify}" class="fg-button ui-state-default {if $smarty.foreach.toggle_grupos.first}ui-corner-left {elseif $smarty.foreach.toggle_grupos.last}ui-corner-right{/if}">{$grupo}</a>{/foreach}
		<a href="#panel-i_niveles-r-convenciones" id="link-i_niveles-r-convenciones"><span class="ui-icon ui-icon-tag inline-icon link-icon"></span> Convenciones</a>
  </div>
  
  <!-- CONVENCIONES-->
  <div class="ui-widget-content frm-4 ui-helper-hidden" id="panel-i_niveles-r-convenciones">
		<!-- CONVENCIONES -->
		<h3 class="ui-state-default">CONVENCIONES</h3>
		<table id='table-convenciones' class="convenciones table">
			<thead>
				<tr><th class="ui-state-default">Subnivel</th><th class="ui-state-default">Rango</th></tr>
			</thead>
			<tbody>
				{foreach from=$_niveles key=id item=nivel}
					<tr>
						<td>{$nivel}</td>
						<td>{$rangos.$id[0]|string_format:"%.2f"} - {$rangos.$id[1]|string_format:"%.2f"}</td>
					</tr>
				{/foreach}
		</table>
  </div>
  
  <!-- I_NIVELES ACCORDEON-->
  <div class="accdn" id="accdn-i_niveles-r">
		{foreach from=$grupos item=grupo}
		<div id="panel-i_niveles-r-{$grupo|underscorify}" class="accdn-item">
			<h3 class="ui-state-default ui-corner-all">Promedios Grupo {link_to name=$grupo action='view' cod_prueba=$cod_prueba cod_programa=$cod_programa cod_grupo=grupo}</h3>
			<table class='table dt-unsortable dt-non-paginable'>
				<thead>
					<tr>
						<th class="column-hidden">Nivel</th>
						<th >Subnivel</th>
						{foreach from=$_componentes item=componente}
							<th>{$componente|truncate:4:"."|escape}</th><th>%</th>
						{/foreach}
					</tr>
				</thead>
				<tbody>
					{foreach from=$_superniveles key=supernivel item=niveles}
						 {foreach from=$niveles item=nivel}
							<tr>
							<td>{$supernivel}</td>
							<td>{$nivel}</td>
							{foreach from=$_componentes item=componente}
								{assign var=cantidad value=$resumen_niveles.$grupo.$supernivel.$nivel.$componente}
								{assign var=total value=$clasificador->cant_estud.$grupo.$componente}
								<td>{$cantidad}<hr/>{$total}</td>
								<td class="important">{math equation="x * 100 / y" x=$cantidad y=$total format="%.2f%%"}</td>
							{/foreach}
							
						 {/foreach}
						 </tr>
					 {/foreach}
				</tbody>
			</table>
		</div>
		{/foreach}
  
		<!-- ----- PROMEDIO GENERAL PNAT ---- -->
		<div id="panel-i_niveles-r-consolidado" class="accdn-item accdn-summary">
			<h3 class="ui-state-default ui-corner-all">Promedios General - {nombre_programa cod_programa=$cod_programa}</h3>
			
			<table class="table dt-unsortable dt-non-paginable">
				<thead>
					<tr>
						<th class="column-hidden" >Nivel</th>
						<th>Subnivel</th>
						{foreach from=$_componentes item=componente}
							<th>{$componente|truncate:4:"."|escape}</th>
							<th>%</th>
						{/foreach}
					</tr>
				</thead>
				<tbody>
					{foreach from=$_superniveles key=supernivel item=niveles}
						{foreach from=$niveles item=nivel}
						 <tr>
							<td>{$supernivel}</td>				
							<td>{$nivel}</td>
							{foreach from=$_componentes item=componente}
								<td>{$clasificador->totales.resumen.$supernivel.$nivel.$componente}<hr/>{$clasificador->totales.cant.$componente|default:"0"}</td>
								<td class="important">{math equation="x * 100 / y" format="%.2f%%" x=$clasificador->totales.resumen.$supernivel.$nivel.$componente y=$clasificador->totales.cant.$componente}</td>
							{/foreach}
							</tr>
						 {/foreach}
						{/foreach}
				</tbody>
			</table>
		</div>
  </div>
</div>
