<?php /* Smarty version 2.6.26, created on 2011-11-21 20:45:46
         compiled from ./modules/personas/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_partial', './modules/personas/templates//view.tpl', 7, false),array('function', 'link_to', './modules/personas/templates//view.tpl', 17, false),array('function', 'info', './modules/personas/templates//view.tpl', 65, false),array('function', 'join', './modules/personas/templates//view.tpl', 178, false),array('modifier', 'escape', './modules/personas/templates//view.tpl', 64, false),array('modifier', 'default', './modules/personas/templates//view.tpl', 79, false),array('modifier', 'date_format', './modules/personas/templates//view.tpl', 103, false),array('modifier', 'string_format', './modules/personas/templates//view.tpl', 169, false),array('modifier', 'lower', './modules/personas/templates//view.tpl', 186, false),)), $this); ?>
<div class="ui-widget decorated">
 <?php if (empty ( $this->_tpl_vars['persona'] )): ?>
  <h1>Usuario no Hallado</h1>
  <p>El usuario <?php echo $this->_tpl_vars['cedula']; ?>
 No se encuentra registrado en nuestra Base de Datos</p>
 <?php else: ?>

 <!--<?php echo smarty_function_include_partial(array('file' => 'view.tpl','module' => 'estudiantes_notificaciones'), $this);?>
-->
   
  <h1>Informaci&oacute;n Personal</h1>
  
   <!-- Menu Sidebar-->
	  <div class="menu sidebar sb-float sb-r">
			<h3 class="ui-state-default">MENU</h3>
		<?php if ($this->_tpl_vars['is_admin_login'] || $this->_tpl_vars['persona']['cedula'] == $_SESSION['user']['cedula']): ?>
			<div>
			<?php if ($this->_tpl_vars['is_admin_login']): ?>
	  	 	<?php echo smarty_function_link_to(array('name' => 'Actualizar Datos','action' => 'edit','cedula' => $this->_tpl_vars['cedula'],'updated_by' => $_SESSION['user']['cedula']), $this);?>
	
  	 	<?php endif; ?>	
			<?php echo smarty_function_link_to(array('name' => 'Modificar Contraseña','action' => 'edit_passwd','cedula' => $this->_tpl_vars['cedula'],'id' => 'link-edit_passwd'), $this);?>

			</div>
		<?php endif; ?>
		<hr/>
		<?php if ($this->_tpl_vars['persona']['cod_tipo_per'] == @COD_TIPO_ESTUDIANTE): ?>
		 <?php if (canViewStudent ( $this->_tpl_vars['cedula'] )): ?>
 			 <?php echo smarty_function_link_to(array('name' => 'Consultar Horario','controller' => 'horarios','action' => 'view','cedula' => $this->_tpl_vars['cedula']), $this);?>

			 <?php echo smarty_function_link_to(array('name' => 'Ver Datos Icfes','controller' => 'icfes','action' => 'reporteIndividual','cedula' => $this->_tpl_vars['cedula']), $this);?>

			 <?php echo smarty_function_link_to(array('name' => 'Consultar Inasistencias','controller' => 'asistencias','action' => 'view','cedula' => $this->_tpl_vars['cedula']), $this);?>

		 <?php endif; ?>   
		 <?php if ($this->_tpl_vars['is_admin_login']): ?>
			<hr/>
			 <?php if ($this->_tpl_vars['persona']['cod_estado'] != @COD_ESTADO_ACTIVO): ?>
				<?php echo smarty_function_link_to(array('name' => "Ver I.E.S.",'controller' => 'egresados','action' => 'view','cedula' => $this->_tpl_vars['cedula']), $this);?>

				<?php echo smarty_function_link_to(array('name' => 'Reactivar','controller' => 'estudiantes','action' => 'reactivate','cedula' => $this->_tpl_vars['cedula']), $this);?>

      <hr/>
      <?php echo smarty_function_link_to(array('name' => 'Cambios de Estado','controller' => 'auditoria','action' => 'view','cambio' => 'estado','cedula' => $this->_tpl_vars['cedula']), $this);?>

      <?php echo smarty_function_link_to(array('name' => 'Cambios de Cedula','controller' => 'auditoria','action' => 'view','cambio' => 'cedula','cedula' => $this->_tpl_vars['cedula']), $this);?>

      <?php echo smarty_function_link_to(array('name' => 'Cambios de Rol','controller' => 'auditoria','action' => 'view','cambio' => 'rol','cedula' => $this->_tpl_vars['cedula']), $this);?>

			 <?php else: ?>
				<?php echo smarty_function_link_to(array('name' => 'Ver Observaciones','controller' => 'observaciones','action' => 'view','cedula' => $this->_tpl_vars['cedula']), $this);?>

        
			<?php if (is_admin_login ( )): ?><a href="#<?php echo $this->_tpl_vars['cedula']; ?>
" id="link-verNotificaciones">Ver Notificaciones</a><?php endif; ?>
        	<!--<?php echo smarty_function_link_to(array('name' => 'Ver Notificaciones','controller' => 'EstudiantesNotificaciones','action' => 'view','cedula' => $this->_tpl_vars['cedula']), $this);?>
-->
         
				<hr/>
				<?php if ($this->_tpl_vars['cod_curso'] != null): ?>
					<a href='#' id='link-cambiarCurso'>Cambiar de Curso</a>
				<?php else: ?>
					<a href='#' id='link-asignarCurso'>Asignar Curso</a>
				<?php endif; ?>
					<a href='#' id='link-delete-estudiante'>Dar de Baja</a>
				
			 <?php endif; ?>
		 <?php endif; ?>
		<?php elseif ($this->_tpl_vars['persona']['cod_tipo_per'] == @COD_TIPO_DOCENTE): ?>
			<?php echo smarty_function_link_to(array('name' => 'Consultar Horario','controller' => 'horarios','action' => 'view','cedula' => $this->_tpl_vars['cedula']), $this);?>

			<?php echo smarty_function_link_to(array('name' => 'Cursos Asignados','controller' => 'docentes','action' => 'cursos','cedula' => $this->_tpl_vars['cedula']), $this);?>

		<?php elseif ($this->_tpl_vars['persona']['cod_tipo_per'] == @COD_TIPO_DIGITA_ICFES): ?>
			<?php echo smarty_function_link_to(array('name' => 'Diligenciar Cuestionarios','controller' => 'i_cuestionarios_estudiantes','action' => 'add','cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>

		<?php endif; ?>
  </div>
  
  
  <div class="wrapper-header-info">
  <h2><?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['apellidos'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
, <?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['nombres'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
  <h3><?php echo smarty_function_info(array('classname' => 'TPersona','func' => 'cedula','args' => $this->_tpl_vars['persona']['cedula']), $this);?>
 de <?php echo smarty_function_info(array('classname' => 'TCiudad','func' => 'nombre','args' => $this->_tpl_vars['persona']['cod_expedida']), $this);?>
</h3>
	<?php $this->assign('nombre_persona', ($this->_tpl_vars['persona']['apellidos']).", ".($this->_tpl_vars['persona']['nombres'])); ?>
	<span class='hidden' id='persona_cedula'><?php echo $this->_tpl_vars['cedula']; ?>
</span>
	<?php if ($this->_tpl_vars['persona']['cod_tipo_per'] == @COD_TIPO_ESTUDIANTE): ?>
		<?php if ($this->_tpl_vars['is_admin_login']): ?>
		<h3>
			<?php if ($this->_tpl_vars['nombre_curso'] == null): ?>
				Sin Curso
			<?php else: ?>
				<?php echo $this->_config[0]['vars']['PNAT']; ?>
 <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['cod_programa'],'controller' => 'estudiantes','cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>

				 - Curso <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['nombre_curso'],'controller' => 'cursos','action' => 'view','cod_curso' => $this->_tpl_vars['cod_curso']), $this);?>

			<?php endif; ?>
		</h3>
		<?php else: ?>
		<h3> Curso <?php echo ((is_array($_tmp=@$this->_tpl_vars['nombre_curso'])) ? $this->_run_mod_handler('default', true, $_tmp, "<em>Sin Curso</em>") : smarty_modifier_default($_tmp, "<em>Sin Curso</em>")); ?>
</h3>
		<?php endif; ?>
	<?php endif; ?>
	</div>
	<!-- Personal Info-->
  <dl class="ui-text-container" id='hv'>
    <div class='hv-section' id='hv-section-id'>
	    <?php if ($this->_tpl_vars['siat_user']->isRoot()): ?>
		  <div class='hv-field'>
			  <dt>C&oacute;d. Interno</dt>
			  <dd><?php echo $this->_tpl_vars['persona']['cod_interno']; ?>
</dd>
		  </div>
		  <?php endif; ?>
      <div class="hv-field">
        <dt>Tipo:</dt>
        <dd><?php echo $this->_tpl_vars['persona']['cod_tipo_per']; ?>
 - <?php echo smarty_function_info(array('classname' => 'TTipoPersona','func' => 'nombre','args' => $this->_tpl_vars['persona']['cod_tipo_per']), $this);?>
</dd>
      </div>
      <?php if ($this->_tpl_vars['persona']['cod_tipo_per'] == @COD_TIPO_ESTUDIANTE): ?>
      <div class="hv-field">
        <dt>C&oacute;digo:</dt>
        <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['cod_estud'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
      </div>
      <div class="hv-field">
        <dt>Fecha Ingreso:</dt>
        <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['fecha_ingreso'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</dd>
      </div>
      <?php endif; ?>
      <div class="hv-field">
        <dt>Estado:</dt>
        <dd id='hv-field-status'>
        	<span id='hv-field-status-text'><?php echo $this->_tpl_vars['persona']['nombre_estado']; ?>
</span>
        	<span id='hv-field-status-icon'></span>
        </dd>
      </div>
      <div class="clear"></div>
    </div>
    <div class='hv-section'>
	    <div class="hv-field">
        <dt>Fecha de Nacimiento</dt>
        <dd><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['persona']['fecha_nacimiento'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")); ?>
</dd>
      </div>
	  	<div class="hv-field">
        <dt>Lugar de Nacimiento</dt>
        <dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['nombre_ciudad_nacimiento'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")); ?>
</dd>
      </div>
      <div class="hv-field thin-field" >
        <dt>Edad:</dt>
        <dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['persona']['edad'])) ? $this->_run_mod_handler('default', true, $_tmp, '-') : smarty_modifier_default($_tmp, '-')); ?>
</dd>
      </div>
      <div class="clear"></div>
	    <div class="hv-field thin-field">
	      <dt>G&eacute;nero:</dt>
	      <dd><?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['genero'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
	    </div>
			<div class="hv-field">
	      <dt>Estado Civil:</dt>
	      <dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['persona']['nombre_estado_civil'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")); ?>
</dd>
	    </div>
	    <div class='hv-field thin-field'>
				<dt title='N&uacute;mero de Hijos'>N&deg; Hijos:</dt>
				<dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['persona']['hijo'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")); ?>
</dd>
			</div>
			<?php if ($this->_tpl_vars['persona']['genero'] == 'F'): ?>
			<div class='hv-field' id='hv-field-embarazo'>
				<dt title='En Embarazo'>En Embarazo:</dt>
				<dd>
					<span id='hv-status-embarazo'><?php if ($this->_tpl_vars['persona']['enEmbarzo']): ?>&#10006;<?php else: ?>&#10008;<?php endif; ?></span>
									</dd>
			</div>
			<?php endif; ?>
	    <div class="clear"></div>
		</div>
    <div class='hv-section'>
		    <div class="hv-field">
		      <dt>Direcci&oacute;n:</dt>
		      <dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['persona']['direccion'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")); ?>
</dd>
		    </div>
		    <div class="hv-field">
		      <dt>Barrio:</dt>
		      <dd><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['persona']['nombre_barrio'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
		    </div>
		    <div class="hv-field">
	        <dt>Ciudad:</dt>
	        <dd><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['persona']['nombre_ciudad'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
	      </div>
	      <div class="hv-field thin-field">
		      <dt>Estrato:</dt>
		      <dd><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['persona']['estrato'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")))) ? $this->_run_mod_handler('string_format', true, $_tmp, "%1d") : smarty_modifier_string_format($_tmp, "%1d")); ?>
</dd>
		    </div>
		    <div class="hv-field thin-field">
		      <dt>Comuna:</dt>
		      <dd><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['persona']['comuna'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")))) ? $this->_run_mod_handler('string_format', true, $_tmp, "%2.0d") : smarty_modifier_string_format($_tmp, "%2.0d")); ?>
</dd>
		    </div>
		    <div class="clear"></div>
			  <div class="hv-field">
			    <dt>Tel&eacute;fono:</dt>
			    <dd><?php echo smarty_function_join(array('sep' => ", ",'parts' => ((is_array($_tmp=($this->_tpl_vars['persona']['telefono']).";".($this->_tpl_vars['persona']['telefono_alt']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'default' => "-"), $this);?>
</dd>
		    </div>
		    <div class="hv-field">
		      <dt>Celular:</dt>
		      <dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['persona']['tel_celular'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")); ?>
</dd>
		    </div>
		    <div class="hv-field">
		      <dt>Correo Electr&oacute;nico:</dt>
		      <dd><?php echo smarty_function_join(array('sep' => ", ",'parts' => ((is_array($_tmp=($this->_tpl_vars['persona']['email'])."; ".($this->_tpl_vars['persona']['email_2']))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)),'default' => "-"), $this);?>
</dd>
		    </div>
		    <div class="clear"></div>
	  </div>
	  <?php if ($this->_tpl_vars['persona']['cod_tipo_per'] == @COD_TIPO_ESTUDIANTE): ?>
    <div class='hv-section'>
			<div class='hv-field'>
				<dt>Colegio</dt>
				<dd><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['persona']['colegio']['nombre'])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</dd>
			</div>
			<div class='hv-field'>
				<dt>Tipo</dt>
				<dd><?php echo $this->_tpl_vars['persona']['colegio']['tipo']; ?>
</dd>
			</div>
			<div class='clear'></div>
    </div>
    <?php endif; ?>
    <div class='hv-section' id='hv-section-exencion'>
			<div class='hv-field'>
				<dt>Etnia</dt>
				<dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['persona']['nombre_etnia'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NINGUNA') : smarty_modifier_default($_tmp, 'NINGUNA')); ?>
</dd>
			</div>
			<div class='hv-field'>
				<dt>Desplazamiento</dt>
				<dd> <?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['persona']['nombre_ciudad_desplazado'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NINGUNO') : smarty_modifier_default($_tmp, 'NINGUNO')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

				<?php if ($this->_tpl_vars['persona']['cod_tipo_per'] == @COD_TIPO_ESTUDIANTE && $this->_tpl_vars['is_admin_login']): ?>
					<a href='#' id='link-editarDesplazamiento' class='edit'> Editar</a>
				<?php endif; ?>
				</dd>
			</div>
			<div class='hv-field'>
				<dt>Discapacidad</dt>
				<dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['persona']['nombre_discapacidad'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NINGUNA') : smarty_modifier_default($_tmp, 'NINGUNA')); ?>
</dd>
			</div>
			<div class='clear'></div>
    </div>
  </dl>

  <div><?php echo smarty_function_include_partial(array('file' => 'edit_passwd.tpl','cedula' => $this->_tpl_vars['cedula']), $this);?>
</div>
  <?php if ($this->_tpl_vars['is_admin_login'] && $this->_tpl_vars['persona']['cod_tipo_per'] == @COD_TIPO_ESTUDIANTE): ?>
	<div>
		<?php echo smarty_function_include_partial(array('file' => 'delete.tpl','cod_interno' => $this->_tpl_vars['persona']['cod_interno'],'causas_bloqueo' => $this->_tpl_vars['causas_bloqueo'],'nombre' => $this->_tpl_vars['nombre_persona']), $this);?>

		<?php echo smarty_function_include_partial(array('file' => 'cambiarCurso.tpl','module' => 'estudiantes','cod_interno' => $this->_tpl_vars['persona']['cod_interno'],'cursos' => $this->_tpl_vars['cursos'],'nombre_persona' => $this->_tpl_vars['nombre_persona'],'cod_curso' => $this->_tpl_vars['cod_curso']), $this);?>

		<?php echo smarty_function_include_partial(array('file' => 'editar_desplazado.tpl','module' => 'estudiantes','cod_interno' => $this->_tpl_vars['persona']['cod_interno'],'ciudades' => $this->_tpl_vars['ciudades'],'cod_ciudad' => $this->_tpl_vars['persona']['cod_ciudad_desplazado'],'nombre_persona' => $this->_tpl_vars['nombre_persona']), $this);?>
			
		
			</div>

  <?php endif; ?>
  
 <?php endif; ?>
</div>