<?php /* Smarty version 2.6.26, created on 2011-09-05 15:29:32
         compiled from ./modules/asistencias/templates//formatos.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', './modules/asistencias/templates//formatos.tpl', 14, false),array('function', 'include_template', './modules/asistencias/templates//formatos.tpl', 42, false),)), $this); ?>
<?php if (isset ( $this->_tpl_vars['cod_curso'] )): ?>
	<div class='non-printable'><a href='#' onclick='print(); return false' class='link-print'>Imprimir</a></div>
	<?php $_from = $this->_tpl_vars['cursos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nombre_cur'] => $this->_tpl_vars['curso']):
?>
	<table border='1' class='table-formatoAsistencia'>
		<thead>
		<tr class='h5'><th class='column-contador' colspan='7'>Grupo <?php echo $this->_tpl_vars['nombre_cur']; ?>
</th></tr>
		<tr><th class='column-contador'>#</th><th>DOC. ID</th><th>APELLIDOS</th><th>NOMBRES</th>
		<th colspan='2'>ASISTI&Oacute;</th><th class='tiny'>CUMPLIMIENTO<br>DE TAREAS</th></tr>
		</thead>
		<tbody>
		<?php $_from = $this->_tpl_vars['curso']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['estudiantes'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['estudiantes']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['estudiante']):
        $this->_foreach['estudiantes']['iteration']++;
?>
			<tr>
				<td class='column-contador'><?php echo $this->_foreach['estudiantes']['iteration']; ?>
</td>
				<td><?php echo $this->_tpl_vars['estudiante']['cedula']; ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['apellidos'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['nombres'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td>SI</td><td>NO</td><td></td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		</tbody>
		<tfoot>
		<tr><td class='column-contador' colspan='3'>Total Estudiantes Grupo <?php echo $this->_tpl_vars['nombre_cur']; ?>
: <?php echo $this->_foreach['estudiantes']['total']; ?>
</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td><td></td></td><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td class='column-contador'colspan='2'>Profesor(a)</td><td>Firma</td><td>Fecha</td><td colspan='2'>Hora</td><td></td></tr>
		<tr><td>&nbsp;</td><td></td></td><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td><td>&nbsp;</td></tr>
		<tr><td class='column-contador'colspan='2'>Monitor(a)</td><td>Firma</td><td>Fecha</td><td colspan='2'>Hora</td><td></td></tr>
		<tr><td>&nbsp;</td><td></td></td><td>&nbsp;</td><td>&nbsp;</td><td colspan='2'>&nbsp;</td><td>&nbsp;</td></tr>
				<tr><td colspan='7'>OBSERVACIONES</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		<tr><td colspan='7'>&nbsp;</td></tr>
		</tfoot>
	</table>
	<?php endforeach; endif; unset($_from); ?>
<?php else: ?>
	<?php echo smarty_function_include_template(array('file' => 'curso.form','title' => 'Formatos de Asistencia','extra' => 'TRUE'), $this);?>

	<div class='ajax-response'></div>
<?php endif; ?>
