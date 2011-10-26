<?php /* Smarty version 2.6.26, created on 2011-09-12 11:36:36
         compiled from templates/_shared/no_results.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'templates/_shared/no_results.tpl', 3, false),)), $this); ?>
<p class="empty-result-message">
	<span class="ui-icon ui-icon-error inline-icon ui-icon-alert"></span>
	<?php echo ((is_array($_tmp=@$this->_tpl_vars['message'])) ? $this->_run_mod_handler('default', true, $_tmp, 'No se hallaron resultados') : smarty_modifier_default($_tmp, 'No se hallaron resultados')); ?>

	<span class="clear"></span>
</p>
<?php if (isset ( $this->_tpl_vars['links'] )): ?>
<div class="ui-toolbar">
	<?php echo $this->_tpl_vars['links']; ?>

</div>
<?php endif; ?>