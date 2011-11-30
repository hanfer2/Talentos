<?php /* Smarty version 2.6.26, created on 2011-11-01 15:06:03
         compiled from templates/_shared/programa.form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'camelize', 'templates/_shared/programa.form.tpl', 3, false),array('function', 'info', 'templates/_shared/programa.form.tpl', 6, false),array('function', 'html_select', 'templates/_shared/programa.form.tpl', 7, false),)), $this); ?>
<div class="ui-widget decorated non-printable">
  <h1><?php echo $this->_tpl_vars['title']; ?>
</h1>
  <div class="ui-form" id="form-<?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('camelize', true, $_tmp) : smarty_modifier_camelize($_tmp)); ?>
">
    <div class="ui-field">
      <label><?php echo $this->_config[0]['vars']['PNAT']; ?>
</label>
			<?php echo smarty_function_info(array('classname' => 'TPrograma','func' => 'toSQL','assign' => 'programas_sql'), $this);?>

			<?php echo smarty_function_html_select(array('name' => 'cod_programa','options' => $this->_tpl_vars['programas_sql'],'extra' => $this->_tpl_vars['extra']), $this);?>

    </div>
    <?php echo $this->_tpl_vars['moreFields']; ?>

    <div class="ui-button-bar">
      <button id="bt-<?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('camelize', true, $_tmp) : smarty_modifier_camelize($_tmp)); ?>
">Consultar</button>
    </div>
  </div>
  <?php if (! empty ( $this->_tpl_vars['links'] )): ?><?php echo $this->_tpl_vars['links']; ?>
<?php endif; ?>
</div>