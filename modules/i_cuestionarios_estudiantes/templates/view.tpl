{if !isset($cod_prueba)}
	{include_template file="simulacros_con_cuestionario" title="Mostrar Respuestas De Participante"}
	<div class='ajax-response'></div>
{else}
	{if !isset($cedula)}
		{include_template file="persona.form" title="Mostrar Respuestas De Participante En Simulacro"}
		<div class='ajax-response' id='ajax-mostrarNotasSimulacro'></div>
	{else}
		<div class='ui-widget decorated'>
			<div class="menu sidebar sb-r sidebar-fixed">
				<h3 class="ui-state-default">COMPONENTES</h3>
				{foreach from=$respuestas key=nombre_componente item=preguntas}
					<a href="#c-{$nombre_componente|underscorify}">{$nombre_componente}</a>
				{/foreach}
        {if is_root_login() or $is_digita_icfes_login}
				<hr/>
				<a href="{url_for action=edit cedula=$cedula cod_prueba=$cod_prueba}" class="link-edit"><span class="icon"></span> Editar Respuestas</a>
        {/if}
			</div>
			
			<h1>Respuestas De Participante en {$nombre_prueba}</h1>
			<h2>{persona_url cedula=$cedula} - {$nombre_persona}</h2>
			
					
			<div class="ui-toolbar">
				{link_to name="Consultar Icfes" controller=icfes action=view cedula=$cedula} |
				{if $cantidad_respuestas gt 0}
					{link_to name="Reporte Competencias" controller=i_competencias_estudiantes action=view cedula=$cedula cod_prueba=$cod_prueba} | 
					{link_to name="Reporte Componentes/Cualitativos" controller=i_cualitativos_estudiantes action=view cedula=$cedula cod_prueba=$cod_prueba}
				
				{else}
				<a class="link-add" href="{url_for action=add cedula=$cedula cod_prueba=$cod_prueba}"><span class="icon ui-icon error-icon"></span>Ingresar Notas</a>
				{/if}
			</div>
			{if $cantidad_respuestas gt 0}
			<div class="frm-4 info-summary ui-corner-all">
				Cantidad de Preguntas Respondidas: <strong>{$cantidad_respuestas}</strong><br/>
				{if is_root_login()}
				Diligenciado Por: <strong>{$nombre_digitador}</strong><br/>
				{/if}
			</div>
			{else}
			<div class="ui-state-notice ui-corner-all frm-3"><span class="ui-icon ui-icon-alert left-icon error-icon"></span>Este cuestionario no ha sido diligenciado a&uacute;n</div>
			{/if}
			<div class="fg-toolbar center ui-helper-clearfix" id="menu-toggleRespuestasComponentes">
						<a href="#" class="fg-button fg-button-icon-left ui-state-default ui-corner-left" id="link-expandAll"><span class="ui-icon ui-icon-plus"></span>Expandir Todo</a>
						<a href="#" class="fg-button fg-button-icon-right ui-state-default ui-corner-right" id="link-contractAll">Contraer Todo<span class="ui-icon ui-icon-minus"></span></a>
			</div>
			
			<div class='wrapper-respuestasComponente'>
				{foreach from=$respuestas key=nombre_componente item=preguntas}
					<h5 class='header-nombreComponente ui-state-default' id="c-{$nombre_componente|underscorify}">{$nombre_componente}</h5>
					<div class="inner-respuestasComponente">
					{foreach from=$preguntas item=pregunta}
					<div class="questions-line-field fixed-width">
						<div class='ui-field inline'>
							Pregunta {$pregunta.numeral|zeropad:3}:
						</div>
						{foreach from=$letras item=letra}
							<div class='ui-field inline {if !$is_digita_icfes_login and in_array($letra|upper, $pregunta.respuesta)}letraConRespuestaCorrecta ui-corner-all{/if} {if $pregunta.$letra eq "t"}letra-escogida{/if}'>
								<label class="lb-letra">{$letra|upper}</label>
								<span class='casilla resp-{$pregunta.$letra}'>
								{if $pregunta.$letra eq 't'}&#9632;{else}&#9633;{/if}
								</span>
								
								{if !$is_digita_icfes_login}
								<span class="placeholder"></span>
								{/if}
							</div>
						{/foreach}
						{if $is_digita_icfes_login or is_root_login() }
							<a href="#{$cedula}-{$cod_prueba}-{$pregunta.numeral}" class="link-editarRespuesta edit link-edit"><span class="icon"></span> Editar</a>
						{/if}
						{if not $is_digita_icfes_login or $pregunta.VALORACION eq 'VACIAS'}
							<div class="ui-field inline nota-valoracion">
								<span class='respuesta-{$pregunta.VALORACION|lower}'>{$pregunta.VALORACION|substr:0:-1}</span>
							</div>
						{/if}
					</div>
					{/foreach}
				</div>
				{if not $is_digita_icfes_login}
					<div class="question-line-field fixed-width subtotal-valoracion">
						{foreach from=$resumen.$nombre_componente key=valoracion item=subtotal}
							{if $valoracion neq 'NO CALIFICADAS'}
								<div class="ui-field inline">
									<label class='respuesta-{$valoracion|lower}'>Total {$valoracion}:</label><span>{$subtotal}</span>
								</div>
							{/if}
						{/foreach}
					</div>
				{/if}
				{/foreach}
			</div>
			
			<div>
				{if not $is_digita_icfes_login and is_array($resumen.GENERAL)}
					<table class="table" id="table-resumenNotas">
						<caption>Resumen</caption>
					{foreach from=$resumen.GENERAL key=valoracion item=subtotal}
						{if $valoracion neq 'NO CALIFICADAS'}
						<tr class="respuesta-{$valoracion|lower}">
							<th>{$valoracion}</th><td>{$subtotal}</td>
						</tr>
						{/if}
					{/foreach}
					<tr class="total">
						<th>TOTAL</th><td>{$resumen.GENERAL|@array_sum}</td>
					</tr>
					</table>
				{/if}
			</div>
			<div class="toTop">Arriba<span class="ui-icon"></span></div>
			{if $is_digita_icfes_login}
			{link_to name="Volver" action=add cod_prueba=$cod_prueba}
			{/if}
			{if is_root_login()}
			<a href="#{$cedula}-{$cod_prueba}" id="link-eliminarCuestionario">Eliminar Cuestionario</a>
			{/if}
		</div>
	{/if}

{/if}
