<?php /* Smarty version 2.6.26, created on 2011-07-05 15:08:38
         compiled from modules/estudiantes/templates/informe/colegios.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'modules/estudiantes/templates/informe/colegios.tpl', 13, false),array('modifier', 'default', 'modules/estudiantes/templates/informe/colegios.tpl', 13, false),array('modifier', 'count', 'modules/estudiantes/templates/informe/colegios.tpl', 14, false),array('function', 'math', 'modules/estudiantes/templates/informe/colegios.tpl', 15, false),array('function', 'persona_url', 'modules/estudiantes/templates/informe/colegios.tpl', 32, false),)), $this); ?>
<h2 class="ui-state-default">Por Colegios</h2>
<table class='table dataTable table-reporte' id='table-informe-Colegios' title='Informe por Colegios'>
	<thead>
		<tr>
			<th class='column-unsortable toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggleAll-icon'></span></th>
			<th>Colegios</th><th>Cantidad</th><th>%</th>
		</tr>
	</thead>
	<tbody>
		<?php $_from = $this->_tpl_vars['oInforme']->reporte['colegios']['colegios']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cod_colegio'] => $this->_tpl_vars['colegio']):
?>
			<tr id='row-informe-colegios-<?php echo $this->_tpl_vars['cod_colegio']; ?>
'>
				<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon'></span></td>
				<td><?php echo $this->_tpl_vars['cod_colegio']; ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['colegio']['info']['nombre_colegio'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 (<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['colegio']['info']['tipo_colegio'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NO DEFINIDO') : smarty_modifier_default($_tmp, 'NO DEFINIDO')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
)</td>
				<td><?php echo count($this->_tpl_vars['colegio']['estudiantes']); ?>
</td>
				<td><?php echo smarty_function_math(array('equation' => "cantidad*100/nTotal",'format' => $this->_config[0]['vars']['PERCENT_FORMAT'],'cantidad' => count($this->_tpl_vars['colegio']['estudiantes']),'nTotal' => $this->_tpl_vars['oInforme']->total), $this);?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
	</tbody>
	<tfoot>
		<tr><td></td><td>TOTAL Instituciones Oficiales: </th><td><?php echo $this->_tpl_vars['oInforme']->reporte['colegios']['totales']['OFICIAL']; ?>
</td><td></td></tr>
		<tr><td></td><td>TOTAL Instituciones Privadas: </th><td><?php echo $this->_tpl_vars['oInforme']->reporte['colegios']['totales']['PRIVADO']; ?>
</td><td></td></tr>
	</tfoot>
</table>

<div class='ui-helper-hidden' id='wrapper-informe-EstudiantePorColegios'>
	<?php $_from = $this->_tpl_vars['oInforme']->reporte['colegios']['colegios']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cod_colegio'] => $this->_tpl_vars['colegios']):
?>
	<div id='wrapper-informe-EstudiantesPorColegio-<?php echo $this->_tpl_vars['cod_colegio']; ?>
'>
	<table class='table table-helper-estudiantesPorColegio' >
		<thead><tr><th>Doc. Id</th><th>Nombre</th><th>Curso</th></tr></thead>
		<tbody>
		<?php $_from = $this->_tpl_vars['colegios']['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
			<tr><td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td><td><?php echo $this->_tpl_vars['estudiante']['nombre_grupo']; ?>
</td></tr>
		<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>
	</div>
	<?php endforeach; endif; unset($_from); ?>
</div>