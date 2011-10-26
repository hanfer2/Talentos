<div class='ui-form' id='form-delete-estudiante'>
	<h3>{$nombre|escape}</h3>
	<div class='ui-field'>
		<label>Motivo: </label>
		{html_select name='persona[causa_bloqueo]' options=$causas_bloqueo selected=3}
	</div>
	<div class='ui-field'>
		<label>Autorizado por: </label>
    {html_select name="persona[authorized_by]" options=$auth_admins}
	</div>
	<input type='hidden' name='persona[cod_interno]' value='{$cod_interno}' />
	<div class='ui-button-bar'>
		<button type='button' id='bt-delete-persona'>Dar de Baja</button>
	</div>
</div>
