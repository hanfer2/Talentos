<div class='ui-widget decorated non-printable form-buscarPersona'>
	<h1>{$title}</h1>
  {if isset($subtitle)}
  <h2>{$subtitle}</h2>
  {/if}
	<div class='ui-form form-cedula' id='form-{$title|camelize}'>
		<div class='ui-field'>
			<label>Doc. Id</label>
			<input name='cedula' id='input-buscarPorCedula' class='numeric required cedula'/>
		</div>
	</div>
	<div class='ui-button-bar'>
		<button id='bt-{$title|camelize}' class='button-search'>Aceptar</button>
	</div>
	<div class='ui-toolbar'>
		<a href='#' class='link-buscarPorApellido'>Buscar por Apellido</a><br/>
		{$links}
	</div>
	<div  class='ui-form' id='form-buscarPorApellido'>
		{include_partial file='buscarPorApellido' module=personas}
	</div>
</div>
