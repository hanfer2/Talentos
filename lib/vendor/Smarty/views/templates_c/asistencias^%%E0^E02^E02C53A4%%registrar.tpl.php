<?php /* Smarty version 2.6.26, created on 2011-09-07 10:59:20
         compiled from ./modules/asistencias/templates//registrar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/asistencias/templates//registrar.tpl', 3, false),array('function', 'url_for', './modules/asistencias/templates//registrar.tpl', 18, false),array('function', 'persona_url', './modules/asistencias/templates//registrar.tpl', 31, false),array('function', 'html_select', './modules/asistencias/templates//registrar.tpl', 34, false),array('function', 'link_to', './modules/asistencias/templates//registrar.tpl', 49, false),array('modifier', 'date_format', './modules/asistencias/templates//registrar.tpl', 13, false),array('modifier', 'escape', './modules/asistencias/templates//registrar.tpl', 16, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_clase'] )): ?>
  <?php if ($this->_tpl_vars['siat_request']->getParam('t') == 'ce'): ?>
    <?php echo smarty_function_include_template(array('file' => 'curso_especial.form','title' => 'Registrar Asistencia'), $this);?>

  <?php else: ?>
    <?php echo smarty_function_include_template(array('file' => 'cursos_componentes','title' => 'Registrar Asistencia'), $this);?>

  <?php endif; ?>
<div id='wrapper-asistencias-fechas'></div>
<div class='ajax-response' id='ajax-registrarAsistencia'></div>
<?php else: ?>
<div class='ui-widget decorated'>
	<h1>Registrar Asistencia</h1>
	<h2><?php echo $this->_tpl_vars['nombre_componente']; ?>
 - Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
</h2>
	<h3> Fecha de la Clase: <?php echo ((is_array($_tmp=$this->_tpl_vars['clase']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</h3>
	<?php if (! empty ( $this->_tpl_vars['asistencias'] )): ?>
		<h3 id='header-text-asistenciaRegistrada'>YA HA SIDO REGISTRADA</h3>
		&Uacute;ltima actualizaci&oacute;n: <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['clase']['updated_at'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @TIMESTAMP_FORMAT) : smarty_modifier_date_format($_tmp, @TIMESTAMP_FORMAT)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
  (por: <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['clase']['updated_by'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</strong>)
	<?php endif; ?>
	<form action="<?php echo smarty_function_url_for(array('action' => 'save'), $this);?>
" method="post">
		<table id='table-registrarAsistencia' class='table dataTable non-paginable'>
			<thead>
				<tr>
					<th>#</th><th>Doc. Id</th><th>Nombre</th>
					<th class='column-chbx'>Asisti&oacute;</th><th>Justificaci&oacute;n</th>
				</tr>
			</thead>
			<tbody>
				<?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['estudiantes'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['estudiantes']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['estudiante']):
        $this->_foreach['estudiantes']['iteration']++;
?>
				<tr>
					<?php $this->assign('cod_interno_estudiante', $this->_tpl_vars['estudiante']['cod_interno']); ?>
					<td><?php echo $this->_foreach['estudiantes']['iteration']; ?>
</td>
					<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td>
					<td <?php if (in_array ( $this->_tpl_vars['estudiante']['cedula'] , $this->_tpl_vars['estudiantesFlotantes'] )): ?> class="estudiante-flotante" <?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
					<td><input type='checkbox' class='chk-asistencia-asiste' name='asistencia[<?php echo $this->_tpl_vars['estudiante']['cod_interno']; ?>
][asiste]' value='t' <?php if ($this->_tpl_vars['asistencias'][$this->_tpl_vars['cod_interno_estudiante']]['asiste'] != 'f'): ?> checked='checked'<?php endif; ?> /></td>
					<td><?php echo smarty_function_html_select(array('name' => "asistencia[".($this->_tpl_vars['estudiante']['cod_interno'])."][justificacion]",'options' => $this->_tpl_vars['justificaciones'],'selected' => $this->_tpl_vars['asistencias'][$this->_tpl_vars['cod_interno_estudiante']]['cod_motivo'],'disabled' => 'disabled'), $this);?>
</td>
				</tr>
				<?php endforeach; endif; unset($_from); ?>
			</tbody>
		</table>
		<div>
			<label class='textarea-label'>Observaciones:</label>
			<textarea cols="100" rows="5" name='clase[observaciones]'><?php echo $this->_tpl_vars['clase']['observaciones']; ?>
</textarea>
		</div>
		<input type='hidden' name='clase[codigo]' value="<?php echo $this->_tpl_vars['cod_clase']; ?>
"/>
		<div class='ui-button-bar'>
			<button id='bt-guardarAsistencia'>Aceptar</button>
		</div>
	</form>
	<?php if (isset ( $this->_tpl_vars['alert_message'] )): ?>
		<?php echo smarty_function_link_to(array('name' => 'Registrar nueva Asistencia','action' => 'registrar'), $this);?>

		<script type='text/javascript'>
			jAlert("<?php echo $this->_tpl_vars['alert_message']; ?>
");
		</script>
	<?php endif; ?>
</div>

<?php endif; ?>