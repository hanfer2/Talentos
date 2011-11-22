<?php /* Smarty version 2.6.26, created on 2011-11-16 16:10:40
         compiled from modules/personas/templates/delete.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'modules/personas/templates/delete.tpl', 2, false),array('function', 'html_select', 'modules/personas/templates/delete.tpl', 5, false),)), $this); ?>
<div class='ui-form' id='form-delete-estudiante'>
	<h3><?php echo ((is_array($_tmp=$this->_tpl_vars['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
	<div class='ui-field'>
		<label>Motivo: </label>
		<?php echo smarty_function_html_select(array('name' => 'persona[causa_bloqueo]','options' => $this->_tpl_vars['causas_bloqueo'],'selected' => 3), $this);?>

	</div>
	<div class='ui-field'>
		<label>Autorizado por: </label>
    <?php echo smarty_function_html_select(array('name' => "persona[authorized_by]",'options' => $this->_tpl_vars['auth_admins']), $this);?>

	</div>
	<input type='hidden' name='persona[cod_interno]' value='<?php echo $this->_tpl_vars['cod_interno']; ?>
' />
	<div class='ui-button-bar'>
		<button type='button' id='bt-delete-persona'>Dar de Baja</button>
	</div>
</div>