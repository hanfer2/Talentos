<?php /* Smarty version 2.6.26, created on 2011-07-05 15:08:38
         compiled from modules/estudiantes/templates/informe/edades.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'modules/estudiantes/templates/informe/edades.tpl', 8, false),)), $this); ?>
<div class="wrapper-informe">
	<h2 class="ui-state-default">Por Edades</h2>
	<table class='table dataTable dt-non-paginable table-reporte' id='table-informe-Edades'  title='Informe por Edades'>
		<thead><tr><th>Edad</th><th>Cantidad</th><th>%</th></tr></thead>
		<tbody>
			<?php $_from = $this->_tpl_vars['oInforme']->reporte['edades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['edad'] => $this->_tpl_vars['cantidad']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['edad']; ?>
</td><td><?php echo $this->_tpl_vars['cantidad']; ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['cantidad']*100/$this->_tpl_vars['oInforme']->total)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f%%") : smarty_modifier_string_format($_tmp, "%.2f%%")); ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</tbody>
		<tfoot  class='non-printable'>
			<tr><td>Menores de Edad</td><td id='td-mayores-edad'><?php echo $this->_tpl_vars['oInforme']->reporte['rangoEdades']['m']; ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['oInforme']->reporte['rangoEdades']['m']*100/$this->_tpl_vars['oInforme']->total)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f%%") : smarty_modifier_string_format($_tmp, "%.2f%%")); ?>
</td></tr>
			<tr><td>Mayores de Edad</td><td id='td-menores-edad'><?php echo $this->_tpl_vars['oInforme']->reporte['rangoEdades']['M']; ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['oInforme']->reporte['rangoEdades']['M']*100/$this->_tpl_vars['oInforme']->total)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f%%") : smarty_modifier_string_format($_tmp, "%.2f%%")); ?>
</td></tr>				
			<tr>
				<td colspan='3'>
					<a href='#' class='showChart' id='link-verGraficaInformeEdadesResumen'>Ver Gr&aacute;fica Resumen</a>						
				</td>
			</tr>
		</tfoot>
	</table>
</div>
<div class="wrapper-chart">
	<h2 class="ui-state-default">Gr&aacute;ficas</h2>
	<div id="chart-container-EdadesResumen"></div>
	<div id="chart-container-Edades"></div>
</div>
<div class="clear"></div>