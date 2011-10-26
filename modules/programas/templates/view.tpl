<div class="ui-widget decorated">
	{if empty($cod_programa)}
		<h1>{#PNAT#} No Hallado!</h1>
		{if is_professor_login()}
			<p>Usted no tiene cursos asignados actualmente</p>
		{/if}
	{else}
		<h1>Informaci&oacute;n {#PNAT#}</h1>
		<h2><span id="sp-value-cod_programa">{$cod_programa}</span> - {nombre_programa}</h2>
    
    
  {if $siat_user->isRoot()}
   <div class="menu sidebar sb-float sb-r">
			<h3 class="ui-state-default">MENU</h3>
      <div>
        {if not $is_closed}
          {link_to name='Configuración' action='configurar' cod_programa=$cod_programa}
          {link_to name='Cerrar' action='close' cod_programa=$cod_programa}
        {/if}
      </div>
   </div>
  {/if}
  {if ! $siat_user->isStudent()}
		<div class="ui-toolbar">
			{link_to name="Listado de PNAT's"} <br/>
      {link_to name='Listado de Participantes' controller=estudiantes cod_programa=$cod_programa} |
      {link_to name='Listado de Cursos' controller='cursos' cod_programa=$cod_programa}
		</div>
  {/if}
  {if $is_closed}
    <div class="ui-state-highlight ui-corner-all frm-3 notif-block ">
      <span class="ui-icon ui-icon-circle-close inline-icon"></span> Este programa se encuentra <strong>cerrado</strong>.
    </div>
    <br/>
  {/if}
		<div id='wrapper-semestres'>
			{section name=semestre start=1 loop=$cantidad_semestres+1}
			{assign var=semestre value=$smarty.section.semestre.index}
			<div class="boxed" id="box-semestre-{$semestre}">
				<div class="ui-subtitle-section">Semestre {$semestre}</div>
				<div class='box-date-semestre' >
					<label>De:</label>
					{assign var=fecha_inicio value="fecha_inicio_$semestre"}
					<strong class="date dark-highlighted-text">{$programa.$fecha_inicio|date_format}</strong>
					<label>Hasta:</label>
					{assign var=fecha_cierre value="fecha_cierre_$semestre"}
					<strong class="date dark-highlighted-text">{$programa.$fecha_cierre|date_format}</strong>
				</div>
				
				<div class='placeholder-listado-componentes' id="placeholder-listado-componentes-{$semestre}"></div>
				
			</div>
			{/section}
			<div class="clear"> </div>
		</div>
    {if $siat_config->get('cursos_especiales.enabled')}
    <div class="boxed" id="box-cursos_especiales">
      <h4 class="ui-subtitle-section">Cursos Especiales</h4><br/>
      <div class='placeholder-listado-componentes' id="placeholder-listado-componentes-cursos_especiales"></div>
      <div class="ui-toolbar">
        {if not $is_closed}
        {link_to name="Configurar Cursos Especiales" controller=cursos_especiales action=index cod_programa=$cod_programa}
        {/if}
      </div>
    </div>
    {/if}
	{/if}
</div>
