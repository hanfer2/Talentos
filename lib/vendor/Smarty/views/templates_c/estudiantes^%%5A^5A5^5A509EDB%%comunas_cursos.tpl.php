<?php /* Smarty version 2.6.26, created on 2011-07-05 15:08:38
         compiled from modules/estudiantes/templates/informe/comunas_cursos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'modules/estudiantes/templates/informe/comunas_cursos.tpl', 13, false),)), $this); ?>
<div class="wrapper-informe">
	<h2 class="ui-state-default">Comunas Predominantes por Curso</h2>
	<table class='table dataTable dt-non-paginable table-reporte' id='table-informe-ComunaPredominante' title='Informe de Comunas Predominantes por Curso'>
		<thead>
			<tr>
				<th>Curso</th><th>Comuna</th><th>Cantidad</th>
			</tr>
		</thead>
		<tbody>
			<?php $_from = $this->_tpl_vars['oInforme']->reporte['comunasPredominantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['curso'] => $this->_tpl_vars['comuna']):
?>
				<tr>
					</td>
					<td class="toggle-icon-cell"><a href="#outer-informeDetallado-comunasPredominantes-<?php echo $this->_tpl_vars['curso']; ?>
" class='ui-icon ui-icon-default ui-icon-plusthick toggle-icon left-icon'></a> <?php echo ((is_array($_tmp=@$this->_tpl_vars['curso'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Sin Comuna') : smarty_modifier_default($_tmp, 'Sin Comuna')); ?>
</td><td><?php echo $this->_tpl_vars['comuna'][0]['comuna']; ?>
</td><td><?php echo $this->_tpl_vars['comuna'][0]['cantidad']; ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>

	<div id='wrapper-informeDetallado-comunasPredominantes' class="ui-helper-hidden">
		<?php $_from = $this->_tpl_vars['oInforme']->reporte['comunasPredominantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['curso'] => $this->_tpl_vars['comunas']):
?>
			<div class='informeDetallado-comunasPredominantes' id='outer-informeDetallado-comunasPredominantes-<?php echo $this->_tpl_vars['curso']; ?>
'>
			<h2 class="ui-state-default">Curso <?php echo $this->_tpl_vars['curso']; ?>
</h2>
			<table id='table-informeDetallado-comunasPredominantes-<?php echo $this->_tpl_vars['curso']; ?>
' class='table dataTable dt-non-paginable table-comunasPorCurso'>
				<thead><tr><th>Comuna</th><th>Cantidad</th></tr></thead>
				<tbody>
					<?php $_from = $this->_tpl_vars['comunas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['comuna']):
?>
						<tr>
							<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['comuna']['comuna'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Sin Comuna') : smarty_modifier_default($_tmp, 'Sin Comuna')); ?>
</td><td><?php echo $this->_tpl_vars['comuna']['cantidad']; ?>
</td>
						</tr>
					<?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
			</div>
		<?php endforeach; endif; unset($_from); ?>
	 </div>
</div>
<div class="wrapper-chart">
	<h2 class="ui-state-default">Gr&aacute;ficas</h2>
	<div id="chart-container-comunasPredominantes"></div>
</div>
<div class="clear"></div>