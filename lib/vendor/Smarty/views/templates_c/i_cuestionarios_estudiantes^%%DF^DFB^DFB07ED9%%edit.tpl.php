<?php /* Smarty version 2.6.26, created on 2011-11-02 15:46:33
         compiled from ./modules/i_cuestionarios_estudiantes/templates//edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url_for', './modules/i_cuestionarios_estudiantes/templates//edit.tpl', 4, false),)), $this); ?>

<div class="ui-widget decorated">
	<h1>Corregir Respuesta Seleccionada</h1>
	<form action="<?php echo smarty_function_url_for(array('action' => 'edit'), $this);?>
" method="post" id="form-editarIRespuesta">
	 Cédula: <input type="text" name="cedula" size="20" value="<?php echo $_REQUEST['cedula']; ?>
" tabindex="1"><br/>
	 Pregunta: <input type="text" name="numeral" size="20" value="" tabindex="2"><br/>
	 Respuesta: <input type="text" name="respuesta" size="20" value="" tabindex="3"><br/>
	 <input type="hidden" name="cod_prueba" value="<?php echo $this->_tpl_vars['cod_prueba']; ?>
" />
	 <button tabindex="4">Aceptar</button>
	</form>
</div>
