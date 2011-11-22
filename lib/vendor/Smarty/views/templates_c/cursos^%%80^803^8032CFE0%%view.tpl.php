<?php /* Smarty version 2.6.26, created on 2011-11-16 14:33:06
         compiled from ./modules/cursos/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'nombre_programa', './modules/cursos/templates//view.tpl', 7, false),array('function', 'persona_url', './modules/cursos/templates//view.tpl', 20, false),array('function', 'link_to', './modules/cursos/templates//view.tpl', 31, false),array('modifier', 'escape', './modules/cursos/templates//view.tpl', 21, false),)), $this); ?>
<div class='ui-widget decorated'>
<?php if (empty ( $this->_tpl_vars['estudiantes'] )): ?>
	<h1>No se hallaron Registros</h1>
	<p>Este curso no tiene a&uacute;n estudiantes registrados</p>
<?php else: ?>
	<h1>Listado de Participantes</h1>
	<h2><?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</h2>
	<h3>Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>
</h3>
	<table class='table dataTable dt-non-paginable' id='table-participantesPorCurso'>
		<thead>
			<tr>
				<th>Doc. Id.</th><th>Nombre</th>
				<th class='column-select-filter'>Grupo</th>
				<th class='column-select-filter'>Curso</th>
			</tr>
		</thead>
		<tbody>
		<?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
			<tr>
				<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['grupo'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['nombre_grupo'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		</tbody>
	</table>
<?php endif; ?>
	<div class='ui-toolbar'>
    <a href="#<?php echo $this->_tpl_vars['cod_curso']; ?>
" id="link-verNotificaciones">Ver Notificaciones</a> | 
		<?php echo smarty_function_link_to(array('name' => 'Consultar Horario','controller' => 'horarios','action' => 'view','cod_curso' => $this->_tpl_vars['cod_curso']), $this);?>

	</div>
</div>