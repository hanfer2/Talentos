<div class="ui-widget decorated" id="widget-reporte-cualitativos">
<h1>Reporte de Componentes Cualitativos Por Curso</h1>
<h2>{$nombre_prueba} - Curso {$nombre_curso}</h2>
{if is_null($reporte)}
	<p>Este curso para esta prueba no presenta a&uacute;n componentes cualitativos registradas</p>
{else}

<div id="wrapper-reporteCualitativosPorCurso">	
	{* Toolbar*}
	<div class="fg-toolbar center ui-helper-clearfix" id="menu-toggleRespuestasComponentes">
			<a href="#" class="fg-button fg-button-icon-left ui-state-default ui-corner-left" id="link-expandAll"><span class="ui-icon ui-icon-plus"></span>Expandir Todo</a>
			<a href="#" class="fg-button fg-button-icon-right ui-state-default ui-corner-right" id="link-contractAll">Contraer Todo<span class="ui-icon ui-icon-minus"></span></a>
	</div>
	
{foreach from=$nombres_componentes item=componente}
	<h3 class="header-widget ui-state-default ui-corner-all clickable">{$componente|escape|capitalize}</h3>
	<table class="table dataTable table-toggable non-paginable table-reporteCalificador table-reporteCualitativos table-reportePorCurso">
	<thead>
		<tr>
			<th>Doc. Id</th>
			<th>Nombre</th>
			{foreach from=$__componentes.$componente item=cualitativo}
				<th>
          <div>{$cualitativo.nombre_cualitativo|ucfirst|escape}</div>
          <div class="cantidad-preguntas subtitle-header">
            <div class="valor inline">{$cualitativo.cantidad_preguntas}</div>
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
		{foreach from=$__componentes.$componente item=cualitativo}
			{assign var=nombre_cualitativo value=$cualitativo.nombre_cualitativo}
			<td>
        <span class="cantidad-preguntas-correctas">{$estudiante.puntajes.$componente.$nombre_cualitativo|string_format:"%.0f"}</span> |
        <strong class="porcentaje porcentaje-preguntas-correctas"></strong>
      </td>
		{/foreach}
	</tr>
	{/foreach}
  </tbody>
  <tfoot>
    <tr>
			<td colspan="2"><strong class="total">TOTAL</strong></td>
			{foreach from=$__componentes.$componente item=cualitativo}
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
