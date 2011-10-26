<?php /* Smarty version 2.6.26, created on 2011-07-05 15:08:38
         compiled from modules/estudiantes/templates/informe/generos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'modules/estudiantes/templates/informe/generos.tpl', 8, false),)), $this); ?>
<div class="wrapper-informe">
	<h2 class="ui-state-default">Por G&eacute;neros</h2>
	<table class='table dataTable dt-non-paginable table-reporte' id='table-informe-Generos'  title='Informe por Géneros'>
		<thead><tr><th>G&eacute;neros</th><th>Cantidad</th><th>%</th></tr></thead>
		<tbody>
			<?php $_from = $this->_tpl_vars['oInforme']->reporte['generos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['genero'] => $this->_tpl_vars['cantidad']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['genero']; ?>
</td><td><?php echo $this->_tpl_vars['cantidad']; ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['cantidad']*100/$this->_tpl_vars['oInforme']->total)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f%%") : smarty_modifier_string_format($_tmp, "%.2f%%")); ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>
</div>
<div class="wrapper-chart">
	<h2 class="ui-state-default">Gr&aacute;ficas</h2>
	<div id="chart-container-Generos"></div>
</div>
<div class="clear"></div>