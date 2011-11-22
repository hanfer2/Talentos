<?php /* Smarty version 2.6.26, created on 2011-11-01 15:26:42
         compiled from modules/i_cuestionarios/templates/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/i_cuestionarios/templates/add.tpl', 2, false),array('function', 'url_for', 'modules/i_cuestionarios/templates/add.tpl', 10, false),array('function', 'include_partial', 'modules/i_cuestionarios/templates/add.tpl', 11, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_prueba'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'simulacros_sin_cuestionario','title' => 'Registrar Cuestionario'), $this);?>

	<div class='ajax-response'></div>
<?php elseif (isset ( $this->_tpl_vars['preguntas'] )): ?>
	<p><?php echo $this->_tpl_vars['message']; ?>
</p>
<?php else: ?>
	<div class='ui-widget decorated'>
		<h1>Creaci&oacute;n del Cuestionario</h1>
		<h2><?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h2>
		<form action="<?php echo smarty_function_url_for(array('action' => 'add'), $this);?>
" method="post" id="form-registrarCuestionario" >
			<?php echo smarty_function_include_partial(array('file' => 'add.form.tpl','module' => 'i_cuestionarios','componentes' => $this->_tpl_vars['componentes'],'cualitativos' => $this->_tpl_vars['cualitativos'],'competencias' => $this->_tpl_vars['competencias'],'letras' => $this->_tpl_vars['letras'],'flag' => 1), $this);?>

			<div>
				<span class='link-icon-plus'>+</span> <a href='#' id="link-adicionarPregunta">Agregar Nueva Pregunta</a>
			</div>
			<input type="hidden" name="cod_prueba" value="<?php echo $this->_tpl_vars['cod_prueba']; ?>
"/>
			<br/>
			<div class='ui-button-bar'>
				<button id="submit-registrarCuestionario">Aceptar</button>
			</div>
		</form>
	</div>
<?php endif; ?>