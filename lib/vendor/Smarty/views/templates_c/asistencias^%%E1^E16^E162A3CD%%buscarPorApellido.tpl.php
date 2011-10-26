<?php /* Smarty version 2.6.26, created on 2011-07-05 14:29:48
         compiled from modules/personas/templates/buscarPorApellido.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'modules/personas/templates/buscarPorApellido.tpl', 21, false),array('modifier', 'default', 'modules/personas/templates/buscarPorApellido.tpl', 25, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['q'] )): ?>
<h2>Buscar Por Apellido</h2>
<div class='ui-field ui-field-inline center'>
	<label>Apellido</label>
	<input name='q' id='q' title='Ingrese parte del Apellido'/>
	<button id='bt-buscarPorApellido'>Buscar</button>
</div>
<div id='ajax-porApellidos'></div>
<?php elseif (is_array ( $this->_tpl_vars['personas'] )): ?>
	<table id='table-listadoPorApellidos' class='table dataTable'>
		<thead>
			<tr>
				<th>Doc. Id</th><th>Apellidos</th><th>Nombres</th>
				<th class='column-select-filter' id='column-tipo_per'>Tipo</th>
				<th class='column-select-filter' id='column-pnat'><?php echo $this->_config[0]['vars']['PNAT']; ?>
</th>
			</tr>
		</thead>
		<tbody>
		<?php $_from = $this->_tpl_vars['personas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['persona']):
?>
			<tr class='row-buscarPorApellido clickable'>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['cedula'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['apellidos'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['nombres'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['tipo_persona'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['persona']['cod_programa'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")); ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>
<?php else: ?>
<div class='ui-widget decorated'>
	<h1>No se hallaron registros</h1>
</div>
<?php endif; ?>