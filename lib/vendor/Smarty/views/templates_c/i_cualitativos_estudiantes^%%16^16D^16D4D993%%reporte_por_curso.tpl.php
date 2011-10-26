<?php /* Smarty version 2.6.26, created on 2011-09-15 09:05:02
         compiled from modules/i_cualitativos_estudiantes/templates/reporte_por_curso.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'modules/i_cualitativos_estudiantes/templates/reporte_por_curso.tpl', 16, false),array('modifier', 'capitalize', 'modules/i_cualitativos_estudiantes/templates/reporte_por_curso.tpl', 16, false),array('modifier', 'ucfirst', 'modules/i_cualitativos_estudiantes/templates/reporte_por_curso.tpl', 24, false),array('modifier', 'string_format', 'modules/i_cualitativos_estudiantes/templates/reporte_por_curso.tpl', 41, false),array('function', 'persona_url', 'modules/i_cualitativos_estudiantes/templates/reporte_por_curso.tpl', 36, false),array('function', 'link_to', 'modules/i_cualitativos_estudiantes/templates/reporte_por_curso.tpl', 37, false),)), $this); ?>
<div class="ui-widget decorated" id="widget-reporte-cualitativos">
<h1>Reporte de Componentes Cualitativos Por Curso</h1>
<h2><?php echo $this->_tpl_vars['nombre_prueba']; ?>
 - Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
</h2>
<?php if (is_null ( $this->_tpl_vars['reporte'] )): ?>
	<p>Este curso para esta prueba no presenta a&uacute;n componentes cualitativos registradas</p>
<?php else: ?>

<div id="wrapper-reporteCualitativosPorCurso">	
		<div class="fg-toolbar center ui-helper-clearfix" id="menu-toggleRespuestasComponentes">
			<a href="#" class="fg-button fg-button-icon-left ui-state-default ui-corner-left" id="link-expandAll"><span class="ui-icon ui-icon-plus"></span>Expandir Todo</a>
			<a href="#" class="fg-button fg-button-icon-right ui-state-default ui-corner-right" id="link-contractAll">Contraer Todo<span class="ui-icon ui-icon-minus"></span></a>
	</div>
	
<?php $_from = $this->_tpl_vars['nombres_componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
	<h3 class="header-widget ui-state-default ui-corner-all clickable"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</h3>
	<table class="table dataTable table-toggable non-paginable table-reporteCalificador table-reporteCualitativos table-reportePorCurso">
	<thead>
		<tr>
			<th>Doc. Id</th>
			<th>Nombre</th>
			<?php $_from = $this->_tpl_vars['__componentes'][$this->_tpl_vars['componente']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cualitativo']):
?>
				<th>
          <div><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['cualitativo']['nombre_cualitativo'])) ? $this->_run_mod_handler('ucfirst', true, $_tmp) : ucfirst($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
          <div class="cantidad-preguntas subtitle-header">
            <div class="valor inline"><?php echo $this->_tpl_vars['cualitativo']['cantidad_preguntas']; ?>
</div>
            preguntas
          </div>
        </th>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
	</thead>
  <tbody>
	<?php $_from = $this->_tpl_vars['reporte']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cedula'] => $this->_tpl_vars['estudiante']):
?>
	<tr>
		<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
</td>
		<td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=$this->_tpl_vars['estudiante']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'action' => 'view','cedula' => $this->_tpl_vars['cedula'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>
</td>
		<?php $_from = $this->_tpl_vars['__componentes'][$this->_tpl_vars['componente']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cualitativo']):
?>
			<?php $this->assign('nombre_cualitativo', $this->_tpl_vars['cualitativo']['nombre_cualitativo']); ?>
			<td>
        <span class="cantidad-preguntas-correctas"><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['puntajes'][$this->_tpl_vars['componente']][$this->_tpl_vars['nombre_cualitativo']])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.0f") : smarty_modifier_string_format($_tmp, "%.0f")); ?>
</span> |
        <strong class="porcentaje porcentaje-preguntas-correctas"></strong>
      </td>
		<?php endforeach; endif; unset($_from); ?>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
  </tbody>
  <tfoot>
    <tr>
			<td colspan="2"><strong class="total">TOTAL</strong></td>
			<?php $_from = $this->_tpl_vars['__componentes'][$this->_tpl_vars['componente']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cualitativo']):
?>
				<td> 
          <div class="cantidad-preguntas-correctas inline total"></div> |
          <strong class="porcentaje porcentaje-preguntas-correctas total"></strong>
        </td>
			<?php endforeach; endif; unset($_from); ?>
		</tr>
  </tfoot>
	</table>
<?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>
</div>