<?php /* Smarty version 2.6.26, created on 2011-10-04 15:10:31
         compiled from modules/observaciones/templates/new.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url_for', 'modules/observaciones/templates/new.tpl', 3, false),array('function', 'html_select', 'modules/observaciones/templates/new.tpl', 6, false),)), $this); ?>
<div id='wrapper-form-nuevaObservacion' class="ui-corner-all hidden">
	<h2>Nueva Observaci&oacute;n</h2>
	<form action="<?php echo smarty_function_url_for(array('action' => 'create'), $this);?>
" method="POST" id="form-nuevaObservacion">
		<div class="ui-field">
			<label for="observacion_tipo">Tipo:</label>
			<?php echo smarty_function_html_select(array('name' => "observacion[tipo]",'options' => $this->_tpl_vars['tipos']), $this);?>

		</div>
		<div class="ui-field">
			<label for="observacion_autorizado_por" class="required">Autorizado por</label>
			<input title="Quien autoriza" class="required" name="observacion[autorizado_por]" id="observacion_autorizado_por"/>
		</div>
		<div id="field-observacion-text">
			<label for="observacion_observacion" class="required textarea-label" >Observaci&oacute;n</label>
			<textarea title="observacion" name="observacion[observacion]" cols=30 rows=10></textarea>
		</div>
		<input type="hidden" value="<?php echo $this->_tpl_vars['cedula']; ?>
" name="observacion[cedula]"/>
		<div class="ui-button-bar">
			<button id="bt-registrarObservacion">Aceptar</button>
		</div>
	</form>
	
</div>