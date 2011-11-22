<?php /* Smarty version 2.6.26, created on 2011-11-16 16:10:40
         compiled from modules/estudiantes/templates/editar_desplazado.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select', 'modules/estudiantes/templates/editar_desplazado.tpl', 6, false),)), $this); ?>
<div class='ui-form' id='form-editarDesplazamiento'>
	<h2 class='h-1'>Situaci&oacute;n de Desplazamiento</h2>
	<h3><?php echo $this->_tpl_vars['nombre_persona']; ?>
</h3>
	<div class='ui-field' id='cod_ciudad_desplazado'>
		<label>Ciudad</label>
		<?php echo smarty_function_html_select(array('options' => $this->_tpl_vars['ciudades'],'name' => 'desplazamiento[cod_ciudad]','selected' => $this->_tpl_vars['cod_ciudad'],'title' => 'Ciudad de Desplazamiento'), $this);?>

	</div>
	<input type='hidden' name='cod_interno' value='<?php echo $this->_tpl_vars['cod_interno']; ?>
'/>
	<div class='ui-button-bar'>
		<button id='bt-editDesplazamiento'>Actualizar</button>
	</div>
</div>