<?php /* Smarty version 2.6.26, created on 2011-11-02 14:25:28
         compiled from modules/i_cuestionarios/templates/informe.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/i_cuestionarios/templates/informe.tpl', 2, false),array('modifier', 'escape', 'modules/i_cuestionarios/templates/informe.tpl', 13, false),array('modifier', 'capitalize', 'modules/i_cuestionarios/templates/informe.tpl', 13, false),array('modifier', 'default', 'modules/i_cuestionarios/templates/informe.tpl', 17, false),array('modifier', 'date_format', 'modules/i_cuestionarios/templates/informe.tpl', 45, false),)), $this); ?>
<?php if (is_blank ( $this->_tpl_vars['cod_prueba'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'simulacros_con_cuestionario','title' => 'Reporte de Cuestionarios'), $this);?>

	<div class='ajax-response'></div>
<?php else: ?>
	<div class="ui-widget decorated">
		<h1>Reporte de Cuestionarios</h1>
		<h2><?php echo $this->_tpl_vars['nombre_prueba']; ?>
 <?php echo $this->_tpl_vars['nombre_programa']; ?>
</h2>
		<div id="wrapper-reporteCuestionario">
			<div id="wrapper-cuestionario-competencias" class="item-reporte item-reporteCuestionario">
				<h3>Competencias</h3>
				<ul id="list-cuestionario-competencias" class="list-reporte-cuestionario">
					<?php $_from = $this->_tpl_vars['rComponentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nombre_componente'] => $this->_tpl_vars['c']):
?>
						<li class="item-componentes-detalles"><div class="nombre-componente h-3 ui-state-default"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['nombre_componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</div>
							<ol>
							<?php $_from = $this->_tpl_vars['c']['competencias']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nombre_competencia'] => $this->_tpl_vars['cantidad_preguntas']):
?>
								<li class="item-competencias">
									<span class="nombre-competencia label-item"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['nombre_competencia'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NINGUNA') : smarty_modifier_default($_tmp, 'NINGUNA')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
:</span> 
									<span class="cantidad-preguntas value-item"><?php echo $this->_tpl_vars['cantidad_preguntas']; ?>
</span>
								</li>
							<?php endforeach; endif; unset($_from); ?>
							</ol>
						</li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
			</div>
			<div id="wrapper-cuestionario-cualitativos" class="item-reporte item-reporteCuestionario">
				<h3>Componentes Cualitativos</h3>
				<ul id="list-cuestionario-cualitativos" class="list-reporte-cuestionario">
					<?php $_from = $this->_tpl_vars['rComponentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nombre_componente'] => $this->_tpl_vars['c']):
?>
						<li class="item-componentes-detalles"><div class="nombre-componente h-3 ui-state-default"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['nombre_componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</div>
							<ol>
							<?php $_from = $this->_tpl_vars['c']['cualitativos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nombre_cualitativo'] => $this->_tpl_vars['cantidad_preguntas']):
?>
								<li class="item-cualitativo">
									<span class="nombre-cualitativo label-item"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['nombre_cualitativo'])) ? $this->_run_mod_handler('default', true, $_tmp, 'NINGUNA') : smarty_modifier_default($_tmp, 'NINGUNA')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
:</span> 
									<span class="cantidad-preguntas value-item"><?php echo $this->_tpl_vars['cantidad_preguntas']; ?>
</span>
								</li>
							<?php endforeach; endif; unset($_from); ?>
							</ol>
						</li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<div class="date date-report">Realizado: <?php echo ((is_array($_tmp=((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp, @TIMESTAMP_FORMAT) : smarty_modifier_date_format($_tmp, @TIMESTAMP_FORMAT)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
	</div>
<?php endif; ?>