<?php /* Smarty version 2.6.26, created on 2011-07-06 16:55:36
         compiled from templates/_shared/simulacros_con_cuestionario.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'camelize', 'templates/_shared/simulacros_con_cuestionario.tpl', 3, false),array('function', 'info', 'templates/_shared/simulacros_con_cuestionario.tpl', 9, false),array('function', 'html_select', 'templates/_shared/simulacros_con_cuestionario.tpl', 10, false),)), $this); ?>
<div class="ui-widget decorated non-printable ">
  <h1><?php echo $this->_tpl_vars['title']; ?>
</h1>
  <div class="ui-form form-simulacrosConCuestionario" id="form-<?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('camelize', true, $_tmp) : smarty_modifier_camelize($_tmp)); ?>
">
		<p class="explanation-text">
				Seleccione la prueba cuyo cuestionario desea consultar.
		</p>
    <div class="ui-field">
      <label><?php echo $this->_config[0]['vars']['PNAT']; ?>
</label>
			<?php echo smarty_function_info(array('classname' => 'TPrograma','func' => 'toSQL','assign' => 'programas_sql'), $this);?>

			<?php echo smarty_function_html_select(array('name' => 'cod_programa','options' => $this->_tpl_vars['programas_sql'],'extra' => $this->_tpl_vars['extra']), $this);?>

    </div>
    <div class='ui-field'>
			<label>Simulacro</label>
			<?php echo smarty_function_info(array('classname' => 'ITIpo','func' => 'simulacrosConCuestionario','assign' => 'simulacros_sql'), $this);?>

			<?php echo smarty_function_html_select(array('name' => 'cod_prueba','options' => $this->_tpl_vars['simulacros_sql']), $this);?>

    </div>
    <?php echo $this->_tpl_vars['moreFields']; ?>

    <div class="ui-button-bar">
      <button id="bt-<?php echo ((is_array($_tmp=$this->_tpl_vars['title'])) ? $this->_run_mod_handler('camelize', true, $_tmp) : smarty_modifier_camelize($_tmp)); ?>
">Consultar</button>
    </div>
    <p class="notice-text bottom-notice">
			 <strong class='text-notice-label'>Nota:</strong> Aquí <strong>SÓLO</strong> se listan los Simulacros con Cuestionarios Registrados 
		</p>
  </div>
  
  <?php if (! empty ( $this->_tpl_vars['links'] )): ?> $links<?php endif; ?>
</div>