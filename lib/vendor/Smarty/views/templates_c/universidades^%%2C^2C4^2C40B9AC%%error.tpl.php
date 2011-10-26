<?php /* Smarty version 2.6.26, created on 2011-08-08 10:31:26
         compiled from templates/_shared/error.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'templates/_shared/error.tpl', 1, false),)), $this); ?>
<div class="ui-corner-all err-block msg-s<?php echo ((is_array($_tmp=@$this->_tpl_vars['size'])) ? $this->_run_mod_handler('default', true, $_tmp, 8) : smarty_modifier_default($_tmp, 8)); ?>
">
		<h1><span class="ui-icon-alert"></span><?php echo ((is_array($_tmp=@$this->_tpl_vars['title'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Registro No Hallado') : smarty_modifier_default($_tmp, 'Registro No Hallado')); ?>
</h1>
		<div class="error-message msg-s7">
			<div class="err-content-msg ui-corner-all"><?php echo $this->_tpl_vars['message']; ?>
</div>
		</div>
		<?php if (isset ( $this->_tpl_vars['links'] )): ?>
		<div class="ui-toolbar"><?php echo $this->_tpl_vars['links']; ?>
</div>
		<?php endif; ?>
</div>