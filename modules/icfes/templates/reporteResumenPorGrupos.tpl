<div class="ui-widget decorated">
	{if empty($cursos)}
	<h1>No se Hallaron Registros</h1>
  {else}
  <h1>Reporte Resumido Promedios Icfes</h1>
  <h2>{nombre_programa} - {$nombre_prueba}</h2>
  <div class='ui-toolbar'>
  </div>

  <div class="toolbar fg-toolbar tb-main" id="toolbar-mostrarReporte">
		<a href="#panel-i_promedios-r-consolidado" id="link-promediosPorGrupos" class="fg-button ui-state-default ui-state-active ui-corner-left">CONSOLIDADO</a>
		<a href="#panel-i_promedios-r-cursos" id="link-promediosPorCursos" class="fg-button ui-state-default">CURSOS</a>
		<a href="#panel-i_promedios-r-nEstudiantes" id="link-nEstudiantes" class="fg-button ui-state-default ui-corner-right">N&deg; ESTUDIANTES</a>
    
  </div>
	<div class="accdn" id="accdn-i_promedios-r">
	
		<div class="accdn-item ui-helper-hidden" id="panel-i_promedios-r-cursos">
			<h3 class="ui-state-default">PROMEDIOS POR CURSOS</h3>
			<!-- PROMEDIOS POR CURSOS -->
			 <table class="table dataTable dt-non-paginable" id="table-i_promedios-r-cursos">
				<thead>
					<tr>
						<th class="column-hidden">Grupo</th><th>Curso</th>
						<th title="N&uacute;mero de Estudiantes">N&deg; Estud.</th>
							{foreach from=$componentes item=componente}
								<th>{$componente|upper|truncate:12|escape}</th>
							{/foreach}
					</tr>
				</thead>
				<tbody>
						{foreach from=$cursos item=curso}
					<tr>
						<td>{link_to name=$curso.grupo action=view cod_prueba=$cod_prueba cod_grupo=$curso.grupo cod_programa=$cod_programa}</td>
						<td>{link_to name=$curso.subgrupo|zeropad:2|cat:"`$curso.grupo`-":TRUE action=view cod_curso=$curso.cod_grupo cod_prueba=$cod_prueba}</td>
						<td>{$curso.cantidad_estud}</td>
						{foreach from=$componentes item=componente}
						<td>{$curso.$componente|string_format:"%.2f"}</td>
						{/foreach}
					</tr>
						{/foreach}
				</tbody>
			</table>
		</div>

		<!-- CANTIDAD DE ESTUDIANTES QUE PRESENTARON LA PRUEBA -->
		<div class="accdn-item ui-helper-hidden" id="panel-i_promedios-r-nEstudiantes">
			<h3 class="ui-state-default">N&deg; DE ESTUDIANTES<br/>QUE PRESENTARON PRUEBA {$nombre_prueba}</h3>
			<table class="table dataTable dt-non-paginable" id="table-i_promedios-r-nEstudiantes">
				<thead>
					<tr>
						<th class="column-hidden">Grupo</th><th>Curso</th>
							{foreach from=$componentes item=componente}
								<th>{$componente|upper|truncate:12|escape}</th>
							{/foreach}
					</tr>
				</thead>
				<tbody>
					{foreach from=$cursos item=curso}
					<tr>
						<td>{link_to name=$curso.grupo action=view cod_prueba=$cod_prueba cod_grupo=$curso.grupo cod_programa=$cod_programa}</td>
						<td>{link_to name=$curso.subgrupo|zeropad:2|cat:"`$curso.grupo`-":TRUE action=view cod_curso=$curso.cod_grupo cod_prueba=$cod_prueba}</td>
						{foreach from=$componentes item=componente}
						{assign var = ccomponente value="c`$componente`"}
						<td>{if $curso.$ccomponente neq 0} {$curso.$ccomponente|default:"-"} {else} - {/if}</td>
						{/foreach}
					</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
		
		<!-- PROMEDIOS POR GRUPOS -->
		<div class="accdn-item" id="panel-i_promedios-r-consolidado">
			<h3 class="ui-state-default">PROMEDIOS CONSOLIDADOS</h3>
			<table class="table dataTable dt-non-paginable dt-non-filterable" id="table-i_promedios-r-consolidado">
				<thead>
					<tr>
						<th>Grupo</th>
						{foreach from=$componentes item=componente}
							<th>{$componente|upper|truncate:12|escape}</th>
						{/foreach}
					</tr>
				</thead>
				<tbody>
					{foreach from=$grupos item=grupo}
					<tr>
						<td>
							{link_to name=$grupo.grupo action=view cod_prueba=$cod_prueba cod_grupo=$grupo.grupo cod_programa=$cod_programa}
						</td>
						{foreach from=$componentes item=componente}
							<td>{$grupo.$componente|string_format:"%.2f"}</td>
						 {/foreach}
					</tr>
					{/foreach}
				</tbody>
				<tfoot>
					<td>PROMEDIO</td>
					{foreach from=$componentes item=componente}
							<td>{$promediosTotales.$componente|string_format:"%.2f"}</td>
					{/foreach}
				</tfoot>
			</table>
      <div class='chart-container' id='chart-i_promedios-resumen-consolidado'>
      </div>
      
      <script type="text/javascript">
        var nombre_programa = '{$nombre_programa}';
        var nombre_prueba = '{$nombre_prueba}';
      </script>
      
		</div>
  </div>
  {/if}
</div>
