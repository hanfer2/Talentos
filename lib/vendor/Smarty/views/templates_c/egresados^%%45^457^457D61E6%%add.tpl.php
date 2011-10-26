<?php /* Smarty version 2.6.26, created on 2011-07-27 20:43:16
         compiled from modules/egresados/templates/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', 'modules/egresados/templates/add.tpl', 12, false),array('function', 'include_partial', 'modules/egresados/templates/add.tpl', 51, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cedula'] )): ?>

<div id="tabs-registrarEgresados">
  <ul>
    <li><a href="#tab-IES">Ingreso Educaci&oacute;n Superior</a></li>
    <li><a href="#tab-trabajador">Reportar como Trabajador</a></li>
  </ul>
  
  <?php ob_start(); ?>
   <div class="ui-toolbar">
		<a href="#" class="link-buscarPorApellido">Buscar por Apellido</a><br/><br/>
		<?php echo smarty_function_link_to(array('name' => 'Listado de Egresados'), $this);?>

  </div>
	<?php $this->_smarty_vars['capture']['toolbar'] = ob_get_contents(); ob_end_clean(); ?>
	
  <div class="ui-widget decorated" id="tab-IES">
    <h1>Registro de Egresados<br/>con Ingreso a Educaci&oacute;n Superior</h1>
    <div class="ui-form">
      <div class="ui-field">
        <label>Doc. Id </label>
        <input id="cedula-IES" name="cedula" size="15" class="numeric" value="<?php echo $_GET['cedula']; ?>
"/>
      </div>
      <div class="ui-button-bar">
        <button id="bt-seleccionarEstudiante-ies">Aceptar</button>
      </div>
    </div>
    <?php echo $this->_smarty_vars['capture']['toolbar']; ?>

    <div class="ajax-response" id="ajax-egresado-ies"></div>
  </div>

  <div class="ui-widget decorated" id="tab-trabajador">
    <h1>Registro de Egresados<br/>Como Trabajador</h1>
    <div class="ui-form">
      <div class="ui-field">
        <label>Doc. Id </label>
        <input id="cedula-trab" name="cedula" size="15" class="numeric" value="<?php echo $_GET['cedula']; ?>
"/>
      </div>
      <div class="ui-button-bar">
        <button id="bt-seleccionarEstudiante-lab">Aceptar</button>
      </div>
    </div>
    <?php echo $this->_smarty_vars['capture']['toolbar']; ?>

    <div class="ajax-response" id="ajax-egresado-lab"></div>
  </div>
  <div  class='ui-form' id='form-buscarPorApellido'>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => '../personas/buscarPorApellido.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>
</div>

<?php else: ?>
	<?php echo smarty_function_include_partial(array('file' => "check_ies.tpl"), $this);?>

<?php endif; ?>
