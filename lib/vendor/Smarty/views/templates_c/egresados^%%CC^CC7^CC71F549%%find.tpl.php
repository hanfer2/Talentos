<?php /* Smarty version 2.6.26, created on 2011-07-05 20:38:20
         compiled from ./modules/egresados/templates//find.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'info', './modules/egresados/templates//find.tpl', 6, false),array('function', 'html_select', './modules/egresados/templates//find.tpl', 7, false),array('function', 'link_to', './modules/egresados/templates//find.tpl', 17, false),)), $this); ?>
<div class="decorated ui-widget">
  <h1>Listado de Egresados</h1>
  <div class="ui-form" id="form-listadoEgresados">
    <div class="ui-field" id="select-programa">
      <label> <?php echo $this->_config[0]['vars']['PNAT']; ?>
</label> 
			<?php echo smarty_function_info(array('classname' => 'TPrograma','func' => 'toSQL','assign' => 'programas_sql'), $this);?>

			<?php echo smarty_function_html_select(array('name' => 'cod_programa','options' => $this->_tpl_vars['programas_sql']), $this);?>

    </div>
    <div class="ui-field">
      <label>Tipo: </label>
      <?php echo smarty_function_html_select(array('name' => 'tipo','options' => $this->_tpl_vars['tipos']), $this);?>

    </div>
    <div class="ui-button-bar">
      <button id="bt-listadoEgresados">Consultar</button>
    </div>
    <div class="ui-toolbar">
			<?php echo smarty_function_link_to(array('name' => 'Registrar Nuevo Egresado','controller' => 'egresados','action' => 'add'), $this);?>

    </div>
  </div>
</div>
<div class="ajax-response"></div>