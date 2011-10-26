{if !isset($cod_curso)}
  {if $smarty.get.t eq 'ce'}
    {include_template file="curso_especial.form" title="Configurar Horarios Especiales"}
  {elseif !isset($semestre)}
    {include_template file="cursos_con_semestres" title="Configurar Horarios"}
  {/if}
	<div class='ajax-request' id="ajax-horarios-edit"></div>
{else}
	<div class='ui-widget decorated' id='widget-configurar-horarios'>
  {link_open_external}
		<h1>Editar Horarios</h1>
		<h2><span title="PNAT {$cod_programa}, Semestre {$semestre}" class="tooltip">
			PNAT {$cod_programa}-<span id="horario-semestre-valor">{$semestre}</span></span> :: Curso {$nombre_curso}
		</h2>
		<span id='horario-cod_curso' class='ui-helper-hidden'>{$cod_curso}</span>
		
		{if empty($componentes)}
		<div class='notice-error'>
			<span class="t-icon-alert t-icon-alert-64 left-icon"></span>
			<p class='ui-state-error-text'>No hay componentes registrados<br/>para este semestre</p>
			<span class="clear"></span>
		</div>
		{else}
			<!-- FULLCALENDAR-->
			<div class='full-calendar' id='calendar-editHorarios'></div>
			
			<!-- Listado de Componentes-->
			<div id='wrapper-listadoDeComponentes' class='ui-corner-all'>
				<h4 class='ui-state-default'>Componentes</h4>
				<div id='inner-listadoDeComponentes'>
					{foreach from=$componentes item=componente}
					<div class='item-componente ui-corner-all draggable'>
						<input type="checkbox" /> <span class='item-nombre_componente'>{$componente.nombre|escape} </span>
						<span class='hidden item-cod_componente'>{$componente.codigo}</span>
					</div>
					{foreachelse}
						<div>No hay componentes asignados</div>
					{/foreach}
				</div>
			</div>
			
			<div class="clear"></div>
			
      <span class="ui-helper-hidden" id="horario-fechaInicio-valor">{$fechas.inicio}</span> 
			<span class="ui-helper-hidden" id="horario-fechaCierre-valor">{$fechas.cierre}</span> 
			
			{include_partial file="_form.tpl" sedes=$sedes docentes=$docentes periodicidad=$periodicidad}
		{/if}
	</div>
{/if}
