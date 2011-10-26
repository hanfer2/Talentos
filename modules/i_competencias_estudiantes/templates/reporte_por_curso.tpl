<div class="ui-widget decorated" id="widget-reporte-competencias">
<h1>Reporte de Competencias Por Curso</h1>
<h2>{$nombre_prueba} - Curso {$nombre_curso}</h2>
{if is_null($reporte)}
	<p>Este curso para esta prueba no presenta aún competencias registradas</p>
{else}

<div id="wrapper-reporteCompetenciasPorCurso">	
	{* Toolbar*}
	<div class="fg-toolbar center ui-helper-clearfix" id="menu-toggleRespuestasComponentes">
			<a href="#" class="fg-button fg-button-icon-left ui-state-default ui-corner-left" id="link-expandAll"><span class="ui-icon ui-icon-plus"></span>Expandir Todo</a>
			<a href="#" class="fg-button fg-button-icon-right ui-state-default ui-corner-right" id="link-contractAll">Contraer Todo<span class="ui-icon ui-icon-minus"></span></a>
	</div>
	
{foreach from=$__componentes|@array_keys item=componente}
	<h3 class="header-widget ui-state-default ui-corner-all clickable">{$componente|escape|capitalize}</h3>
	<table class="table dataTable table-toggable non-paginable table-reporteCalificador table-reporteCompetencias table-reportePorCurso">
	<thead>
		<tr>
			<th>Doc. Id</th>
			<th>Nombre</th>
			{foreach from=$__componentes.$componente item=competencia}
				<th>
          <div>{$competencia.nombre_competencia|ucfirst|escape}</div>
          <div class="cantidad-preguntas subtitle-header">
            <div class="valor inline">{$competencia.cantidad_preguntas}</div>
            preguntas
          </div>
        </th>
			{/foreach}
		</tr>
	</thead>
  <tbody>
	{foreach from=$reporte key=cedula item=estudiante}
	<tr>
		<td>{persona_url cedula=$cedula}</td>
		<td>{link_to name=$estudiante.fullname|escape action=view cedula=$cedula cod_prueba=$cod_prueba}</td>
		{foreach from=$__componentes.$componente item=competencia}
			{assign var=nombre_competencia value=$competencia.nombre_competencia}
			<td>
        <span class="cantidad-preguntas-correctas">{$estudiante.puntajes.$componente.$nombre_competencia|string_format:"%.0f"}</span> |
        <strong class="porcentaje porcentaje-preguntas-correctas"></strong>
      </td>
		{/foreach}
	</tr>
	{/foreach}
  </tbody>
  <tfoot>
    <tr>
			<td colspan="2"><strong class="total">TOTAL</strong></td>
			{foreach from=$__componentes.$componente item=competencia}
				<td> 
          <div class="cantidad-preguntas-correctas inline total"></div> |
          <strong class="porcentaje porcentaje-preguntas-correctas total"></strong>
        </td>
			{/foreach}
		</tr>
  </tfoot>
	</table>
{/foreach}
</div>
{/if}
</div>
