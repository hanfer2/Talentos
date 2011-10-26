<form method="post" action="{url_for name=egresados action=registrar_trabajador}">
	<label>Ocupaci&oacute;n</label>
	<input type="text" maxlength="40" name="egresado[ocupacion]"/>
	<input type="hidden" maxlength="20" name="cedula" value="{$cedula}"/>
	<div class="ui-button-bar">
		<button id="bt-registrarTrabajador">Aceptar</button>
	</div>
</form>
