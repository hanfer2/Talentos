<?php /* Smarty version 2.6.26, created on 2011-09-21 17:01:47
         compiled from modules/asistencias/templates/general.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/asistencias/templates/general.tpl', 3, false),array('function', 'link_open_external', 'modules/asistencias/templates/general.tpl', 12, false),array('function', 'nombre_programa', 'modules/asistencias/templates/general.tpl', 14, false),array('function', 'persona_url', 'modules/asistencias/templates/general.tpl', 53, false),array('function', 'link_to', 'modules/asistencias/templates/general.tpl', 54, false),array('function', 'join', 'modules/asistencias/templates/general.tpl', 55, false),array('modifier', 'count', 'modules/asistencias/templates/general.tpl', 16, false),array('modifier', 'escape', 'modules/asistencias/templates/general.tpl', 40, false),array('modifier', 'default', 'modules/asistencias/templates/general.tpl', 60, false),array('modifier', 'date_format', 'modules/asistencias/templates/general.tpl', 73, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_programa'] ) && $this->_tpl_vars['cod_curso'] == null): ?>
	<?php if (! isset ( $this->_tpl_vars['cod_curso'] )): ?>
    <?php echo smarty_function_include_template(array('file' => 'programa.form','title' => 'Listado de Inasistencias Colectivo'), $this);?>

	<?php else: ?>
			<?php echo smarty_function_include_template(array('file' => 'curso.form','title' => 'Listado de Inasistencias Colectivo por Curso'), $this);?>

	<?php endif; ?>
	<div class='ajax-response' id='ajax-listadoDeInasistenciasColectivo'></div>
<?php elseif (empty ( $this->_tpl_vars['inasistencias'] )): ?>
	<p>No hay Inasistencias Reportadas</p>
<?php else: ?>
<div class='ui-widget decorated'>
<?php echo smarty_function_link_open_external(array(), $this);?>

<h1>Reporte Global de Inasistencias</h1>
<h2><?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</h2>
<?php if (isset ( $this->_tpl_vars['cod_curso'] )): ?><h3>Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
</h3><?php endif; ?>
<?php $this->assign('cantidadMotivosJustificados', count($this->_tpl_vars['motivos']['t'])); ?>
<?php $this->assign('cantidadMotivosInjustificados', count($this->_tpl_vars['motivos']['f'])); ?>
<div class="ui-toolbar table-toolbar">
	<span class="ui-icon nuvola-ui-icon ui-nuvola-tools"></span>
</div>
<table class='table dataTable non-paginable' id='table-inasistenciasGeneral'>
<thead>
	<tr>
		<th rowspan='3'>Doc. Id</th><th rowspan='3'>Nombres</th><th rowspan='3'>Tel&eacute;fono</th>
		<th rowspan='3'>G&eacute;nero</th><th rowspan='3'>Edad</th>
		<?php if (! isset ( $this->_tpl_vars['cod_curso'] )): ?><th rowspan='3'>Curso</th><?php endif; ?><th  rowspan='3'>Asistencias</th>
		<th colspan='<?php echo $this->_tpl_vars['cantidadMotivosJustificados']+$this->_tpl_vars['cantidadMotivosInjustificados']+3; ?>
'>INASISTENCIAS</th>

	</tr>
	<tr>
		<th colspan='<?php echo $this->_tpl_vars['cantidadMotivosJustificados']+1; ?>
'>JUSTIFICADAS</th>
		<th colspan='<?php echo $this->_tpl_vars['cantidadMotivosInjustificados']+1; ?>
'>INJUSTIFICADAS</th>
		<th class='column-total' title='Total de Inasistencias' rowspan='2'>TOTAL</th>
	</tr>
	<tr>
		<?php $_from = $this->_tpl_vars['motivos']['t']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['motivo']):
?>
		<th><?php echo ((is_array($_tmp=$this->_tpl_vars['motivo']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
		<?php endforeach; endif; unset($_from); ?>
		<th class='column-total' title='Total de Inasistencias Justificadas'>TOTAL</th>
		<?php $_from = $this->_tpl_vars['motivos']['f']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['motivo']):
?>
		<th><?php echo ((is_array($_tmp=$this->_tpl_vars['motivo']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</th>
		<?php endforeach; endif; unset($_from); ?>
		<th class='column-total'>TOTAL</th>
	</tr>
</thead>
<tbody>

	<?php $_from = $this->_tpl_vars['inasistencias']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cedula'] => $this->_tpl_vars['estudiante']):
?>
	<tr>
		<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
</td>
		<td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=$this->_tpl_vars['estudiante']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'action' => 'view','cedula' => $this->_tpl_vars['cedula']), $this);?>
</td>
		<td><?php echo smarty_function_join(array('parts' => ((is_array($_tmp=($this->_tpl_vars['estudiante']['telefono']).";".($this->_tpl_vars['estudiante']['tel_celular']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'sep' => ', '), $this);?>
</td>
		<td><?php echo $this->_tpl_vars['estudiante']['genero']; ?>
</td><td><?php echo $this->_tpl_vars['estudiante']['edad']; ?>
</td>
		<?php if (! isset ( $this->_tpl_vars['cod_curso'] )): ?><td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['estudiante']['nombre_curso'],'action' => 'general','cod_curso' => $this->_tpl_vars['estudiante']['cod_curso']), $this);?>
</td><?php endif; ?>
		<td class='total total-clasesAsistidas'><?php echo $this->_tpl_vars['clasesAsistidas'][$this->_tpl_vars['cedula']][0]['n_asistencias']; ?>
</td>
		<?php $_from = $this->_tpl_vars['motivos']['t']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['motivo']):
?>
			<td class='asistenciaJustificada'><?php echo ((is_array($_tmp=@$this->_tpl_vars['estudiante']['inasistencias'][$this->_tpl_vars['motivo']['codigo']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
		<?php endforeach; endif; unset($_from); ?>
		<td class='total total-asistenciasJustificadas'></td>
		<?php $_from = $this->_tpl_vars['motivos']['f']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['motivo']):
?>
			<td class='asistenciaInjustificada'><?php echo ((is_array($_tmp=@$this->_tpl_vars['estudiante']['inasistencias'][$this->_tpl_vars['motivo']['codigo']])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</td>
		<?php endforeach; endif; unset($_from); ?>
		<td class='total total-asistenciasInjustificadas'></td>
		<td class='total total-clasesInasistidas'></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</tbody>
</table>

<div class='date-report'>Generado: <span class='date'><?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</span></div>
</div>
<?php endif; ?>