<?php /* Smarty version 2.6.26, created on 2011-11-29 15:01:56
         compiled from modules/icfes/templates/reporteResumenPorGrupos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'nombre_programa', 'modules/icfes/templates/reporteResumenPorGrupos.tpl', 6, false),array('function', 'link_to', 'modules/icfes/templates/reporteResumenPorGrupos.tpl', 34, false),array('modifier', 'upper', 'modules/icfes/templates/reporteResumenPorGrupos.tpl', 27, false),array('modifier', 'truncate', 'modules/icfes/templates/reporteResumenPorGrupos.tpl', 27, false),array('modifier', 'escape', 'modules/icfes/templates/reporteResumenPorGrupos.tpl', 27, false),array('modifier', 'zeropad', 'modules/icfes/templates/reporteResumenPorGrupos.tpl', 35, false),array('modifier', 'cat', 'modules/icfes/templates/reporteResumenPorGrupos.tpl', 35, false),array('modifier', 'string_format', 'modules/icfes/templates/reporteResumenPorGrupos.tpl', 38, false),array('modifier', 'default', 'modules/icfes/templates/reporteResumenPorGrupos.tpl', 65, false),)), $this); ?>
<div class="ui-widget decorated">
	<?php if (empty ( $this->_tpl_vars['cursos'] )): ?>
	<h1>No se Hallaron Registros</h1>
  <?php else: ?>
  <h1>Reporte Resumido Promedios Icfes</h1>
  <h2><?php echo smarty_function_nombre_programa(array(), $this);?>
 - <?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h2>
  <div class='ui-toolbar'>
  </div>

  <div class="toolbar fg-toolbar tb-main" id="toolbar-mostrarReporte">
		<a href="#panel-i_promedios-r-consolidado" id="link-promediosPorGrupos" class="fg-button ui-state-default ui-state-active ui-corner-left">CONSOLIDADO</a>
		<a href="#panel-i_promedios-r-cursos" id="link-promediosPorCursos" class="fg-button ui-state-default">CURSOS</a>
		<a href="#panel-i_promedios-r-nEstudiantes" id="link-nEstudiantes" class="fg-button ui-state-default ui-corner-right">N&deg; ESTUDIANTES</a>
    
  </div>
	<div class="accdn" id="accdn-i_promedios-r">
	
		<div class="accdn-item ui-helper-hidden" id="panel-i_promedios-r-cursos">
			<h3 class="ui-state-default">PROMEDIOS POR CURSOS</h3>
			<!-- PROMEDIOS POR CURSOS -->
			 <table class="table dataTable dt-non-paginable" id="table-i_promedios-r-cursos">
				<thead>
					<tr>
						<th class="column-hidden">Grupo</th><th>Curso</th>
						<th title="N&uacute;mero de Estudiantes">N&deg; Estud.</th>
							<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
								<th><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
							<?php endforeach; endif; unset($_from); ?>
					</tr>
				</thead>
				<tbody>
						<?php $_from = $this->_tpl_vars['cursos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['curso']):
?>
					<tr>
						<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['curso']['grupo'],'action' => 'view','cod_prueba' => $this->_tpl_vars['cod_prueba'],'cod_grupo' => $this->_tpl_vars['curso']['grupo'],'cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</td>
						<td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['curso']['subgrupo'])) ? $this->_run_mod_handler('zeropad', true, $_tmp, 2) : zeropad($_tmp, 2)))) ? $this->_run_mod_handler('cat', true, $_tmp, ($this->_tpl_vars['curso']['grupo'])."-", 'TRUE') : smarty_modifier_cat($_tmp, ($this->_tpl_vars['curso']['grupo'])."-", 'TRUE')),'action' => 'view','cod_curso' => $this->_tpl_vars['curso']['cod_grupo'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>
</td>
						<td><?php echo $this->_tpl_vars['curso']['cantidad_estud']; ?>
</td>
						<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['curso'][$this->_tpl_vars['componente']])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</td>
						<?php endforeach; endif; unset($_from); ?>
					</tr>
						<?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
		</div>

		<!-- CANTIDAD DE ESTUDIANTES QUE PRESENTARON LA PRUEBA -->
		<div class="accdn-item ui-helper-hidden" id="panel-i_promedios-r-nEstudiantes">
			<h3 class="ui-state-default">N&deg; DE ESTUDIANTES<br/>QUE PRESENTARON PRUEBA <?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h3>
			<table class="table dataTable dt-non-paginable" id="table-i_promedios-r-nEstudiantes">
				<thead>
					<tr>
						<th class="column-hidden">Grupo</th><th>Curso</th>
							<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
								<th><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
							<?php endforeach; endif; unset($_from); ?>
					</tr>
				</thead>
				<tbody>
					<?php $_from = $this->_tpl_vars['cursos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['curso']):
?>
					<tr>
						<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['curso']['grupo'],'action' => 'view','cod_prueba' => $this->_tpl_vars['cod_prueba'],'cod_grupo' => $this->_tpl_vars['curso']['grupo'],'cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</td>
						<td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['curso']['subgrupo'])) ? $this->_run_mod_handler('zeropad', true, $_tmp, 2) : zeropad($_tmp, 2)))) ? $this->_run_mod_handler('cat', true, $_tmp, ($this->_tpl_vars['curso']['grupo'])."-", 'TRUE') : smarty_modifier_cat($_tmp, ($this->_tpl_vars['curso']['grupo'])."-", 'TRUE')),'action' => 'view','cod_curso' => $this->_tpl_vars['curso']['cod_grupo'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>
</td>
						<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
						<?php $this->assign('ccomponente', "c".($this->_tpl_vars['componente'])); ?>
						<td><?php if ($this->_tpl_vars['curso'][$this->_tpl_vars['ccomponente']] != 0): ?> <?php echo ((is_array($_tmp=@$this->_tpl_vars['curso'][$this->_tpl_vars['ccomponente']])) ? $this->_run_mod_handler('default', true, $_tmp, "-") : smarty_modifier_default($_tmp, "-")); ?>
 <?php else: ?> - <?php endif; ?></td>
						<?php endforeach; endif; unset($_from); ?>
					</tr>
					<?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
		</div>
		
		<!-- PROMEDIOS POR GRUPOS -->
		<div class="accdn-item" id="panel-i_promedios-r-consolidado">
			<h3 class="ui-state-default">PROMEDIOS CONSOLIDADOS</h3>
			<table class="table dataTable dt-non-paginable dt-non-filterable" id="table-i_promedios-r-consolidado">
				<thead>
					<tr>
						<th>Grupo</th>
						<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
							<th><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, 12) : smarty_modifier_truncate($_tmp, 12)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
						<?php endforeach; endif; unset($_from); ?>
					</tr>
				</thead>
				<tbody>
					<?php $_from = $this->_tpl_vars['grupos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['grupo']):
?>
					<tr>
						<td>
							<?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['grupo']['grupo'],'action' => 'view','cod_prueba' => $this->_tpl_vars['cod_prueba'],'cod_grupo' => $this->_tpl_vars['grupo']['grupo'],'cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>

						</td>
						<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
							<td><?php echo ((is_array($_tmp=$this->_tpl_vars['grupo'][$this->_tpl_vars['componente']])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</td>
						 <?php endforeach; endif; unset($_from); ?>
					</tr>
					<?php endforeach; endif; unset($_from); ?>
				</tbody>
				<tfoot>
					<td>PROMEDIO</td>
					<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
							<td><?php echo ((is_array($_tmp=$this->_tpl_vars['promediosTotales'][$this->_tpl_vars['componente']])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</td>
					<?php endforeach; endif; unset($_from); ?>
				</tfoot>
			</table>
      <div class='chart-container' id='chart-i_promedios-resumen-consolidado'>
      </div>
       <?php echo '
      <script type="text/javascript">
        var nombre_programa = \'{$nombre_programa}\';
        var nombre_prueba = \'{$nombre_prueba}\';
      </script>
      '; ?>

		</div>
  </div>
  <?php endif; ?>
</div>