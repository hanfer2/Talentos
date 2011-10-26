<div class="ui-widget decorated">
 {if empty($persona)}
  <h1>Usuario no Hallado</h1>
  <p>El usuario {$cedula} No se encuentra registrado en nuestra Base de Datos</p>
 {else}

 <!--{include_partial file='view.tpl' module="estudiantes_notificaciones" }-->
   
  <h1>Informaci&oacute;n Personal</h1>
  
   <!-- Menu Sidebar-->
	  <div class="menu sidebar sb-float sb-r">
			<h3 class="ui-state-default">MENU</h3>
		{if $is_admin_login or $persona.cedula eq $smarty.session.user.cedula}
			<div>
			{if $is_admin_login}
	  	 	{link_to name='Actualizar Datos' action='edit' cedula=$cedula updated_by=$smarty.session.user.cedula}	
  	 	{/if}	
			{link_to name='Modificar Contraseña' action='edit_passwd' cedula=$cedula id='link-edit_passwd'}
			</div>
		{/if}
		<hr/>
		{if $persona.cod_tipo_per eq $smarty.const.COD_TIPO_ESTUDIANTE}
		 {if canViewStudent($cedula)}
 			 {link_to name='Consultar Horario' controller=horarios action=view cedula=$cedula}
			 {link_to name='Ver Datos Icfes' controller=icfes action=reporteIndividual cedula=$cedula}
			 {link_to name='Consultar Inasistencias' controller=asistencias action=view cedula=$cedula}
		 {/if}   
		 {if $is_admin_login }
			<hr/>
			 {if $persona.cod_estado neq $smarty.const.COD_ESTADO_ACTIVO}
				{link_to name="Ver I.E.S." controller='egresados' action='view' cedula=$cedula}
				{link_to name="Reactivar" controller='estudiantes' action='reactivate' cedula=$cedula}
      <hr/>
      {link_to name="Cambios de Estado" controller='auditoria' action='view' cambio='estado' cedula=$cedula}
      {link_to name="Cambios de Cedula" controller='auditoria' action='view' cambio='cedula' cedula=$cedula}
      {link_to name="Cambios de Rol" controller='auditoria' action='view' cambio='rol' cedula=$cedula}
			 {else}
				{link_to name='Ver Observaciones' controller='observaciones' action=view cedula=$cedula}
        
			{if is_admin_login()}<a href="#{$cedula}" id="link-verNotificaciones">Ver Notificaciones</a>{/if}
        	<!--{link_to name='Ver Notificaciones' controller='EstudiantesNotificaciones' action=view cedula=$cedula}-->
         
				<hr/>
				{if $cod_curso != null}
					<a href='#' id='link-cambiarCurso'>Cambiar de Curso</a>
				{else}
					<a href='#' id='link-asignarCurso'>Asignar Curso</a>
				{/if}
					<a href='#' id='link-delete-estudiante'>Dar de Baja</a>
				
			 {/if}
		 {/if}
		{elseif $persona.cod_tipo_per eq $smarty.const.COD_TIPO_DOCENTE}
			{link_to name='Consultar Horario' controller=horarios action=view cedula=$cedula}
			{link_to name='Cursos Asignados' controller='docentes' action=cursos cedula=$cedula}
		{elseif $persona.cod_tipo_per eq $smarty.const.COD_TIPO_DIGITA_ICFES}
			{link_to name='Diligenciar Cuestionarios' controller=i_cuestionarios_estudiantes action=add cod_prueba=$cod_prueba}
		{/if}
  </div>
  
  
  <div class="wrapper-header-info">
  <h2>{$persona.apellidos|escape}, {$persona.nombres|escape}</h2>
  <h3>{info classname='TPersona' func='cedula' args=$persona.cedula} de {info classname='TCiudad' func='nombre' args=$persona.cod_expedida}</h3>
	{assign var=nombre_persona value="`$persona.apellidos`, `$persona.nombres`"}
	<span class='hidden' id='persona_cedula'>{$cedula}</span>
	{if $persona.cod_tipo_per eq $smarty.const.COD_TIPO_ESTUDIANTE}
		{if $is_admin_login}
		<h3>
			{if $nombre_curso == null}
				Sin Curso
			{else}
				{#PNAT#} {link_to name=$cod_programa controller=estudiantes cod_programa=$cod_programa}
				 - Curso {link_to name=$nombre_curso controller=cursos action=view cod_curso=$cod_curso}
			{/if}
		</h3>
		{else}
		<h3> Curso {$nombre_curso|default:"<em>Sin Curso</em>"}</h3>
		{/if}
	{/if}
	</div>
	<!-- Personal Info-->
  <dl class="ui-text-container" id='hv'>
    <div class='hv-section' id='hv-section-id'>
	    {if $siat_user->isRoot()}
		  <div class='hv-field'>
			  <dt>C&oacute;d. Interno</dt>
			  <dd>{$persona.cod_interno}</dd>
		  </div>
		  {/if}
      <div class="hv-field">
        <dt>Tipo:</dt>
        <dd>{$persona.cod_tipo_per} - {info classname=TTipoPersona func=nombre args=$persona.cod_tipo_per}</dd>
      </div>
      {if $persona.cod_tipo_per eq $smarty.const.COD_TIPO_ESTUDIANTE}
      <div class="hv-field">
        <dt>C&oacute;digo:</dt>
        <dd>{$persona.cod_estud|escape}</dd>
      </div>
      <div class="hv-field">
        <dt>Fecha Ingreso:</dt>
        <dd>{$persona.fecha_ingreso|date_format}</dd>
      </div>
      {/if}
      <div class="hv-field">
        <dt>Estado:</dt>
        <dd id='hv-field-status'>
        	<span id='hv-field-status-text'>{$persona.nombre_estado}</span>
        	<span id='hv-field-status-icon'></span>
        </dd>
      </div>
      <div class="clear"></div>
    </div>
    <div class='hv-section'>
	    <div class="hv-field">
        <dt>Fecha de Nacimiento</dt>
        <dd>{$persona.fecha_nacimiento|date_format|default:"-"}</dd>
      </div>
	  	<div class="hv-field">
        <dt>Lugar de Nacimiento</dt>
        <dd>{$nombre_ciudad_nacimiento|default:"-"}</dd>
      </div>
      <div class="hv-field thin-field" >
        <dt>Edad:</dt>
        <dd>{$persona.edad|default:'-'}</dd>
      </div>
      <div class="clear"></div>
	    <div class="hv-field thin-field">
	      <dt>G&eacute;nero:</dt>
	      <dd>{$persona.genero|escape}</dd>
	    </div>
			<div class="hv-field">
	      <dt>Estado Civil:</dt>
	      <dd>{$persona.nombre_estado_civil|default:"-"}</dd>
	    </div>
	    <div class='hv-field thin-field'>
				<dt title='N&uacute;mero de Hijos'>N&deg; Hijos:</dt>
				<dd>{$persona.hijo|default:"-"}</dd>
			</div>
			{if $persona.genero eq 'F'}
			<div class='hv-field' id='hv-field-embarazo'>
				<dt title='En Embarazo'>En Embarazo:</dt>
				<dd>
					<span id='hv-status-embarazo'>{if $persona.enEmbarzo}&#10006;{else}&#10008;{/if}</span>
					{*if $persona.cod_tipo_per eq $smarty.const.COD_TIPO_ESTUDIANTE and $is_admin_login}
						<a href='#' id='link-editarEmbarazo' class='edit'> Editar</a>
					{/if*}
				</dd>
			</div>
			{/if}
	    <div class="clear"></div>
		</div>
    <div class='hv-section'>
		    <div class="hv-field">
		      <dt>Direcci&oacute;n:</dt>
		      <dd>{$persona.direccion|default:"-"}</dd>
		    </div>
		    <div class="hv-field">
		      <dt>Barrio:</dt>
		      <dd>{$persona.nombre_barrio|default:"-"|escape}</dd>
		    </div>
		    <div class="hv-field">
	        <dt>Ciudad:</dt>
	        <dd>{$persona.nombre_ciudad|default:"-"|escape}</dd>
	      </div>
	      <div class="hv-field thin-field">
		      <dt>Estrato:</dt>
		      <dd>{$persona.estrato|default:"-"|string_format:"%1d"}</dd>
		    </div>
		    <div class="hv-field thin-field">
		      <dt>Comuna:</dt>
		      <dd>{$persona.comuna|default:"-"|string_format:"%2.0d"}</dd>
		    </div>
		    <div class="clear"></div>
			  <div class="hv-field">
			    <dt>Tel&eacute;fono:</dt>
			    <dd>{join sep=", " parts="`$persona.telefono`;`$persona.telefono_alt`"|escape default="-"}</dd>
		    </div>
		    <div class="hv-field">
		      <dt>Celular:</dt>
		      <dd>{$persona.tel_celular|default:"-"}</dd>
		    </div>
		    <div class="hv-field">
		      <dt>Correo Electr&oacute;nico:</dt>
		      <dd>{join sep=", " parts="`$persona.email`; `$persona.email_2`"|lower default="-"}</dd>
		    </div>
		    <div class="clear"></div>
	  </div>
	  {if $persona.cod_tipo_per eq $smarty.const.COD_TIPO_ESTUDIANTE}
    <div class='hv-section'>
			<div class='hv-field'>
				<dt>Colegio</dt>
				<dd>{$persona.colegio.nombre|default:"-"|escape}</dd>
			</div>
			<div class='hv-field'>
				<dt>Tipo</dt>
				<dd>{$persona.colegio.tipo}</dd>
			</div>
			<div class='clear'></div>
    </div>
    {/if}
    <div class='hv-section' id='hv-section-exencion'>
			<div class='hv-field'>
				<dt>Etnia</dt>
				<dd>{$persona.nombre_etnia|default:"NINGUNA"}</dd>
			</div>
			<div class='hv-field'>
				<dt>Desplazamiento</dt>
				<dd> {$persona.nombre_ciudad_desplazado|default:"NINGUNO"|escape}
				{if $persona.cod_tipo_per eq $smarty.const.COD_TIPO_ESTUDIANTE and $is_admin_login}
					<a href='#' id='link-editarDesplazamiento' class='edit'> Editar</a>
				{/if}
				</dd>
			</div>
			<div class='hv-field'>
				<dt>Discapacidad</dt>
				<dd>{$persona.nombre_discapacidad|default:"NINGUNA"}</dd>
			</div>
			<div class='clear'></div>
    </div>
  </dl>

  <div>{include_partial file='edit_passwd.tpl' cedula=$cedula}</div>
  {if $is_admin_login and $persona.cod_tipo_per eq $smarty.const.COD_TIPO_ESTUDIANTE}
	<div>
		{include_partial file='delete.tpl' cod_interno=$persona.cod_interno causas_bloqueo=$causas_bloqueo nombre=$nombre_persona}
		{include_partial file='cambiarCurso.tpl' module="estudiantes" cod_interno=$persona.cod_interno cursos=$cursos nombre_persona=$nombre_persona cod_curso=$cod_curso}
		{include_partial file='editar_desplazado.tpl' module="estudiantes" cod_interno=$persona.cod_interno ciudades=$ciudades cod_ciudad=$persona.cod_ciudad_desplazado nombre_persona=$nombre_persona}			
		
		{*if $persona.genero eq 'F'}
			<div id='form-editarEmbarazo' title='Actualizaci&oacute;n Situaci&oacute;n de Embarazo'>
				<p>¿Desea {if $persona.enEmbarzo}dejar de {/if}definir a este participante como <strong>en Estado de Embarazo</strong>?</p>
			</div>
		{/if*}
	</div>

  {/if}
  
 {/if}
</div>
