<?php /* Smarty version 2.6.26, created on 2011-08-23 10:53:00
         compiled from modules/programas/templates/configura/asignar_cursos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url_for', 'modules/programas/templates/configura/asignar_cursos.tpl', 2, false),)), $this); ?>
<h3 class="ui-state-default ui-corner-top"><span class="counter"><?php echo $this->_tpl_vars['counter']; ?>
.</span> Asignar Cursos</h3>
<form action="<?php echo smarty_function_url_for(array('action' => 'asignar_cursos'), $this);?>
" method="post" class="frm-3">
  <p><span class="ui-icon ui-icon-info inline-icon"></span> Este proceso asignará a cada participante un curso en el <?php echo $this->_config[0]['vars']['PNAT']; ?>
</p>
  <input  type="hidden" name="cod_programa" value="<?php echo $this->_tpl_vars['cod_programa']; ?>
"/>
  <button>Asignar Cursos</button>
</form>