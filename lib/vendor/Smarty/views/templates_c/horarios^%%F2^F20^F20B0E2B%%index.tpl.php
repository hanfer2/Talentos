<?php /* Smarty version 2.6.26, created on 2011-11-30 14:11:03
         compiled from ./modules/horarios/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/horarios/templates//index.tpl', 2, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_curso'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'cursos_all','title' => 'Horarios Por Cursos'), $this);?>

	<div class="ajax-response" id='ajax-horarios'></div>
<?php else: ?>
	<div class="ui-widget decorated">
	 <div id="full-calendar" class='full-calendar'></div>
	</div>
<?php endif; ?>
