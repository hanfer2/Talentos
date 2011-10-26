<?php /* Smarty version 2.6.26, created on 2011-09-16 17:19:15
         compiled from ./modules/icfes/templates//reporteIndividual.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/icfes/templates//reporteIndividual.tpl', 2, false),array('function', 'persona_url', './modules/icfes/templates//reporteIndividual.tpl', 11, false),array('function', 'info', './modules/icfes/templates//reporteIndividual.tpl', 37, false),array('function', 'url_for', './modules/icfes/templates//reporteIndividual.tpl', 51, false),array('modifier', 'array_item', './modules/icfes/templates//reporteIndividual.tpl', 18, false),array('modifier', 'escape', './modules/icfes/templates//reporteIndividual.tpl', 20, false),array('modifier', 'date_format', './modules/icfes/templates//reporteIndividual.tpl', 21, false),array('modifier', 'lower', './modules/icfes/templates//reporteIndividual.tpl', 39, false),array('modifier', 'default', './modules/icfes/templates//reporteIndividual.tpl', 40, false),)), $this); ?>
<?php if (is_blank ( $this->_tpl_vars['cedula'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'persona.form','title' => 'Reporte Icfes Individual'), $this);?>

	<div id="ajax-reporteIcfesIndividual" class='ajax-response'></div>
<?php elseif (empty ( $this->_tpl_vars['pruebas'] )): ?>
	<div class="ui-widget decorated">
		<h1>No se Hallo Ningun Registro</h1>
	</div>
<?php else: ?>
	<div class="ui-widget decorated">
		<h1>Reporte Icfes Individual </h1>
		<h2><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
 - <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
		<h3><?php echo $this->_config[0]['vars']['PNAT']; ?>
 <?php echo $this->_tpl_vars['cod_programa']; ?>
 - Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
</h3>
		<table class="table dataTable dt-non-paginable" id="table-icfesIndividual" title='Reporte Icfes Individual'>
			<thead>
				<tr>
					<th>Componente</th>
					<?php $_from = $this->_tpl_vars['pruebas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prueba']):
?>
					<?php $this->assign('info_prueba', array_item($this->_tpl_vars['info_pruebas'], ($this->_tpl_vars['prueba']['tipo']))); ?>
					<th <?php if ($this->_tpl_vars['info_prueba']['visible'] == 'f'): ?> class="err-item-oculto prueba-oculta" <?php endif; ?>>
						<div class='column-title'><?php if ($this->_tpl_vars['info_prueba']['visible'] == 'f'): ?><span class="ui-icon ui-icon-info error-icon inline-icon" title="Prueba Oculta"></span><?php endif; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['info_prueba']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
						<div class="date inline"><?php echo ((is_array($_tmp=$this->_tpl_vars['info_prueba']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
					</th>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
			</thead>
			<tbody>
				<!-- SNP -->
				<tr class='no-chart'>
					<td><abbr title="Servicio Nacional de Pruebas">SNP</abbr></td>
					<?php $_from = $this->_tpl_vars['pruebas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prueba']):
?>
					<td ><?php echo $this->_tpl_vars['prueba']['num_registro_icfes']; ?>
</td>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
				<!-- Componentes por Prueba-->
		 <?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
				<tr>
					<td><?php echo smarty_function_info(array('classname' => 'IComponente','func' => 'nombre','args' => $this->_tpl_vars['componente']), $this);?>
</td>
					<?php $_from = $this->_tpl_vars['pruebas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prueba']):
?>
					<?php $this->assign('low_componente', ((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp))); ?>
					<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['prueba'][$this->_tpl_vars['low_componente']])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")); ?>
</td>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
		 <?php endforeach; endif; unset($_from); ?>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
			<?php $_from = $this->_tpl_vars['pruebas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prueba']):
?>
					<td>
            <?php if (in_array ( $this->_tpl_vars['prueba']['tipo'] , $this->_tpl_vars['simulacros'] )): ?>
						<div><a href="<?php echo smarty_function_url_for(array('controller' => 'i_cuestionarios_estudiantes','action' => 'view','cod_prueba' => $this->_tpl_vars['prueba']['tipo'],'cedula' => $this->_tpl_vars['cedula']), $this);?>
" id="link-icfesRespuestas-<?php echo $this->_tpl_vars['cedula']; ?>
-<?php echo $this->_tpl_vars['prueba']['tipo']; ?>
" target="_blank">Respuestas</a></div>
						<div><a href="<?php echo smarty_function_url_for(array('controller' => 'i_competencias_estudiantes','action' => 'view','cod_prueba' => $this->_tpl_vars['prueba']['tipo'],'cedula' => $this->_tpl_vars['cedula']), $this);?>
" id="link-icfesCompetencias-<?php echo $this->_tpl_vars['cedula']; ?>
-<?php echo $this->_tpl_vars['prueba']['tipo']; ?>
">Competencias</a></div>
            <?php endif; ?>
					</td>
			<?php endforeach; endif; unset($_from); ?>
				</tr>
			</tfoot>
		</table>
	</div>
	<div>
		<?php $_from = $this->_tpl_vars['pruebas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prueba']):
?>
		<div id='wrapper-competencias-<?php echo $this->_tpl_vars['prueba']['tipo']; ?>
'></div>
		<div id='wrapper-respuestas-<?php echo $this->_tpl_vars['prueba']['tipo']; ?>
'></div>
		<?php endforeach; endif; unset($_from); ?>
		<div id='chart-container'></div>
	</div>
<?php endif; ?>