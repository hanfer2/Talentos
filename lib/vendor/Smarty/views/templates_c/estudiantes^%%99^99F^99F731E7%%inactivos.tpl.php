<?php /* Smarty version 2.6.26, created on 2011-07-06 16:43:57
         compiled from ./modules/estudiantes/templates//inactivos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/estudiantes/templates//inactivos.tpl', 2, false),array('function', 'nombre_programa', './modules/estudiantes/templates//inactivos.tpl', 7, false),array('function', 'persona_url', './modules/estudiantes/templates//inactivos.tpl', 25, false),array('modifier', 'date_format', './modules/estudiantes/templates//inactivos.tpl', 8, false),array('modifier', 'escape', './modules/estudiantes/templates//inactivos.tpl', 26, false),array('modifier', 'default', './modules/estudiantes/templates//inactivos.tpl', 27, false),)), $this); ?>
<?php if (empty ( $this->_tpl_vars['cod_programa'] )): ?>
	<?php echo smarty_function_include_template(array('file' => "programa.form",'title' => 'Informe de Inactivos'), $this);?>

		<div class='ajax-request'></div>
<?php else: ?>
	<div class='ui-widget decorated'>
		<h1>Informe de Inactivos</h1>
		<h2><?php echo smarty_function_nombre_programa(array(), $this);?>
</h2>
		<h4><?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</h4>
		<?php if (empty ( $this->_tpl_vars['inactivos'] )): ?>
			<p>No se hallaron estudiantes inactivos</p>
		<?php else: ?>
			<table id='table-listadoEstudiantesInactivos' class='table dataTable'>
			<thead>
				<tr>
					<th>Doc. Id</th><th>Nombres</th>
					<th class='column-select-filter'>Curso</th>
					<th class='column-select-filter'>Causa de Bloqueo</th>
					<th class='column-select-filter'>Registrado Por</th>
					<th>Fecha</th><th class='column-select-filter'>Autorizado Por</th>
				</tr>
			</thead>
			<tbody>
			<?php $_from = $this->_tpl_vars['inactivos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['inactivo']):
?>
				<tr>
					<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['inactivo']['cedula']), $this);?>
</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['inactivo']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td><td><?php echo $this->_tpl_vars['inactivo']['nombre_grupo']; ?>
</td>
					<td><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['inactivo']['nombre_motivo'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NO DEFINIDO') : smarty_modifier_default($_tmp, 'NO DEFINIDO')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
					<td><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['inactivo']['nombre_actualizado_por'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NO DEFINIDO') : smarty_modifier_default($_tmp, 'NO DEFINIDO')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
					<td class='date'><?php echo ((is_array($_tmp=$this->_tpl_vars['inactivo']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
					<td><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['inactivo']['autorizado_por'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NO DEFINIDO') : smarty_modifier_default($_tmp, 'NO DEFINIDO')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</tbody>
			</table>
		<?php endif; ?>
		<div class='date date-report'>
			realizado: <?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT']) : smarty_modifier_date_format($_tmp, $this->_config[0]['vars']['TIMESTAMP_FORMAT'])); ?>

		</div>
	</div>
<?php endif; ?>