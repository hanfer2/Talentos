<?php /* Smarty version 2.6.26, created on 2011-08-08 11:54:46
         compiled from ./modules/universidades/templates//add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select', './modules/universidades/templates//add.tpl', 6, false),array('function', 'link_to', './modules/universidades/templates//add.tpl', 21, false),)), $this); ?>
<div class="ui-widget decorated"> 
  <h1>Creaci&oacute;n de Universidades</h1>
  <div class="ui-form" id="form-crearUniviersidad" style="width:9cm">
    <div class="ui-field">
      <label for="universidad_cod_ciudad">Ciudad</label>
      <?php echo smarty_function_html_select(array('name' => "universidad[cod_ciudad]",'options' => $this->_tpl_vars['ciudades'],'selected' => @COD_CIUDAD_CALI), $this);?>

    </div>
    <div class="ui-field">
      <label for="universidad_nombre" class="required">Nombre</label>
      <input name="universidad[nombre]" maxlength=100 size=28/>
    </div>
    <div class="ui-field">
      <label for="nombre">Abreviatura</label>
      <input name="universidad[abreviatura]" maxlength=15 size=28/>
    </div>
    <div class="ui-button-bar">
      <button id="bt-crearUniversidad"> Aceptar</button>
    </div>
  </div>
  <div class="ui-toolbar">
  <?php echo smarty_function_link_to(array('name' => 'Listado de Universidades'), $this);?>
 |
  <?php echo smarty_function_link_to(array('name' => 'Listado de Carreras','controller' => 'Carreras'), $this);?>
 |
  <?php echo smarty_function_link_to(array('name' => 'Listado de Egresados','controller' => 'Egresados'), $this);?>
 |
  <?php echo smarty_function_link_to(array('name' => 'Registrar Egresado','controller' => 'Egresados','action' => 'add'), $this);?>

  </div>
</div>