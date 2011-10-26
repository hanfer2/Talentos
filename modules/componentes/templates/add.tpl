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
		{html_select name='componentes[modalidad]' options=$modalidades title='Modalidad'}
	</div>
	<div class='ui-button-bar'>
		<button id='bt-registrarNuevoComponente'>Registrar</button>
	</div>
</div>