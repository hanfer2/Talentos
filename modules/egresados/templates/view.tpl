<div class="ui-widget decorated">
 <h1>Reporte Individual de Egresados</h1>
 {if !empty($egresado)}
	  <h2>{persona_url} - {$nombre_persona}</h2>
		<h3>{nombre_programa cod_programa = $egresado.cod_programa}</h3>

	  <div class="ui-sectioned-panel">
			 <!--- SITUACION ACADEMICA -->
			 <h5 class="ui-title-section no-border-t clickable">Situaci&oacute;n Acad&eacute;mica</h5>
			 <dl class="ui-text-container" id="container-reporteIES"  >
			 <dt>Universidad:</dt>
			 <dd>{if is_blank($egresado.nombre_universidad)}NO DEFINIDA{else}{link_to name=$egresado.nombre_universidad controller=universidades action=egresados cod_universidad=$egresado.cod_universidad }{/if}</dd>
			 <dt>Carrera:</dt>
			 <dd>{if is_blank($egresado.nombre_carrera)}NO DEFINIDA{else}{link_to name=$egresado.nombre_carrera controller=universidades action=egresados cod_universidad=$egresado.cod_universidad cod_carrera=$egresado.cod_carrera }{/if}</dd>
			 <dt>Nro. Semestres:</dt>
			 <dd>{$egresado.nSemestres|default:"NO DEFINIDO"}</dd>
			 <dt>Fecha Ingreso</dt>
			 <dd>{if is_blank($egresado.fecha_ingreso_univ)}NO DEFINIDA{else}{$egresado.fecha_ingreso_univ|date_format}{/if}</dd>
			</dl>
			<div class="ui-toolbar">
				{if !is_blank($egresado.nombre_universidad)}
					<a href="#{$cedula}" id="link-eliminarRegistro-IES"><span class="ui-icon ui-error-icon ui-icon-close inline-icon"></span> Eliminar Registro</a>
				{else}
					<span class="ui-icon ui-error-icon ui-icon-plus inline-icon"></span>
					{link_to name="Registrar I.E.S." action="add" cedula=$cedula}
				{/if}
			</div>
			<!--- SITUACION LABORAL -->
			<h5 class="ui-title-section clickable">Situaci&oacute;n Laboral</h5>
			<dl class="ui-text-container" id="container-reporteLaborando" >
			 <dt>Ocupaci&oacute;n:</dt><dd>{$egresado.ocupacion|default:"NO DEFINIDA"}</dd>
			</dl>
			{if !is_blank($egresado.ocupacion)}
			 <div class="ui-toolbar">
				<a href="#{$cedula}" id="link-eliminarTrabajo"><span class="ui-icon ui-error-icon ui-icon-close inline-icon">Eliminar Registro</a>
			 </div>
			{/if}
		</div>
 {else}
	 {capture assign="error_message"}
			Al estudiante <strong>{persona_url name=$nombre_persona}</strong><br/>
			aún no se ha reportado su Ingreso a la Educaci&oacute;n Superior <br/>o como Laborando.
			<div class="ui-toolbar">
			{link_to name="Registrar su Ingreso a Educacion Superior o como Laborando" action=add cedula=$cedula}
			</div>
		{/capture}
		{include_template file="error" message=$error_message}
	{/if}
	<div class="ui-toolbar">
	{link_to name="Registrar Egresados" action=add} |
	{link_to name="Listado de Egresados"}
	</div>
</div>

