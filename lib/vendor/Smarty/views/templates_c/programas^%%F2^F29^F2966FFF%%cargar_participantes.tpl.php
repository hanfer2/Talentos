<?php /* Smarty version 2.6.26, created on 2011-08-23 10:53:00
         compiled from modules/programas/templates/configura/cargar_participantes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'ucwords', 'modules/programas/templates/configura/cargar_participantes.tpl', 1, false),array('function', 'url_for', 'modules/programas/templates/configura/cargar_participantes.tpl', 2, false),)), $this); ?>
<h3 class="ui-state-default ui-corner-top"><span class="counter"><?php echo $this->_tpl_vars['counter']; ?>
.</span> Cargar <?php echo ((is_array($_tmp=$this->_tpl_vars['tipo'])) ? $this->_run_mod_handler('ucwords', true, $_tmp) : ucwords($_tmp)); ?>
</h3>
<form action="<?php echo smarty_function_url_for(array('action' => 'cargar_participantes'), $this);?>
" method="post" enctype="multipart/form-data" class="frm-3">
  <label>Listado de Participantes:</label><input name="participante" type="file"/><br/>
  <input type="hidden" name="tipo" value="<?php echo $this->_tpl_vars['tipo']; ?>
"/>
  <button>Cargar</button>
</form>