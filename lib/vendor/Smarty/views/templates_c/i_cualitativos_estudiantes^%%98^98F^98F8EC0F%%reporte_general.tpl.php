<?php /* Smarty version 2.6.26, created on 2011-10-14 13:51:39
         compiled from modules/i_cualitativos_estudiantes/templates/reporte_general.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'nombre_programa', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 3, false),array('function', 'math', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 60, false),array('function', 'link_to', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 116, false),array('modifier', 'underscorify', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 14, false),array('modifier', 'escape', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 22, false),array('modifier', 'upper', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 22, false),array('modifier', 'truncate', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 22, false),array('modifier', 'capitalize', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 30, false),array('modifier', 'ucfirst', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 41, false),array('modifier', 'string_format', 'modules/i_cualitativos_estudiantes/templates/reporte_general.tpl', 60, false),)), $this); ?>
<div class="ui-widget decorated">
<h1 class="title-reporteGeneral">Reporte General de Componentes</h1>
<h2><?php echo smarty_function_nombre_programa(array(), $this);?>
 - <?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h2>

<?php if (is_null ( $this->_tpl_vars['reporte'] )): ?>
	<p>Esta prueba no presenta a&uacute;n componentes registrados</p>
<?php else: ?>

<div id="reporteGeneral-cualitativos-main">	
	
		<div class="fg-toolbar center ui-helper-clearfix" id="menu-toggleGrupo">
		<a href="#consolidado" class="fg-button ui-state-default ui-corner-all">Consolidado</a>
		<?php $_from = $this->_tpl_vars['grupos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['toggle_grupos'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['toggle_grupos']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['grupo']):
        $this->_foreach['toggle_grupos']['iteration']++;
?><a href="#<?php echo ((is_array($_tmp=$this->_tpl_vars['grupo'])) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)); ?>
" class="fg-button ui-state-default <?php if (($this->_foreach['toggle_grupos']['iteration'] <= 1)): ?>ui-corner-left <?php elseif (($this->_foreach['toggle_grupos']['iteration'] == $this->_foreach['toggle_grupos']['total'])): ?>ui-corner-right<?php endif; ?>"><?php echo $this->_tpl_vars['grupo']; ?>
</a><?php endforeach; endif; unset($_from); ?>
	</div>
	
	<!-- REPORTE CONSOLIDADO -->
	<div class="outer-i_calificador-reporteGeneral ui-helper-hidden ui-corner-top" id="outer-cualitativos-reporteGeneral-consolidado">
		<h3 class="header-widget ui-state-default ui-corner-top" id='header-cualitativos-reporteGeneral-consolidado'>Consolidado</h3>
		<div class="ui-toolbar fg-toolbar toolbar-irAComponente">
				<?php $_from = $this->_tpl_vars['nombres_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
					<a href="#<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)))) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
" class="fg-button ui-state-default link-irAComponente" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3, "") : smarty_modifier_truncate($_tmp, 3, "")))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</a>
				<?php endforeach; endif; unset($_from); ?>
			</div>
		<div class="wrapper-i_calificador-reporteGeneral" id="wrapper-cualitativos-reporteGeneral-consolidado">
		
			<div class="inner-i_calificador-reporteGeneral">
				<?php $_from = $this->_tpl_vars['nombres_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
				<h4 class="area-<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)))) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
 clickable link-toggleComponente">
					<span><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</span>
					<span class="link-goUp ui-icon right-icon inline-icon ui-icon-arrowthickstop-1-n clickable" title="Subir"></span>
				</h4>
				
				<table class="table dataTable table-toggable non-paginable table-reporteCualitativos">
				<!-- Cabecera de la Tabla-->
				<thead>
					<tr>
						<th>Grupo</th>
						<?php $_from = $this->_tpl_vars['__componentes'][$this->_tpl_vars['componente']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cualitativo']):
?>
							<th>
								<div><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['cualitativo']['nombre_cualitativo'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
								<div class="cantidad-preguntas subtitle-header" title="Cantidad de preguntas por componentes en el área.">
									<div class="valor inline"><?php echo $this->_tpl_vars['cualitativo']['cantidad_preguntas']; ?>
</div> preguntas
								</div>
							</th>
							<th>%</th>
						<?php endforeach; endif; unset($_from); ?>
					</tr>
				</thead>
				<!--Cuerpo de la tabla-->
				<tbody>
				<?php $_from = $this->_tpl_vars['reporte']['consolidado']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cod_grupo'] => $this->_tpl_vars['grupo']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['cod_grupo']; ?>
</td>
					
					<?php $_from = $this->_tpl_vars['__componentes'][$this->_tpl_vars['componente']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cualitativo']):
?>
						<?php $this->assign('nombre_cualitativo', $this->_tpl_vars['cualitativo']['nombre_cualitativo']); ?>
						<?php $this->assign('p', $this->_tpl_vars['grupo'][$this->_tpl_vars['componente']][$this->_tpl_vars['nombre_cualitativo']]); ?>
						<td>
							<span class="cantidad-preguntas-correctas"><?php echo ((is_array($_tmp=$this->_tpl_vars['p']['puntaje'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.0f") : smarty_modifier_string_format($_tmp, "%.0f")); ?>
</span><sub class="tiny">/ <?php echo smarty_function_math(array('equation' => "preguntas*total",'preguntas' => $this->_tpl_vars['p']['preguntas'],'total' => $this->_tpl_vars['p']['cantidad']), $this);?>
</sub>
						</td>
						<td>
							<strong class="porcentaje porcentaje-preguntas-correctas">
								<?php echo smarty_function_math(array('equation' => "buenas*100/(preguntas*total_estudiantes)",'buenas' => $this->_tpl_vars['p']['puntaje'],'preguntas' => $this->_tpl_vars['p']['preguntas'],'total_estudiantes' => $this->_tpl_vars['p']['cantidad'],'format' => "%.2f%%"), $this);?>

							</strong>
						</td>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
				</tbody>
				</table>
			<?php endforeach; endif; unset($_from); ?>
			</div> <!-- FIN inner-competencias-reporteGeneral-consolidado-->
		</div> <!-- FIN wrapper-competencias-reporteGeneral-consolidado -->
	</div>
	
	<!-- Reporte por Grupos -->
	<?php $_from = $this->_tpl_vars['grupos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['grupo']):
?>
	<div class="outer-i_calificador-reporteGeneral ui-helper-hidden ui-corner-top" id="outer-cualitativos-reporteGeneral-<?php echo $this->_tpl_vars['grupo']; ?>
">
				<h3 class="header-widget ui-state-default ui-corner-top" id='header-cualitativos-reporteGeneral-<?php echo ((is_array($_tmp=$this->_tpl_vars['grupo'])) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)); ?>
'>Grupo <?php echo $this->_tpl_vars['grupo']; ?>
</h3>
			<div class="ui-toolbar fg-toolbar toolbar-irAComponente">
				<?php $_from = $this->_tpl_vars['nombres_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
					<a href="#<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)))) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
" class="fg-button ui-state-default link-irAComponente" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 3, "") : smarty_modifier_truncate($_tmp, 3, "")))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</a>
				<?php endforeach; endif; unset($_from); ?>
			</div>
		<div class="wrapper-i_calificador-reporteGeneral wrapper-i_calificadores-reporteGeneral" id='wrapper-cualitativos-reporteGeneral-<?php echo $this->_tpl_vars['grupo']; ?>
'>
					
			<div class="inner-i_calificador-reporteGeneral">
			<?php $_from = $this->_tpl_vars['nombres_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
				<h4 class="area-<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)))) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
">
					<span class="clickable link-toggleComponente"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</span>
					<span class="link-goUp ui-icon right-icon inline-icon ui-icon-arrowthickstop-1-n clickable" title="Subir"></span>
				</h4>
				
				<table class="table dataTable table-toggable non-paginable table-reporteCualitativos">
				<!-- Cabecera de la Tabla-->
				<thead>
					<tr>
						<th>Curso</th>
						<?php $_from = $this->_tpl_vars['__componentes'][$this->_tpl_vars['componente']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cualitativo']):
?>
							<th>
								<div><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['competencia']['nombre_cualitativo'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
								<div class="cantidad-preguntas subtitle-header" title="Cantidad de preguntas por cualitativos en el área.">
									<div class="valor inline"><?php echo $this->_tpl_vars['cualitativo']['cantidad_preguntas']; ?>
</div>	preguntas
								</div>
							</th>
							<th class="important">%</th>
						<?php endforeach; endif; unset($_from); ?>
					</tr>
				</thead>
				<!--Cuerpo de la tabla-->
				<tbody>
				<?php $_from = $this->_tpl_vars['reporte'][$this->_tpl_vars['grupo']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cod_curso'] => $this->_tpl_vars['curso']):
?>
				 <tr>
					<td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=$this->_tpl_vars['curso']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'action' => 'view','cod_curso' => $this->_tpl_vars['cod_curso'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>
</td>
					
					<?php $_from = $this->_tpl_vars['__componentes'][$this->_tpl_vars['componente']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cualitativo']):
?>
						<?php $this->assign('nombre_cualitativo', $this->_tpl_vars['cualitativo']['nombre_cualitativo']); ?>
						<?php $this->assign('p', $this->_tpl_vars['curso']['puntajes'][$this->_tpl_vars['componente']][$this->_tpl_vars['nombre_cualitativo']]); ?>
						<td>
							<span class="cantidad-preguntas-correctas"><?php echo ((is_array($_tmp=$this->_tpl_vars['p']['puntaje'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.0f") : smarty_modifier_string_format($_tmp, "%.0f")); ?>
</span><sub class="tiny">/ <?php echo smarty_function_math(array('equation' => "preguntas*total",'preguntas' => $this->_tpl_vars['p']['preguntas'],'total' => $this->_tpl_vars['p']['cantidad']), $this);?>
</sub>
						</td>
						<td class="strong">
							<strong class="porcentaje porcentaje-preguntas-correctas"><?php echo smarty_function_math(array('equation' => "buenas*100/(preguntas*total_estudiantes)",'buenas' => $this->_tpl_vars['p']['puntaje'],'preguntas' => $this->_tpl_vars['p']['preguntas'],'total_estudiantes' => $this->_tpl_vars['p']['cantidad'],'format' => "%.2f%%"), $this);?>
</strong>
						</td>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
				</tbody>
				</table>
			<?php endforeach; endif; unset($_from); ?>
			</div><!-- FIN inner-competencias-reporteGeneral-->
		</div><!-- FIN wrapper-competencias-reporteGeneral-->
		</div><!-- FIN outer-competencias-reporteGeneral-->
	<?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>
</div>