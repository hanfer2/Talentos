<div class='ui-form' id='form-editarDesplazamiento'>
	<h2 class='h-1'>Situaci&oacute;n de Desplazamiento</h2>
	<h3>{$nombre_persona}</h3>
	<div class='ui-field' id='cod_ciudad_desplazado'>
		<label>Ciudad</label>
		{html_select options=$ciudades name='desplazamiento[cod_ciudad]' selected=$cod_ciudad title="Ciudad de Desplazamiento"}
	</div>
	<input type='hidden' name='cod_interno' value='{$cod_interno}'/>
	<div class='ui-button-bar'>
		<button id='bt-editDesplazamiento'>Actualizar</button>
	</div>
</div>
