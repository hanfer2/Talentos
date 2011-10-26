<div class='ui-form' id='form-edit_passwd'>
	<h2>Actualizar Contrase&ntilde;a</h2>
	{if !is_admin_login()}
	<div class='ui-field'>
		<label class='required' for='passwd_old'>Contrase&ntilde;a Actual</label>
		<input type='password' id='passwd_old' name='passwd[old]' class='required'/>
	</div>
	{/if}
	<div class='ui-field'>
		<label class='required' for='passwd_new'>Contrase&ntilde;a Nueva</label>
		<input type='password' id='passwd_new' name='passwd[new]' class='required'/>
	</div>
	<div class='ui-field'>
		<label class='required' for='passwd_confirmation'>Confirme Contrase&ntilde;a</label>
		<input type='password' id='passwd_confirmation' name='passwd[confirmation]' class='required'/>
	</div>
	<input type='hidden' name='cedula' value='{$cedula}'/>
	
	<div class='ui-button-bar'>
		<button id='bt-edit_passwd'>Actualizar</button>
	</div>
</div>