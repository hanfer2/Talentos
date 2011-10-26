<?php /* Smarty version 2.6.26, created on 2011-07-06 16:43:41
         compiled from ./modules/componentes/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', './modules/componentes/templates//index.tpl', 17, false),array('function', 'include_partial', './modules/componentes/templates//index.tpl', 31, false),)), $this); ?>
<div class="ui-widget decorated">
	<?php if (empty ( $this->_tpl_vars['componentes'] )): ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_config[0]['vars']['EMPTY_RESULTS_FILE'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php else: ?>
	<h1>Listado de Componentes</h1>
	<table class='table dataTable' id="table-listadoComponentes">
		<thead>
			<tr>
				<th>C&oacute;digo</th><th>Nombre</th>
				<th class='column-select-filter'>Modalidad</th>
			</tr>
		</thead>
		<tbody>
			<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
			<tr>
				<td><?php echo $this->_tpl_vars['componente']['codigo']; ?>
</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['componente']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['componente']['modalidad'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			</tr>
			<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>
	<?php endif; ?>
	<div class='ui-toolbar'>
		<?php if (is_super_admin_login ( )): ?>
		<a href="#" id="link-registrarNuevoComponente">Registrar Nuevo Componente</a>
		<?php endif; ?>
	</div>
	<div class='ui-helper-hidden toggable' id='wrapper-nuevoComponente'>
		<?php if (is_super_admin_login ( )): ?>
		<?php echo smarty_function_include_partial(array('file' => "add.tpl",'module' => 'componentes'), $this);?>

		<?php endif; ?>
	</div>
</div>