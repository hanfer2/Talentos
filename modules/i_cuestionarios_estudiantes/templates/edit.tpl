
<div class="ui-widget decorated">
	<h1>Corregir Respuesta Seleccionada</h1>
	<form action="{url_for action=edit}" method="post" id="form-editarIRespuesta">
	 Cédula: <input type="text" name="cedula" size="20" value="{$smarty.request.cedula}" tabindex="1"><br/>
	 Pregunta: <input type="text" name="numeral" size="20" value="" tabindex="2"><br/>
	 Respuesta: <input type="text" name="respuesta" size="20" value="" tabindex="3"><br/>
	 <input type="hidden" name="cod_prueba" value="{$cod_prueba}" />
	 <button tabindex="4">Aceptar</button>
	</form>
</div>

