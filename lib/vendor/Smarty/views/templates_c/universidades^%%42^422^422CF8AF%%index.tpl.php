<?php /* Smarty version 2.6.26, created on 2011-08-08 11:54:54
         compiled from ./modules/universidades/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', './modules/universidades/templates//index.tpl', 17, false),array('modifier', 'escape', './modules/universidades/templates//index.tpl', 19, false),)), $this); ?>
<?php if (empty ( $this->_tpl_vars['universidades'] )): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "#EMPTY_RESULTS:FILE#", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
<div class="ui-widget decorated">
  <h1>Listado de Universidades</h1>
  <table class="table dataTable" id="table-listadoUniversidades">
    <thead>
      <tr>
				<th>C&oacute;digo</th>
				<th class='column-select-filter'>Nombre</th>
				<th class='column-select-filter'>Ciudad</th>
			</tr>
    </thead>
    <tbody>
		<?php $_from = $this->_tpl_vars['universidades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['universidad']):
?>
      <tr>
				<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['universidad']['codigo'],'action' => 'carreras','cod_universidad' => $this->_tpl_vars['universidad']['codigo'],'cod_ciudad' => $this->_tpl_vars['universidad']['cod_ciudad']), $this);?>
</td>
				<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['universidad']['nombre'],'action' => 'egresados','cod_universidad' => $this->_tpl_vars['universidad']['codigo']), $this);?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['universidad']['nombre_ciudad'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
      </tr>
     <?php endforeach; endif; unset($_from); ?>
    </tbody>
  </table>
    <div class="ui-toolbar">
		<?php echo smarty_function_link_to(array('name' => 'Registrar Universidad','action' => 'add'), $this);?>
 | 
		<?php echo smarty_function_link_to(array('name' => 'Listado de Egresados','controller' => 'egresados'), $this);?>
 | 
		<?php echo smarty_function_link_to(array('name' => 'Registrar Egresado','controller' => 'egresados','action' => 'add'), $this);?>
  
  </div>
<?php endif; ?>
</div>