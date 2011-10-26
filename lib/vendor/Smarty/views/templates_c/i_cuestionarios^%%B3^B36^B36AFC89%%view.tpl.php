<?php /* Smarty version 2.6.26, created on 2011-07-06 16:55:36
         compiled from ./modules/i_cuestionarios/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select', './modules/i_cuestionarios/templates//view.tpl', 5, false),array('function', 'include_template', './modules/i_cuestionarios/templates//view.tpl', 8, false),array('function', 'url_for', './modules/i_cuestionarios/templates//view.tpl', 25, false),array('modifier', 'default', './modules/i_cuestionarios/templates//view.tpl', 13, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_prueba'] ) || ! isset ( $this->_tpl_vars['cod_componente'] )): ?>
	<?php ob_start(); ?>
		<div class="ui-field">
      <label for="cod_componente">Componente</label>
      <?php echo smarty_function_html_select(array('name' => 'cod_componente','options' => $this->_tpl_vars['componentes']), $this);?>

    </div>
	<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('componentes_field', ob_get_contents());ob_end_clean(); ?>
	<?php echo smarty_function_include_template(array('file' => 'simulacros_con_cuestionario','title' => 'Consultar Cuestionario','moreFields' => $this->_tpl_vars['componentes_field']), $this);?>

	<div class='ajax-response'></div>
<?php else: ?>
	<div class="ui-widget decorated" id="wp-verCuestionario">
		<h1>Cuestionario - Prueba <?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h1>
		<h2><?php echo ((is_array($_tmp=@$this->_tpl_vars['nombre_componente'])) ? $this->_run_mod_handler('default', true, $_tmp, 'TODOS LOS COMPONENTES') : smarty_modifier_default($_tmp, 'TODOS LOS COMPONENTES')); ?>
</h2>
		<h3><?php echo $this->_tpl_vars['nombre_programa']; ?>
</h3>
		<?php if ($this->_tpl_vars['estaCalificada']): ?>
		<div class="notification-flash ui-widget ui-state-error ui-corner-all">
			<span class='ui-icon ui-icon-alert inline-icon'></span>
			<strong class="text-notice-label">Advertencia:</strong> Esta prueba tiene registros calificados. Por lo cual no se podrá adicionar ni eliminar preguntas.
		</div>
		<?php endif; ?>
		<div>
		 <?php if (empty ( $this->_tpl_vars['preguntas'] )): ?>
			<p>Este simulacro no tiene un cuestionario registrado</p>
			<div class="ui-toolbar">
				<a href="<?php echo smarty_function_url_for(array('action' => 'add','cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>
">Registrar Cuestionario a esta prueba</a>
			</div>
		 <?php else: ?>
		 <form action="<?php echo smarty_function_url_for(array('action' => 'update','cod_prueba' => $this->_tpl_vars['cod_prueba'],'cod_componente' => $this->_tpl_vars['cod_componente']), $this);?>
" method="post" id="form-registrarCuestionario" onsubmit="return confirmarCreacionCuestionario();" class='ui-form'>
		 <?php $_from = $this->_tpl_vars['preguntas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['preguntas'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['preguntas']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pregunta']):
        $this->_foreach['preguntas']['iteration']++;
?>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'add.form.tpl', 'smarty_include_vars' => array('pregunta' => $this->_tpl_vars['pregunta'],'letras' => $this->_tpl_vars['letras'],'flag' => $this->_foreach['preguntas']['iteration'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		 <?php endforeach; endif; unset($_from); ?>
		 			<div>
		 		<?php if (! $this->_tpl_vars['estaCalificada']): ?>
				<span class='link-icon-plus'>+</span> <a href='#' id="link-adicionarPregunta">Agregar Nueva Pregunta</a>
				<?php endif; ?>
			</div>
			<input type="hidden" name="cod_prueba" value="<?php echo $this->_tpl_vars['cod_prueba']; ?>
"/>
			<input type="hidden" name="cod_componente" value="<?php echo $this->_tpl_vars['cod_componente']; ?>
"/>
			<br/>
			<div class='ui-button-bar'>
				<button id="submit-actualizarCuestionario">Aceptar</button>
			</div>
		</form>
		 <?php endif; ?>
		</div>
	</div>
<?php endif; ?>