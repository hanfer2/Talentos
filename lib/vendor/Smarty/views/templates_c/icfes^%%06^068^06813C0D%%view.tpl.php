<?php /* Smarty version 2.6.26, created on 2011-09-15 09:04:20
         compiled from modules/icfes/templates/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'nombre_programa', 'modules/icfes/templates/view.tpl', 4, false),array('function', 'info', 'modules/icfes/templates/view.tpl', 14, false),array('function', 'link_to', 'modules/icfes/templates/view.tpl', 27, false),array('function', 'persona_url', 'modules/icfes/templates/view.tpl', 62, false),array('modifier', 'count', 'modules/icfes/templates/view.tpl', 37, false),array('modifier', 'upper', 'modules/icfes/templates/view.tpl', 52, false),array('modifier', 'truncate', 'modules/icfes/templates/view.tpl', 52, false),array('modifier', 'substr', 'modules/icfes/templates/view.tpl', 64, false),array('modifier', 'string_format', 'modules/icfes/templates/view.tpl', 79, false),)), $this); ?>
<div class="ui-widget decorated">
 <?php if (empty ( $this->_tpl_vars['estudiantes'] )): ?>
	 <h1>No se hallaron registros</h1>
	 <p>No se hallaron registros de Icfes para el <?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</p>
 <?php else: ?>
	 <h1>Reporte General Icfes</h1>
	 <h2><?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h2>
	 <h3>
			<?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
 -
			<?php ob_start(); ?>
			<?php if (isset ( $this->_tpl_vars['cod_curso'] )): ?>
			 Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>

			<?php elseif (isset ( $this->_tpl_vars['cod_grupo'] )): ?>
			 Grupo <?php echo smarty_function_info(array('classname' => 'TGrupo','func' => 'nombre','args' => $this->_tpl_vars['cod_grupo']), $this);?>

			<?php endif; ?>
			<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('nombreAgrupacion', ob_get_contents());ob_end_clean(); ?>
			<?php echo $this->_tpl_vars['nombreAgrupacion']; ?>

	 </h3>

		<?php if (! is_xhr ( )): ?>
	 <div class="ui-toolbar">
		<?php $_from = $this->_tpl_vars['pruebas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['prueba'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['prueba']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['prueba']):
        $this->_foreach['prueba']['iteration']++;
?>
			 			 <?php if ($this->_tpl_vars['prueba']['codigo'] != $this->_tpl_vars['cod_prueba']): ?>
								<?php if (isset ( $this->_tpl_vars['cod_curso'] )): ?>
				 <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['prueba']['nombre'],'action' => 'view','cod_prueba' => $this->_tpl_vars['prueba']['codigo'],'cod_curso' => $this->_tpl_vars['cod_curso']), $this);?>

				<?php elseif (isset ( $this->_tpl_vars['cod_grupo'] )): ?>
				 <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['prueba']['nombre'],'action' => 'view','cod_prueba' => $this->_tpl_vars['prueba']['codigo'],'cod_grupo' => $this->_tpl_vars['cod_grupo']), $this);?>

				<?php endif; ?>
								<?php if (! ($this->_foreach['prueba']['iteration'] == $this->_foreach['prueba']['total'])): ?> | <?php endif; ?>
			 <?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>

		 <?php if (isset ( $this->_tpl_vars['cod_curso'] )): ?>
			<?php if (( count($this->_tpl_vars['pruebas']) - 1 ) > 0): ?>	<br/> <?php endif; ?>
			<?php echo smarty_function_link_to(array('name' => 'Reporte Por Niveles','action' => 'reporteComponentes','cod_curso' => $this->_tpl_vars['cod_curso'],'cod_prueba' => $this->_tpl_vars['cod_prueba'],'componentes' => $this->_tpl_vars['param_componentes']), $this);?>

		 <?php endif; ?>
	 </div>
		<?php endif; ?>
	 <table class="table dataTable non-paginable" id="table-reporteIcfes">
		<thead>
		 <tr>
			<th>#</th>
			<th>Doc Id.</th>
			<th>Nombre</th>
			<th>Grupo</th>
			<th>Curso</th>
			<th><abbr title="Servicio Nacional de Pruebas">SNP</abbr></th>
			<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
			<th title='<?php echo $this->_tpl_vars['componente']; ?>
'><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)); ?>
</th>
			<?php endforeach; endif; unset($_from); ?>
			<th>Promedio</th>
		 <tr>
		</thead>
		<tbody>
		 <?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['estudiante'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['estudiante']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['estudiante']):
        $this->_foreach['estudiante']['iteration']++;
?>
		 
		 <tr>
			<td><?php echo $this->_foreach['estudiante']['iteration']; ?>
</td>
			<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td>
			<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['estudiante']['fullname'],'action' => 'view','cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td>
			<td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=$this->_tpl_vars['estudiante']['nombre_grupo'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 1) : substr($_tmp, 0, 1)),'action' => 'view','cod_grupo' => ((is_array($_tmp=$this->_tpl_vars['estudiante']['nombre_grupo'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 1) : substr($_tmp, 0, 1)),'cod_prueba' => $this->_tpl_vars['cod_prueba'],'cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</td>
			<td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=$this->_tpl_vars['estudiante']['nombre_grupo'])) ? $this->_run_mod_handler('substr', true, $_tmp, 2) : substr($_tmp, 2)),'action' => 'view','cod_curso' => $this->_tpl_vars['estudiante']['cod_grupo'],'cod_prueba' => $this->_tpl_vars['cod_prueba'],'cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</td>
			<td><?php echo $this->_tpl_vars['estudiante']['num_registro_icfes']; ?>
</td>
			<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
				<td><?php echo $this->_tpl_vars['estudiante'][$this->_tpl_vars['componente']]; ?>
</td>
			<?php endforeach; endif; unset($_from); ?>
			<td></td>
		 </tr>
		 <?php endforeach; endif; unset($_from); ?>
		</tbody>
		<?php if (isset ( $this->_tpl_vars['cod_grupo'] ) && $this->_tpl_vars['cod_grupo'] != '-'): ?>
		<tfoot>
		 <tr>
			<td colspan="6">PROMEDIOS <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['nombreAgrupacion'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</strong></td>
			<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['promedios'][$this->_tpl_vars['componente']])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</td>
			<?php endforeach; endif; unset($_from); ?>
			<td></td>
		 </tr>
		</tfoot>
		<?php endif; ?>
	 </table>
	 <div class="ui-toolbar">
		<?php echo smarty_function_link_to(array('name' => 'Resumen Reporte Promedios Icfes','action' => 'reporteComponentes','componentes' => $this->_tpl_vars['param_componentes'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>

	 </div>
 <?php endif; ?>
</div>