<?php /* Smarty version 2.6.26, created on 2011-08-23 10:53:00
         compiled from ./modules/programas/templates//configurar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'nombre_programa', './modules/programas/templates//configurar.tpl', 3, false),array('function', 'include_partial', './modules/programas/templates//configurar.tpl', 9, false),array('function', 'link_to', './modules/programas/templates//configurar.tpl', 18, false),)), $this); ?>
<div class="ui-widget decorated">
  <h1>Proceso de Matr&iacute;cula</h1>
  <h2><?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['oConfig']->cod_programa), $this);?>
</h2>

  <div class="accdn ui-corner-all frm-5">  
  <?php if (! $this->_tpl_vars['tiene_cursos']): ?>
    <div class="accdn-item ui-corner-all">
      <h3 class="ui-state-default ui-corner-top"><span class="counter">1.</span> Distribución de Cursos</h3>
      <?php echo smarty_function_include_partial(array('file' => 'configura/distribucion.form.tpl','oConfig' => $this->_tpl_vars['oConfig']), $this);?>

    </div>
  <?php else: ?>
    <div class="accdn-item ui-corner-all">
      <h3 class="ui-state-default ui-corner-top"><span class="counter">1.</span> Distribución de Cursos</h3>  
      <div class="ui-state-highlight notif-block ui-corner-all frm-4">
        <span class="ui-icon ui-icon-alert inline-icon"></span> Este programa ya tiene sus cursos creados.<br/>
      </div>
      <div class="ui-toolbar">
      <?php echo smarty_function_link_to(array('name' => 'Ver Listado de Cursos','controller' => 'cursos','action' => 'index','cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
 
      </div>
    </div>
    <div class="accdn-item ui-corner-all">
      <?php echo smarty_function_include_partial(array('file' => 'configura/cargar_participantes.tpl','counter' => 2,'tipo' => 'participantes'), $this);?>

    </div>
    
    <div class="accdn-item ui-corner-all">
      <?php echo smarty_function_include_partial(array('file' => 'configura/cargar_participantes.tpl','counter' => 3,'tipo' => 'colegios'), $this);?>

    </div>
    <div class="accdn-item ui-corner-all">
      <?php echo smarty_function_include_partial(array('file' => 'configura/cargar_participantes.tpl','counter' => 4,'tipo' => 'icfes'), $this);?>

    </div>
    
    <div class="accdn-item ui-corner-all">
      <?php echo smarty_function_include_partial(array('file' => 'configura/asignar_cursos.tpl','counter' => 5), $this);?>

    </div>
    
  <?php endif; ?>
  </div>
</div>