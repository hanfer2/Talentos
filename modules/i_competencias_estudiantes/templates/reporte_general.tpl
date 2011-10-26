<div class="ui-widget decorated">
<h1 class="title-reporteGeneral">Reporte General de Competencias</h1>
<h2>{nombre_programa} - {$nombre_prueba}</h2>

{if is_null($reporte)}
	<p>Esta prueba no presenta a&uacute;n competencias registradas</p>
{else}

<div id="reporteGeneral-competencias-main">	
	
	{*Barra para seleccionar el grupo a mostrar*}
	<div class="fg-toolbar center ui-helper-clearfix tb-main" id="menu-toggleGrupo">
		<a href="#consolidado" class="fg-button ui-state-default ui-corner-all">Consolidado</a>
		{foreach from=$grupos item=grupo name=toggle_grupos}<a href="#{$grupo|underscorify}" class="fg-button ui-state-default {if $smarty.foreach.toggle_grupos.first}ui-corner-left {elseif $smarty.foreach.toggle_grupos.last}ui-corner-right{/if}">{$grupo}</a>{/foreach}
	</div>
	
	<!-- REPORTE CONSOLIDADO -->
	<div class="outer-i_calificador-reporteGeneral ui-helper-hidden ui-corner-top" id="outer-competencias-reporteGeneral-consolidado">
		<h3 class="header-widget ui-state-default ui-corner-top" id='header-competencias-reporteGeneral-consolidado'>Consolidado</h3>
		<div class="ui-toolbar fg-toolbar toolbar-irAComponente">
				{foreach from=$nombres_componentes item=componente}
					<a href="#{$componente|escape|underscorify|upper}" class="fg-button ui-state-default link-irAComponente" title="{$componente|escape}">{$componente|truncate:3:""|escape|upper}</a>
				{/foreach}
			</div>
		<div class="wrapper-i_calificador-reporteGeneral" id="wrapper-competencias-reporteGeneral-consolidado">
		
			<div class="inner-i_calificador-reporteGeneral">
				{foreach from=$nombres_componentes item=componente}
				<h4 class="area-{$componente|escape|underscorify|upper}">
					<span class="clickable link-toggleComponente">{$componente|escape|capitalize}</span>
					<span class="link-goUp ui-icon right-icon inline-icon ui-icon-arrowthickstop-1-n clickable" title="Subir"></span>
					<span class="link-displayChart ui-icon right-icon nuvola-icon ui-nuvola-chart-1 clickable" title="Ver Gr&aacute;fico"></span>
				</h4>
				
				<table class="table dataTable table-toggable non-paginable table-reporteCompetencias">
				<!-- Cabecera de la Tabla-->
				<thead>
					<tr>
						<th>Grupo</th>
						{foreach from=$__componentes.$componente item=competencia}
							<th>
								<div>{$competencia.nombre_competencia|ucfirst|escape}</div>
								<div class="cantidad-preguntas subtitle-header" title="Cantidad de preguntas por competencia en el área.">
									<div class="valor inline">{$competencia.cantidad_preguntas}</div> preguntas
								</div>
							</th>
							<th class="strong">%</th>
						{/foreach}
					</tr>
				</thead>
				<!--Cuerpo de la tabla-->
				<tbody>
				{foreach from=$reporte.consolidado key=cod_grupo item=grupo}
				<tr>
					<td>{$cod_grupo}</td>
					
					{foreach from=$__componentes.$componente item=competencia}
						{assign var=nombre_competencia value=$competencia.nombre_competencia}
						{assign var=p value= $grupo.$componente.$nombre_competencia}
						<td>
							<span class="cantidad-preguntas-correctas">{$p.puntaje|string_format:"%.0f"}</span><sub class="tiny">/ {math equation="preguntas*total" preguntas=$p.preguntas total=$p.cantidad }</sub>
						</td>
						<td class="strong">
							<strong class="porcentaje porcentaje-preguntas-correctas">
								{math equation="buenas*100/(preguntas*total_estudiantes)" buenas=$p.puntaje preguntas=$p.preguntas total_estudiantes=$p.cantidad format="%.2f%%"}
							</strong>
						</td>
					{/foreach}
				</tr>
				{/foreach}
				</tbody>
				</table>
			{/foreach}
			</div> <!-- FIN inner-competencias-reporteGeneral-consolidado-->
		</div> <!-- FIN wrapper-competencias-reporteGeneral-consolidado -->
	</div>
	
	<!-- Reporte por Grupos -->
	{foreach from=$grupos item=grupo}
	<div class="outer-i_calificador-reporteGeneral ui-helper-hidden ui-corner-top" id="outer-competencias-reporteGeneral-{$grupo}">
		{* Cabecera con nombre del grupo *}
		<h3 class="header-widget ui-state-default ui-corner-top" id='header-competencias-reporteGeneral-{$grupo|underscorify}'>Grupo {$grupo}</h3>
			<div class="ui-toolbar fg-toolbar toolbar-irAComponente">
				{foreach from=$nombres_componentes item=componente}
					<a href="#{$componente|escape|underscorify|upper}" class="fg-button ui-state-default link-irAComponente" title="{$componente|escape}">{$componente|truncate:3:""|escape|upper}</a>
				{/foreach}
			</div>
		<div class="wrapper-i_calificador-reporteGeneral wrapper-i_calificadores-reporteGeneral" id='wrapper-competencias-reporteGeneral-{$grupo}'>
					
			<div class="inner-i_calificador-reporteGeneral">
			{foreach from=$nombres_componentes item=componente}
				<h4 class="area-{$componente|escape|underscorify|upper}">
					<span class="clickable link-toggleComponente">{$componente|escape|capitalize}</span>
					<span class="link-goUp ui-icon right-icon inline-icon ui-icon-arrowthickstop-1-n clickable" title="Subir"></span>
				</h4>
				
				<table class="table dataTable table-toggable non-paginable table-reporteCompetencias">
				<!-- Cabecera de la Tabla-->
				<thead>
					<tr>
						<th>Curso</th>
						{foreach from=$__componentes.$componente item=competencia}
							<th>
								<div>{$competencia.nombre_competencia|ucfirst|escape}</div>
								<div class="cantidad-preguntas subtitle-header" title="Cantidad de preguntas por competencia en el área.">
									<div class="valor inline">{$competencia.cantidad_preguntas}</div>
									preguntas
								</div>
							</th>
							<th class="strong">%</th>
						{/foreach}
					</tr>
				</thead>
				<!--Cuerpo de la tabla-->
				<tbody>
				{foreach from=$reporte.$grupo key=cod_curso item=curso}
				<tr>
					<td>{link_to name=$curso.nombre|escape action=view cod_curso=$cod_curso cod_prueba=$cod_prueba}</td>
					
					{foreach from=$__componentes.$componente item=competencia}
						{assign var=nombre_competencia value=$competencia.nombre_competencia}
						{assign var=p value= $curso.puntajes.$componente.$nombre_competencia}
						<td>
							<span class="cantidad-preguntas-correctas">{$p.puntaje|string_format:"%.0f"}</span><sub class="tiny">/ {math equation="preguntas*total" preguntas=$p.preguntas total=$p.cantidad }</sub>
						</td>
						<td class="strong">
							<strong class="porcentaje porcentaje-preguntas-correctas">
								{math equation="buenas*100/(preguntas*total_estudiantes)" buenas=$p.puntaje preguntas=$p.preguntas total_estudiantes=$p.cantidad format="%.2f%%"}
							</strong>
						</td>
					{/foreach}
				</tr>
				{/foreach}
				</tbody>
				</table>
			{/foreach}
			</div><!-- FIN inner-competencias-reporteGeneral-->
		</div><!-- FIN wrapper-competencias-reporteGeneral-->
		</div><!-- FIN outer-competencias-reporteGeneral-->
	{/foreach}
</div>
{/if}
</div>
