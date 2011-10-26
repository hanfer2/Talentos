<?php /* Smarty version 2.6.26, created on 2011-07-05 15:08:38
         compiled from modules/estudiantes/templates/informe/excepciones.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'modules/estudiantes/templates/informe/excepciones.tpl', 32, false),array('modifier', 'escape', 'modules/estudiantes/templates/informe/excepciones.tpl', 41, false),array('modifier', 'pluralize', 'modules/estudiantes/templates/informe/excepciones.tpl', 90, false),array('function', 'persona_url', 'modules/estudiantes/templates/informe/excepciones.tpl', 47, false),array('function', 'math', 'modules/estudiantes/templates/informe/excepciones.tpl', 54, false),)), $this); ?>
			
<h2 class="ui-state-default">Estados de Excepci&oacute;n</h2>
<table class='table dataTable table-reporte dt-non-paginable' id='table-informe-Excepciones' title='Informe de Excepciones'>
	<thead>
		<th class='dt-unorderable-column toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggleAll-icon'></span></th>
		<th>Estado</th><th>Cantidad</th>
	</thead>
	<tbody>
		<tr id='row-informeEtnias'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeEtnias'></span></td>
			<td>en Etnias</td>
			<td><?php echo $this->_tpl_vars['oInforme']->reporte['etnias']['total']; ?>
</td>
		</tr>
		<tr id='row-informeDesplazados'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeDesplazados'></span></td>
			<td>Desplazados</td>
			<td><?php echo $this->_tpl_vars['oInforme']->reporte['desplazados']['total']; ?>
</td>
		</tr>
		<tr id='row-informeDiscapacitados'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeDiscapacitados'></span></td>
			<td>Discapacitados</td>
			<td><?php echo $this->_tpl_vars['oInforme']->reporte['discapacidades']['total']; ?>
</td>
		</tr>
		<tr id='row-informeHijos'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeHijos'></span></td>
			<td>Con Hijos</td>
			<td><?php echo $this->_tpl_vars['oInforme']->reporte['hijos']['total']; ?>
</td>
		</tr>
		<tr id='row-informeEmbarazos'>
			<td class='toggle-icon-cell'><span class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon' id='icon-toggle-informeEmbarazos'></span></td>
			<td>En Embarazo</td>
			<td><?php echo count($this->_tpl_vars['oInforme']->reporte['embarazos']); ?>
</td>
		</tr>
	</tbody>
</table>
			
	<div>
		<!-- ETNIAS -->
		<div class='hidden' id='wrapper-informe-Etnias'>
			<?php $_from = $this->_tpl_vars['oInforme']->reporte['etnias']['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['etnia'] => $this->_tpl_vars['estudiantes']):
?>
			<h3 class="ui-state-default"><?php echo ((is_array($_tmp=$this->_tpl_vars['etnia'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h3>
			<table class='table table-informe-Etnias table-informe-Excepciones'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
					<tr>
						<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td><td><?php echo $this->_tpl_vars['estudiante']['nombre_grupo']; ?>
</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
				</tbody>
				<tfoot>
					<tr>
						<td>Total<br/><?php echo ((is_array($_tmp=$this->_tpl_vars['etnia'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
:</td><td><?php echo count($this->_tpl_vars['estudiantes']); ?>
</td>
						<td><?php echo smarty_function_math(array('equation' => "x*100/y",'x' => count($this->_tpl_vars['estudiantes']),'y' => $this->_tpl_vars['oInforme']->total,'format' => $this->_config[0]['vars']['PERCENT_FORMAT']), $this);?>
</td>
					</tr>
				</tfoot>
			</table>
			<?php endforeach; else: ?>
			<tr><td class='empty-result-message' colspan='3'>No hay estudiantes pertenecientes a etnias registrados</td></tr>
			<?php endif; unset($_from); ?>
		</div>
		
		<!-- DISCAPACITADOS -->
		<div class='hidden' id='wrapper-informe-Discapacitados'>
			<?php $_from = $this->_tpl_vars['oInforme']->reporte['discapacidades']['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['discapacidad'] => $this->_tpl_vars['estudiantes']):
?>
			<h3 class="ui-state-default"><?php echo $this->_tpl_vars['discapacidad']; ?>
</h3>
			<table class='table table-informe-Discapacitados table-informe-Excepciones'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
					<tr>
						<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td><td><?php echo $this->_tpl_vars['estudiante']['fullname']; ?>
</td><td><?php echo $this->_tpl_vars['estudiante']['nombre_grupo']; ?>
</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
				</tbody>
				<tfoot>
					<tr>
						<td>Total<br/><?php echo $this->_tpl_vars['discapacidad']; ?>
:</td><td><?php echo count($this->_tpl_vars['estudiantes']); ?>
</td>
						<td><?php echo smarty_function_math(array('equation' => "x*100/y",'x' => count($this->_tpl_vars['estudiantes']),'y' => $this->_tpl_vars['oInforme']->total,'format' => $this->_config[0]['vars']['PERCENT_FORMAT']), $this);?>
</td>
					</tr>
				</tfoot>
			</table>
			<?php endforeach; else: ?>
			<tr><td class='empty-result-message' colspan='3'>No hay estudiantes reportados con discapacidades</td></tr>
			<?php endif; unset($_from); ?>
		</div>
		<!-- HIJOS -->
		<div class='hidden' id='wrapper-informe-Hijos'>
			<?php $_from = $this->_tpl_vars['oInforme']->reporte['hijos']['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hijos'] => $this->_tpl_vars['estudiantes']):
?>
			<h3 class="ui-state-default">Participantes con <?php echo ((is_array($_tmp=$this->_tpl_vars['hijos'])) ? $this->_run_mod_handler('pluralize', true, $_tmp, 'hijo', 'hijos') : pluralize($_tmp, 'hijo', 'hijos')); ?>
</h3>
			<table class='table table-informe-Hijos table-informe-Excepciones'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
					<tr>
						<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td><td><?php echo $this->_tpl_vars['estudiante']['fullname']; ?>
</td><td><?php echo $this->_tpl_vars['estudiante']['nombre_grupo']; ?>
</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
				</tbody>
				<tfoot>
					<tr>
						<td>Total<br/>Con <?php echo ((is_array($_tmp=$this->_tpl_vars['hijos'])) ? $this->_run_mod_handler('pluralize', true, $_tmp, 'hijo', 'hijos') : pluralize($_tmp, 'hijo', 'hijos')); ?>
:</td><td><?php echo count($this->_tpl_vars['estudiantes']); ?>
</td>
						<td><?php echo smarty_function_math(array('equation' => "x*100/y",'x' => count($this->_tpl_vars['estudiantes']),'y' => $this->_tpl_vars['oInforme']->total,'format' => $this->_config[0]['vars']['PERCENT_FORMAT']), $this);?>
</td>
					</tr>
				</tfoot>
			</table>
			<?php endforeach; else: ?>
			<tr><td class='empty-result-message' colspan='3'>No hay estudiantes pertenecientes a etnias registrados</td></tr>
			<?php endif; unset($_from); ?>
		</div>
		
		<!-- EMBARAZOS -->
		<div class='hidden' id='wrapper-informe-Embarazos'>
			<h3 class="ui-state-default">Participantes en Embarazo</h3>
			<table class='table table-informe-Embarazos'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['oInforme']->reporte['embarazos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
					<tr>
						<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td><td><?php echo $this->_tpl_vars['estudiante']['fullname']; ?>
</td><td><?php echo $this->_tpl_vars['estudiante']['nombre_grupo']; ?>
</td>
					</tr>
				<?php endforeach; else: ?>
					<tr><td colspan='3'>No hay estudiantes reportadas en embarazo</td></tr>
				<?php endif; unset($_from); ?>
				</tbody>
			</table>
		</div>
		<!-- DESPLAZADOS -->
		<div class='hidden' id='wrapper-informe-Desplazados'>
			<?php $_from = $this->_tpl_vars['oInforme']->reporte['desplazados']['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['ciudad'] => $this->_tpl_vars['estudiantes']):
?>
			<h3 class="ui-state-default">Participantes Desplazados<br/>de <?php echo $this->_tpl_vars['ciudad']; ?>
</h3>
			<table class='table table-informe-Desplazados table-informe-Excepciones'>
				<thead><tr><th>Doc. ID</th><th>Nombre</th><th>Curso</th></tr></thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
					<tr>
						<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td><td><?php echo $this->_tpl_vars['estudiante']['fullname']; ?>
</td><td><?php echo $this->_tpl_vars['estudiante']['nombre_grupo']; ?>
</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
				</tbody>
				<tfoot>
					<tr>
						<td>Total <?php echo $this->_tpl_vars['ciudad']; ?>
</td><td><?php echo count($this->_tpl_vars['estudiantes']); ?>
</td>
						<td><?php echo smarty_function_math(array('equation' => "x*100/y",'x' => count($this->_tpl_vars['estudiantes']),'y' => $this->_tpl_vars['oInforme']->total,'format' => $this->_config[0]['vars']['PERCENT_FORMAT']), $this);?>
</td>
					</tr>
				</tfoot>
			</table>
			<?php endforeach; else: ?>
			<tr><td class='empty-result-message' colspan='3'>No hay estudiantes reportados como desplazados</td></tr>
			<?php endif; unset($_from); ?>
		</div>
	</div>

	