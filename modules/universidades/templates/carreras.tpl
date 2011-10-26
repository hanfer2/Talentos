<div class="ui-widget decorated widget-{$display_format}">
	<h1>Listado de Carreras</h1>
	{if empty($carreras)}
		{include_template file="error" message="Esta universidad no reporta aun carreras asociadas"}
	{else}
		<h2>{$cod_universidad} - {$nombre_universidad}</h2>
		{if isset($nombre_ciudad)}<h3>{$nombre_ciudad}</h3>{/if}
		{include file="_carreras.`$display_format`_table.tpl"}
	{/if}
	
	{if $display_format neq 'min'}	
		<div class="ui-toolbar">
			<a href="#" id="link-adicionarCarrera">Adicionar carrera a esta Universidad</a> |
			{link_to name='Listado de Universidades'} | 
			{link_to name='Registrar Egresado' controller='egresados' action='add'}
		</div>
		<div id="form-adicionarCarrera" class='hidden ui-form'>
			<h2 class='header'>Adicionar Carrera</h2>
			<div class='ui-field'>
				<label>Ciudad</label>
				{to_sql classname='TCiudad' assign='ciudades_sql'}
				{html_select name='carrera[cod_ciudad]' options=$ciudades_sql selected=$smarty.get.cod_ciudad|default:$smarty.const.COD_CIUDAD_CALI}<br/>
			</div>
			<div class='ui-field'>
				<label class="required">Nombre</label>
				<input name="carrera[nombre]" id="nombre_carrera"/><br/>
			</div>
			<input name="carrera[cod_universidad]" type="hidden" value="{$cod_universidad}"/>
			<div class='ui-field'>
				<label>Modalidad</label>
				{html_select name='carrera[modalidad]' options=$modalidades}<br/>
			</div>
			<div class="ui-button-bar">
				<button id="bt-registrarCarrera">Registrar</button>
			</div>
		</div>
	{/if}
</div>
