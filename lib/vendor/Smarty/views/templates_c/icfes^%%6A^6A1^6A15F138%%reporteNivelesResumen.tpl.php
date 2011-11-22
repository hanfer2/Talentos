<?php /* Smarty version 2.6.26, created on 2011-11-16 17:25:04
         compiled from modules/icfes/templates/reporteNivelesResumen.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'underscorify', 'modules/icfes/templates/reporteNivelesResumen.tpl', 8, false),array('modifier', 'string_format', 'modules/icfes/templates/reporteNivelesResumen.tpl', 24, false),array('modifier', 'truncate', 'modules/icfes/templates/reporteNivelesResumen.tpl', 41, false),array('modifier', 'escape', 'modules/icfes/templates/reporteNivelesResumen.tpl', 41, false),array('modifier', 'default', 'modules/icfes/templates/reporteNivelesResumen.tpl', 88, false),array('function', 'link_to', 'modules/icfes/templates/reporteNivelesResumen.tpl', 34, false),array('function', 'math', 'modules/icfes/templates/reporteNivelesResumen.tpl', 55, false),array('function', 'nombre_programa', 'modules/icfes/templates/reporteNivelesResumen.tpl', 68, false),)), $this); ?>
<div class='decorated ui-widget' id="panel-iReporteResumenNiveles">
  <h1>Reporte Consolidado por Grupos por Niveles</h1>
  <h2><?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h2>
  
	<!-- NAV TOOLBAR -->
	<div class="fg-toolbar ui-helper-clearfix tb-main" id="tbnav-i_niveles-r">
		<a href="#panel-i_niveles-r-consolidado" class="fg-button ui-state-default ui-state-active ui-corner-all">Consolidado</a>
		<?php $_from = $this->_tpl_vars['grupos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['toggle_grupos'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['toggle_grupos']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['grupo']):
        $this->_foreach['toggle_grupos']['iteration']++;
?><a href="#panel-i_niveles-r-<?php echo ((is_array($_tmp=$this->_tpl_vars['grupo'])) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)); ?>
" class="fg-button ui-state-default <?php if (($this->_foreach['toggle_grupos']['iteration'] <= 1)): ?>ui-corner-left <?php elseif (($this->_foreach['toggle_grupos']['iteration'] == $this->_foreach['toggle_grupos']['total'])): ?>ui-corner-right<?php endif; ?>"><?php echo $this->_tpl_vars['grupo']; ?>
</a><?php endforeach; endif; unset($_from); ?>
		<a href="#panel-i_niveles-r-convenciones" id="link-i_niveles-r-convenciones"><span class="ui-icon ui-icon-tag inline-icon link-icon"></span> Convenciones</a>
  </div>
  
  <!-- CONVENCIONES-->
  <div class="ui-widget-content frm-4 ui-helper-hidden" id="panel-i_niveles-r-convenciones">
		<!-- CONVENCIONES -->
		<h3 class="ui-state-default">CONVENCIONES</h3>
		<table id='table-convenciones' class="convenciones table">
			<thead>
				<tr><th class="ui-state-default">Subnivel</th><th class="ui-state-default">Rango</th></tr>
			</thead>
			<tbody>
				<?php $_from = $this->_tpl_vars['_niveles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['nivel']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['nivel']; ?>
</td>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['rangos'][$this->_tpl_vars['id']][0])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['rangos'][$this->_tpl_vars['id']][1])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
		</table>
  </div>
  
  <!-- I_NIVELES ACCORDEON-->
  <div class="accdn" id="accdn-i_niveles-r">
		<?php $_from = $this->_tpl_vars['grupos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['grupo']):
?>
		<div id="panel-i_niveles-r-<?php echo ((is_array($_tmp=$this->_tpl_vars['grupo'])) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)); ?>
" class="accdn-item">
			<h3 class="ui-state-default ui-corner-all">Promedios Grupo <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['grupo'],'action' => 'view','cod_prueba' => $this->_tpl_vars['cod_prueba'],'cod_programa' => $this->_tpl_vars['cod_programa'],'cod_grupo' => 'grupo'), $this);?>
</h3>
			<table class='table dt-unsortable dt-non-paginable'>
				<thead>
					<tr>
						<th class="column-hidden">Nivel</th>
						<th >Subnivel</th>
						<?php $_from = $this->_tpl_vars['_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
							<th><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4, ".") : smarty_modifier_truncate($_tmp, 4, ".")))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th><th>%</th>
						<?php endforeach; endif; unset($_from); ?>
					</tr>
				</thead>
				<tbody>
					<?php $_from = $this->_tpl_vars['_superniveles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['supernivel'] => $this->_tpl_vars['niveles']):
?>
						 <?php $_from = $this->_tpl_vars['niveles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nivel']):
?>
							<tr>
							<td><?php echo $this->_tpl_vars['supernivel']; ?>
</td>
							<td><?php echo $this->_tpl_vars['nivel']; ?>
</td>
							<?php $_from = $this->_tpl_vars['_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
								<?php $this->assign('cantidad', $this->_tpl_vars['resumen_niveles'][$this->_tpl_vars['grupo']][$this->_tpl_vars['supernivel']][$this->_tpl_vars['nivel']][$this->_tpl_vars['componente']]); ?>
								<?php $this->assign('total', $this->_tpl_vars['clasificador']->cant_estud[$this->_tpl_vars['grupo']][$this->_tpl_vars['componente']]); ?>
								<td><?php echo $this->_tpl_vars['cantidad']; ?>
<hr/><?php echo $this->_tpl_vars['total']; ?>
</td>
								<td class="important"><?php echo smarty_function_math(array('equation' => "x * 100 / y",'x' => $this->_tpl_vars['cantidad'],'y' => $this->_tpl_vars['total'],'format' => "%.2f%%"), $this);?>
</td>
							<?php endforeach; endif; unset($_from); ?>
							
						 <?php endforeach; endif; unset($_from); ?>
						 </tr>
					 <?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
		</div>
		<?php endforeach; endif; unset($_from); ?>
  
		<!-- ----- PROMEDIO GENERAL PNAT ---- -->
		<div id="panel-i_niveles-r-consolidado" class="accdn-item accdn-summary">
			<h3 class="ui-state-default ui-corner-all">Promedios General - <?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</h3>
			
			<table class="table dt-unsortable dt-non-paginable">
				<thead>
					<tr>
						<th class="column-hidden" >Nivel</th>
						<th>Subnivel</th>
						<?php $_from = $this->_tpl_vars['_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
							<th><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 4, ".") : smarty_modifier_truncate($_tmp, 4, ".")))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
							<th>%</th>
						<?php endforeach; endif; unset($_from); ?>
					</tr>
				</thead>
				<tbody>
					<?php $_from = $this->_tpl_vars['_superniveles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['supernivel'] => $this->_tpl_vars['niveles']):
?>
						<?php $_from = $this->_tpl_vars['niveles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nivel']):
?>
						 <tr>
							<td><?php echo $this->_tpl_vars['supernivel']; ?>
</td>				
							<td><?php echo $this->_tpl_vars['nivel']; ?>
</td>
							<?php $_from = $this->_tpl_vars['_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
								<td><?php echo $this->_tpl_vars['clasificador']->totales['resumen'][$this->_tpl_vars['supernivel']][$this->_tpl_vars['nivel']][$this->_tpl_vars['componente']]; ?>
<hr/><?php echo ((is_array($_tmp=@$this->_tpl_vars['clasificador']->totales['cant'][$this->_tpl_vars['componente']])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</td>
								<td class="important"><?php echo smarty_function_math(array('equation' => "x * 100 / y",'format' => "%.2f%%",'x' => $this->_tpl_vars['clasificador']->totales['resumen'][$this->_tpl_vars['supernivel']][$this->_tpl_vars['nivel']][$this->_tpl_vars['componente']],'y' => $this->_tpl_vars['clasificador']->totales['cant'][$this->_tpl_vars['componente']]), $this);?>
</td>
							<?php endforeach; endif; unset($_from); ?>
							</tr>
						 <?php endforeach; endif; unset($_from); ?>
						<?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
		</div>
  </div>
</div>