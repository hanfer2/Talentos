<?php /* Smarty version 2.6.26, created on 2011-07-06 16:49:47
         compiled from ./modules/docentes/templates//informe.form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'info', './modules/docentes/templates//informe.form.tpl', 6, false),array('function', 'html_select', './modules/docentes/templates//informe.form.tpl', 7, false),)), $this); ?>
<div class="ui-widget decorated non-printable">
  <h1>Informe de Docentes</h1>
  <div class="ui-form ui-form-inline" id="form-informe">
    <div class="ui-field">
      <label><?php echo $this->_config[0]['vars']['PNAT']; ?>
</label>
			<?php echo smarty_function_info(array('classname' => 'TPrograma','func' => 'toSQL','assign' => 'programas_sql'), $this);?>

      <?php echo smarty_function_html_select(array('name' => 'cod_programa','options' => $this->_tpl_vars['programas_sql']), $this);?>

    </div>
    <div id="div-seleccionaTipoInformeDocentes">
      <div class="ui-field inline">
        <label>Por Componente</label>
				<?php echo smarty_function_info(array('classname' => 'TComponente','func' => 'toSQL','assign' => 'componentes_sql'), $this);?>

				<?php echo smarty_function_html_select(array('name' => 'cod_componente','options' => $this->_tpl_vars['componentes_sql']), $this);?>

      </div>
      <div class="ui-field inline">
        <label>Por Cursos</label>
				<?php echo smarty_function_info(array('classname' => 'TSubgrupo','func' => 'toSQL','assign' => 'subgrupos_sql'), $this);?>

				<?php echo smarty_function_html_select(array('name' => 'cod_curso','options' => $this->_tpl_vars['subgrupos_sql']), $this);?>

      </div>
    </div>
  </div>
  <div id="ajax-docentes-informe"></div>
  
</div>