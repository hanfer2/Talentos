<div id='wrapper-form-nuevaObservacion' class="ui-corner-all hidden">
	<h2>Nueva Observaci&oacute;n</h2>
	<form action="{url_for action=create}" method="POST" id="form-nuevaObservacion">
		<div class="ui-field">
			<label for="observacion_tipo">Tipo:</label>
			{html_select name="observacion[tipo]" options=$tipos}
		</div>
		<div class="ui-field">
			<label for="observacion_autorizado_por" class="required">Autorizado por</label>
			<input title="Quien autoriza" class="required" name="observacion[autorizado_por]" id="observacion_autorizado_por"/>
		</div>
		<div id="field-observacion-text">
			<label for="observacion_observacion" class="required textarea-label" >Observaci&oacute;n</label>
			<textarea title="observacion" name="observacion[observacion]" cols=30 rows=10></textarea>
		</div>
		<input type="hidden" value="{$cedula}" name="observacion[cedula]"/>
		<div class="ui-button-bar">
			<button id="bt-registrarObservacion">Aceptar</button>
		</div>
	</form>
	
</div>
