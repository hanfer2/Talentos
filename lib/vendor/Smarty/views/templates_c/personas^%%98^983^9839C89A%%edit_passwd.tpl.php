<?php /* Smarty version 2.6.26, created on 2011-11-21 20:45:46
         compiled from modules/personas/templates/edit_passwd.tpl */ ?>
<div class='ui-form' id='form-edit_passwd'>
	<h2>Actualizar Contrase&ntilde;a</h2>
	<?php if (! is_admin_login ( )): ?>
	<div class='ui-field'>
		<label class='required' for='passwd_old'>Contrase&ntilde;a Actual</label>
		<input type='password' id='passwd_old' name='passwd[old]' class='required'/>
	</div>
	<?php endif; ?>
	<div class='ui-field'>
		<label class='required' for='passwd_new'>Contrase&ntilde;a Nueva</label>
		<input type='password' id='passwd_new' name='passwd[new]' class='required'/>
	</div>
	<div class='ui-field'>
		<label class='required' for='passwd_confirmation'>Confirme Contrase&ntilde;a</label>
		<input type='password' id='passwd_confirmation' name='passwd[confirmation]' class='required'/>
	</div>
	<input type='hidden' name='cedula' value='<?php echo $this->_tpl_vars['cedula']; ?>
'/>
	
	<div class='ui-button-bar'>
		<button id='bt-edit_passwd'>Actualizar</button>
	</div>
</div>