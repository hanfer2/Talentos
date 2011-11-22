<?php /* Smarty version 2.6.26, created on 2011-11-21 20:45:51
         compiled from ./modules/horarios/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'persona_url', './modules/horarios/templates//view.tpl', 3, false),array('function', 'link_to', './modules/horarios/templates//view.tpl', 6, false),array('modifier', 'escape', './modules/horarios/templates//view.tpl', 3, false),)), $this); ?>
<div class='ui-widget decorated'>
	<h1>Horario</h1>
	<?php if (isset ( $this->_tpl_vars['cedula'] )): ?><h2><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula'],'id' => 'link-cedula'), $this);?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['nombre_persona'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2><?php endif; ?>
	<?php if (isset ( $this->_tpl_vars['nombre_curso'] )): ?>
		<?php if (is_admin_login ( )): ?>
			<h3> Curso <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['nombre_curso'],'controller' => 'cursos','action' => 'view','cod_curso' => $this->_tpl_vars['cod_curso']), $this);?>
</h3>
		<?php else: ?>
			<h3> Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
</h3>
		<?php endif; ?>
		<span class='hidden' id='sp-cod_curso'><?php echo $this->_tpl_vars['cod_curso']; ?>
</span>
	<?php endif; ?>
	<div class='fullCalendar'></div>
</div>