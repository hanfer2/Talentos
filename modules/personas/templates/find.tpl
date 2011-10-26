<form action='{url_for action=view}'>
	{include_template file='persona.form' title='Buscar Persona'}
	<input type='hidden' name='controlador' value='personas' />
	<input type='hidden' name='accion' value='view' />
</form>
