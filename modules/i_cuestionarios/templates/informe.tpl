{if is_blank($cod_prueba)}
	{include_template file="simulacros_con_cuestionario" title="Reporte de Cuestionarios"}
	<div class='ajax-response'></div>
{else}
	<div class="ui-widget decorated">
		<h1>Reporte de Cuestionarios</h1>
		<h2>{$nombre_prueba} {$nombre_programa}</h2>
		<div id="wrapper-reporteCuestionario">
			<div id="wrapper-cuestionario-competencias" class="item-reporte item-reporteCuestionario">
				<h3>Competencias</h3>
				<ul id="list-cuestionario-competencias" class="list-reporte-cuestionario">
					{foreach from=$rComponentes key=nombre_componente item=c}
						<li class="item-componentes-detalles"><div class="nombre-componente h-3 ui-state-default">{$nombre_componente|escape|capitalize}</div>
							<ol>
							{foreach from=$c.competencias key=nombre_competencia item=cantidad_preguntas}
								<li class="item-competencias">
									<span class="nombre-competencia label-item">{$nombre_competencia|default:"NINGUNA"|escape|capitalize}:</span> 
									<span class="cantidad-preguntas value-item">{$cantidad_preguntas}</span>
								</li>
							{/foreach}
							</ol>
						</li>
					{/foreach}
				</ul>
			</div>
			<div id="wrapper-cuestionario-cualitativos" class="item-reporte item-reporteCuestionario">
				<h3>Componentes Cualitativos</h3>
				<ul id="list-cuestionario-cualitativos" class="list-reporte-cuestionario">
					{foreach from=$rComponentes key=nombre_componente item=c}
						<li class="item-componentes-detalles"><div class="nombre-componente h-3 ui-state-default">{$nombre_componente|escape|capitalize}</div>
							<ol>
							{foreach from=$c.cualitativos key=nombre_cualitativo item=cantidad_preguntas}
								<li class="item-cualitativo">
									<span class="nombre-cualitativo label-item">{$nombre_cualitativo|default:"NINGUNA"|escape|capitalize}:</span> 
									<span class="cantidad-preguntas value-item">{$cantidad_preguntas}</span>
								</li>
							{/foreach}
							</ol>
						</li>
					{/foreach}
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<div class="date date-report">Realizado: {'now'|date_format:$smarty.const.TIMESTAMP_FORMAT|escape}</div>
	</div>
{/if}
