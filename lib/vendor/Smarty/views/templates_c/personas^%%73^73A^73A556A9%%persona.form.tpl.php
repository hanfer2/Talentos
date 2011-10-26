<?php /* Smarty version 2.6.26, created on 2011-07-05 13:16:10
         compiled from templates/_shared/persona.form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'camelize', 'templates/_shared/persona.form.tpl', 6, false),array('function', 'include_partial', 'templates/_shared/persona.form.tpl', 20, false),)), $this); ?>
<div class='ui-widget decorated non-printable form-buscarPersona'>
	<h1><?php echo $this->_tpl_vars['title']; ?>
</h1>
  <?php if (isset ( $this->_tpl_vars['subtitle'] )): ?>
  <h2><?php echo $this->_tpl_vars['subtitle']; ?>
</h2>
  <?php endif; ?>
	<div class='ui-form form-cedula' id='form-<?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('camelize', true, $_tmp) : smarty_modifier_camelize($_tmp)); ?>
'>
		<div class='ui-field'>
			<label>Doc. Id</label>
			<input name='cedula' id='input-buscarPorCedula' class='numeric required cedula'/>
		</div>
	</div>
	<div class='ui-button-bar'>
		<button id='bt-<?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('camelize', true, $_tmp) : smarty_modifier_camelize($_tmp)); ?>
' class='button-search'>Aceptar</button>
	</div>
	<div class='ui-toolbar'>
		<a href='#' class='link-buscarPorApellido'>Buscar por Apellido</a><br/>
		<?php echo $this->_tpl_vars['links']; ?>

	</div>
	<div  class='ui-form' id='form-buscarPorApellido'>
		<?php echo smarty_function_include_partial(array('file' => 'buscarPorApellido','module' => 'personas'), $this);?>

	</div>
</div>