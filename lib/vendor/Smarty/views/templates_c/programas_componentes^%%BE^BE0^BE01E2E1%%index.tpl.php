<?php /* Smarty version 2.6.26, created on 2011-07-14 09:43:03
         compiled from modules/programas_componentes/templates/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_partial', 'modules/programas_componentes/templates/index.tpl', 11, false),)), $this); ?>
<div class="wrapper-programas-componentes" id="wrapper-programas-componentes-<?php echo $this->_tpl_vars['semestre']; ?>
">
	<h4 class="ui-state-default">COMPONENTES 
		<?php if ($this->_tpl_vars['siat_user']->isRoot()): ?>
      <?php if ($this->_tpl_vars['isProgramaClosed']): ?>
        <span class="ui-icon ui-icon-locked right-icon"></span>
      <?php else: ?>
        <span class="ui-icon ui-icon-wrench right-icon clickable edit-icon" title="Editar"></span>
      <?php endif; ?>
		<?php endif; ?>
	</h4>
	<?php echo smarty_function_include_partial(array('file' => "_list.tpl",'componentes' => $this->_tpl_vars['componentes']), $this);?>

	
	<?php if ($this->_tpl_vars['siat_user']->isRoot()): ?>
	<div class="dialog-componentes-edit"></div>
	<?php endif; ?>
	
</div>