<?php /* Smarty version 2.6.26, created on 2011-09-06 14:32:00
         compiled from ./modules/observaciones/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/observaciones/templates//index.tpl', 2, false),array('function', 'nombre_programa', './modules/observaciones/templates//index.tpl', 7, false),array('function', 'persona_url', './modules/observaciones/templates//index.tpl', 18, false),array('function', 'link_to', './modules/observaciones/templates//index.tpl', 19, false),array('function', 'math', './modules/observaciones/templates//index.tpl', 23, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_programa'] )): ?>
	<?php echo smarty_function_include_template(array('file' => "programa.form",'title' => 'Listado de Observaciones'), $this);?>

	<div class='ajax-response'></div>
<?php else: ?>
<div class='ui-widget decorated'>
	<h1>Listado de Participantes con Observaciones</h1>
	<h2><?php echo smarty_function_nombre_programa(array('cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
</h2>
	<?php if (empty ( $this->_tpl_vars['estudiantes'] )): ?>
			<?php echo smarty_function_include_template(array('file' => 'no_results'), $this);?>

	<?php else: ?>
		<table class='table dataTable' id='table-listadoObservaciones'>
		<thead>
			<tr><th>Doc.ID</th><th>Nombre</th><th>Tel&eacute;fonos</th><th>Observaciones</th><th>Memos</th><th>TOTAL</th></tr>
		</thead>
		<tbody>
		<?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
			<tr>
				<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td>
				<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['estudiante']['fullname'],'action' => 'view','cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td>
				<td><?php echo $this->_tpl_vars['estudiante']['telefono']; ?>
</td>
				<td><?php echo $this->_tpl_vars['estudiante']['total_observaciones']; ?>
</td>
				<td><?php echo $this->_tpl_vars['estudiante']['total_memos']; ?>
</td>
				<td><?php echo smarty_function_math(array('equation' => "x+y",'x' => $this->_tpl_vars['estudiante']['total_observaciones'],'y' => $this->_tpl_vars['estudiante']['total_memos']), $this);?>
</td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		</tbody>
		</table>
	<?php endif; ?>
</div>
<?php endif; ?>