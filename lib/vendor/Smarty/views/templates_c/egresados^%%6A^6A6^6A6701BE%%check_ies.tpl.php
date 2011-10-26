<?php /* Smarty version 2.6.26, created on 2011-07-27 20:51:12
         compiled from modules/egresados/templates/check_ies.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'persona_url', 'modules/egresados/templates/check_ies.tpl', 4, false),array('function', 'link_to', 'modules/egresados/templates/check_ies.tpl', 9, false),array('function', 'include_partial', 'modules/egresados/templates/check_ies.tpl', 11, false),array('function', 'include_template', 'modules/egresados/templates/check_ies.tpl', 15, false),)), $this); ?>
<div class="ui-widget decorated">
<?php if ($this->_tpl_vars['exists']): ?>
	<h1>Registrar Egresado con Ingreso a Educaci&oacute;n Superior</h1>
	<h2><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
 - <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
	<?php if ($this->_tpl_vars['estaInactivo']): ?>
		<p class="error-message msg-s3_5"><span class="ui-icon left-icon ui-error-icon ui-icon-alert"></span>Este estudiante se encuentra inactivo</p>
	<?php elseif ($this->_tpl_vars['estaReportado']): ?>
	<p>Este estudiante ya tiene registrado su Ingreso a Educaci&oacute;n Superior</p>
	<div><?php echo smarty_function_link_to(array('name' => 'Ver Egresado','action' => 'view','cedula' => $this->_tpl_vars['cedula']), $this);?>
	</div>
	<?php else: ?>
		<?php echo smarty_function_include_partial(array('file' => "add.form.tpl"), $this);?>

	<?php endif; ?>
<?php else: ?>
		<?php echo smarty_function_include_template(array('file' => 'error','message' => "El estudiante identificado con el Doc.Id <strong>".($this->_tpl_vars['cedula'])."</strong>,<br/> no fue hallado en el sistema",'title' => 'Estudiante No Hallado'), $this);?>

<?php endif; ?>
</div>