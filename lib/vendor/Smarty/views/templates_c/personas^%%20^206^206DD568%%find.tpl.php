<?php /* Smarty version 2.6.26, created on 2011-07-05 13:16:10
         compiled from ./modules/personas/templates//find.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url_for', './modules/personas/templates//find.tpl', 1, false),array('function', 'include_template', './modules/personas/templates//find.tpl', 2, false),)), $this); ?>
<form action='<?php echo smarty_function_url_for(array('action' => 'view'), $this);?>
'>
	<?php echo smarty_function_include_template(array('file' => 'persona.form','title' => 'Buscar Persona'), $this);?>

	<input type='hidden' name='controlador' value='personas' />
	<input type='hidden' name='accion' value='view' />
</form>