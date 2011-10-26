<?php /* Smarty version 2.6.26, created on 2011-08-04 15:10:14
         compiled from ./modules/egresados/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'persona_url', './modules/egresados/templates//view.tpl', 4, false),array('function', 'nombre_programa', './modules/egresados/templates//view.tpl', 5, false),array('function', 'link_to', './modules/egresados/templates//view.tpl', 12, false),array('function', 'include_template', './modules/egresados/templates//view.tpl', 47, false),array('modifier', 'default', './modules/egresados/templates//view.tpl', 16, false),array('modifier', 'date_format', './modules/egresados/templates//view.tpl', 18, false),)), $this); ?>
<div class="ui-widget decorated">
 <h1>Reporte Individual de Egresados</h1>
 <?php if (! empty ( $this->_tpl_vars['egresado'] )): ?>
	  <h2><?php echo smarty_function_persona_url(array(), $this);?>
 - <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
		<h3><?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['egresado']['cod_programa']), $this);?>
</h3>

	  <div class="ui-sectioned-panel">
			 <!--- SITUACION ACADEMICA -->
			 <h5 class="ui-title-section no-border-t clickable">Situaci&oacute;n Acad&eacute;mica</h5>
			 <dl class="ui-text-container" id="container-reporteIES"  >
			 <dt>Universidad:</dt>
			 <dd><?php if (is_blank ( $this->_tpl_vars['egresado']['nombre_universidad'] )): ?>NO DEFINIDA<?php else: ?><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['egresado']['nombre_universidad'],'controller' => 'universidades','action' => 'egresados','cod_universidad' => $this->_tpl_vars['egresado']['cod_universidad']), $this);?>
<?php endif; ?></dd>
			 <dt>Carrera:</dt>
			 <dd><?php if (is_blank ( $this->_tpl_vars['egresado']['nombre_carrera'] )): ?>NO DEFINIDA<?php else: ?><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['egresado']['nombre_carrera'],'controller' => 'universidades','action' => 'egresados','cod_universidad' => $this->_tpl_vars['egresado']['cod_universidad'],'cod_carrera' => $this->_tpl_vars['egresado']['cod_carrera']), $this);?>
<?php endif; ?></dd>
			 <dt>Nro. Semestres:</dt>
			 <dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['egresado']['nSemestres'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NO DEFINIDO') : smarty_modifier_default($_tmp, 'NO DEFINIDO')); ?>
</dd>
			 <dt>Fecha Ingreso</dt>
			 <dd><?php if (is_blank ( $this->_tpl_vars['egresado']['fecha_ingreso_univ'] )): ?>NO DEFINIDA<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['fecha_ingreso_univ'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<?php endif; ?></dd>
			</dl>
			<div class="ui-toolbar">
				<?php if (! is_blank ( $this->_tpl_vars['egresado']['nombre_universidad'] )): ?>
					<a href="#<?php echo $this->_tpl_vars['cedula']; ?>
" id="link-eliminarRegistro-IES"><span class="ui-icon ui-error-icon ui-icon-close inline-icon"></span> Eliminar Registro</a>
				<?php else: ?>
					<span class="ui-icon ui-error-icon ui-icon-plus inline-icon"></span>
					<?php echo smarty_function_link_to(array('name' => "Registrar I.E.S.",'action' => 'add','cedula' => $this->_tpl_vars['cedula']), $this);?>

				<?php endif; ?>
			</div>
			<!--- SITUACION LABORAL -->
			<h5 class="ui-title-section clickable">Situaci&oacute;n Laboral</h5>
			<dl class="ui-text-container" id="container-reporteLaborando" >
			 <dt>Ocupaci&oacute;n:</dt><dd><?php echo ((is_array($_tmp=@$this->_tpl_vars['egresado']['ocupacion'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NO DEFINIDA') : smarty_modifier_default($_tmp, 'NO DEFINIDA')); ?>
</dd>
			</dl>
			<?php if (! is_blank ( $this->_tpl_vars['egresado']['ocupacion'] )): ?>
			 <div class="ui-toolbar">
				<a href="#<?php echo $this->_tpl_vars['cedula']; ?>
" id="link-eliminarTrabajo"><span class="ui-icon ui-error-icon ui-icon-close inline-icon">Eliminar Registro</a>
			 </div>
			<?php endif; ?>
		</div>
 <?php else: ?>
	 <?php ob_start(); ?>
			Al estudiante <strong><?php echo smarty_function_persona_url(array('name' => $this->_tpl_vars['nombre_persona']), $this);?>
</strong><br/>
			aún no se ha reportado su Ingreso a la Educaci&oacute;n Superior <br/>o como Laborando.
			<div class="ui-toolbar">
			<?php echo smarty_function_link_to(array('name' => 'Registrar su Ingreso a Educacion Superior o como Laborando','action' => 'add','cedula' => $this->_tpl_vars['cedula']), $this);?>

			</div>
		<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('error_message', ob_get_contents());ob_end_clean(); ?>
		<?php echo smarty_function_include_template(array('file' => 'error','message' => $this->_tpl_vars['error_message']), $this);?>

	<?php endif; ?>
	<div class="ui-toolbar">
	<?php echo smarty_function_link_to(array('name' => 'Registrar Egresados','action' => 'add'), $this);?>
 |
	<?php echo smarty_function_link_to(array('name' => 'Listado de Egresados'), $this);?>

	</div>
</div>
