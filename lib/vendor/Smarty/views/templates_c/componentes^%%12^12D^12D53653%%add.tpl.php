<?php /* Smarty version 2.6.26, created on 2011-07-06 16:43:41
         compiled from modules/componentes/templates/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select', 'modules/componentes/templates/add.tpl', 13, false),)), $this); ?>
<div class='ui-form boxed' id='form-registrarNuevoComponente'>
	<h2>Nuevo Componente</h2>
	<div class='ui-field'>
		<label for='componentes_codigo' class='required'>C&oacute;digo</label>
		<input name='componentes[codigo]' id='componentes_codigo' maxlength="6" class='numeric required' title='C&oacute;digo'/>
	</div>
	<div class='ui-field'>
		<label for='componentes_nombre' class='required'>Nombre</label>
		<input name='componentes[nombre]' id='componentes_nombre' maxlength="80" class='required' title='Nombre'/>
	</div>
	<div class='ui-field'>
		<label for='componentes_modalidad'>Modalidad</label>
		<?php echo smarty_function_html_select(array('name' => 'componentes[modalidad]','options' => $this->_tpl_vars['modalidades'],'title' => 'Modalidad'), $this);?>

	</div>
	<div class='ui-button-bar'>
		<button id='bt-registrarNuevoComponente'>Registrar</button>
	</div>
</div>