<?php /* Smarty version 2.6.26, created on 2011-07-05 14:38:00
         compiled from modules/asistencias/templates/view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/asistencias/templates/view.tpl', 2, false),array('function', 'persona_url', 'modules/asistencias/templates/view.tpl', 7, false),array('function', 'link_to', 'modules/asistencias/templates/view.tpl', 9, false),array('modifier', 'escape', 'modules/asistencias/templates/view.tpl', 16, false),array('modifier', 'zeropad', 'modules/asistencias/templates/view.tpl', 28, false),array('modifier', 'array_item', 'modules/asistencias/templates/view.tpl', 30, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cedula'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'persona.form','title' => 'Asistencia Individual'), $this);?>

	<div class='ajax-response' id='ajax-asistenciaIndividual'></div>
<?php else: ?>
<div class='ui-widget decorated'>
	<h1>Listado de Inasistencias</h1>
	<h2><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
 - <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
	<?php if (! empty ( $this->_tpl_vars['curso'] ) && ! is_student_login ( )): ?>
		<h3>Curso <?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['curso']['nombre_grupo'],'action' => 'general','cod_curso' => $this->_tpl_vars['curso']['cod_grupo']), $this);?>
  [<?php echo $this->_tpl_vars['status']; ?>
]</h3>
	<?php endif; ?>
	<?php if (empty ( $this->_tpl_vars['inasistencias'] )): ?>
	<p> En el momento, Este usuario no reporta inasistencias</p>
	<?php else: ?>
	<div class='ui-box' id='wrapper-inasistenciasIndividual'>
		<?php $_from = $this->_tpl_vars['inasistencias']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['inasistencia'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['inasistencia']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['componente'] => $this->_tpl_vars['inasistencia']):
        $this->_foreach['inasistencia']['iteration']++;
?>
			<div class='wrapper-componentes-inasistencias' id='componentes-inasistencias-<?php echo ((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
'>
				<h4 class='ui-state-default'><?php echo ((is_array($_tmp=$this->_tpl_vars['componente'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h4>
				<table class='table table-inasistencias-individual'>
				<thead >
					<tr>
						<th class='column-idx'>#</th>
						<th>D&iacute;a</th><th>Motivo</th><th>V&aacute;lida</th>
					</tr>
				</thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['inasistencia']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['inasistencia_componente'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['inasistencia_componente']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['clase']):
        $this->_foreach['inasistencia_componente']['iteration']++;
?>
					<tr>
						<td><?php echo ((is_array($_tmp=$this->_foreach['inasistencia_componente']['iteration'])) ? $this->_run_mod_handler('zeropad', true, $_tmp, 2) : zeropad($_tmp, 2)); ?>
</td>
						<td><span class='date'><?php echo $this->_tpl_vars['clase']['fecha']; ?>
</span></td>
						<?php $this->assign('motivo', array_item($this->_tpl_vars['motivos'], $this->_tpl_vars['clase']['cod_motivo'], 0)); ?>
						<td><?php echo ((is_array($_tmp=$this->_tpl_vars['motivo']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </td>
						<td>
							<?php if ($this->_tpl_vars['motivo']['valida'] == 't'): ?>
								<span class='claseConInasistencia asistencia-justificada'>&#10004;</span>
							<?php else: ?>
								<span class='claseConInasistencia	 asistencia-injustificada'>&#10008;</span>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
				</tbody>
				<tfoot>
					<tr><th></th><th></th><th></th><th></th></tr>
				</tfoot>
				</table>
			</div>
			<?php if ($this->_foreach['inasistencia']['iteration'] % 3 == 0): ?><div class="clear"></div>	<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<div class="clear"></div>
		<div class='wrapper-componentes-inasistencias' id='wrapper-resumen-inasistencias-individual'>
			<h4 class='ui-state-default'>Resumen</h4>
			<table id='table-resumen-inasistencias-individual' class='table table-inasistencias-individual'>
				<thead>
					<tr><th >Inasistencias</th><th>Cantidad</th></tr>
					</thead>
					<tbody>
						<tr>
							<td>(<abbr title="No Justificadas" >-J</abbr>) No Justificadas</td>
							<td id='total-asistenciasIndividualInjustificadas'></td>
						</tr>
						<tr>
							<td>(<abbr title="Justificadas">+J</abbr>) Justificadas</td>
							<td id='total-asistenciasIndividualJustificadas'></td>
						</tr>
					</tbody>
					<tfoot>
					<tr><th colspan="3">TOTALES</th></tr>
					<tr><td>Total de Clases Reportadas</td><td id="total-clasesReportadas"><?php echo $this->_tpl_vars['nClasesReportadas']; ?>
</td></tr>
					<tr><td>Total de Inasistencias</td><td id='total-inasistencias'><?php echo $this->_tpl_vars['nClasesInasistencias']; ?>
</td></tr>
					</tfoot>
			</table>
		</div>
	</div>
	<?php endif; ?>
</div>
<?php endif; ?>