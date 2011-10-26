<div class="ui-widget decorated" id="w-{$smarty.get.accion}-usuario">

	{if $smarty.get.accion eq 'edit'}
		<h1>Actualizar Usuario en el Sistema</h1>
		<h2><span id='header-link-cedula'>{persona_url cedula=$cedula}</span> - {$nombre_persona|escape}</h2>
	{else}
		<h1>Registrar Usuario en el Sistema</h1>
	{/if}
	
	<div id='ajax-load-registrarPersona'></div>
	<form action="{url_for action=$smarty.get.accion cedula=$cedula}" method='post' id='form-registrarPersona' class='hidden'>

  	<label>Tipo de Usuario</label>
		{html_select name="persona[cod_tipo_per]" options=$tipos_personas selected=$persona.cod_tipo_per|default:$tipo extra=NULL }
  
		
		<!-- DATOS PERSONALES -->
		<fieldset>
			<div id='wrapper_cedula_fields'>
				<div class="ui-field">
					<label for='persona_cod_tipo_ced'>Tipo Doc. Id</label>
					{html_select name='persona[cod_tipo_ced]' options=$tipos_cedulas title='Tipo de C&eacute;dula' selected=$persona.cod_tipo_ced|default:1}
				</div>
				<div class='ui-field'>
					<label class='required' for='persona_cedula'>Doc. Id</label>
					<input name="persona[cedula]" class="required numeric" value="{$persona.cedula}"/>
				</div>
				<div class="ui-field">
					<label for="persona_cod_expedida">Expedida en:</label>
					<input class="autocompletable ac-q-ciudad"/>
					<input type="hidden" id="persona_cod_expedida" name="persona[cod_expedida]"/>
				</div>
			</div>
		{if isset($persona)}<input type='hidden' value='{$persona.cod_interno}' name='persona[cod_interno]' />{/if}
			<div class='ui-field'>
				<label class='required' for='persona_nombres'>Nombres:</label>
				<input name="persona[nombres]" class="required alpha" value="{$persona.nombres|escape}"/>
			</div>
			<div class='ui-field'>
				<label class='required' for='persona_apellidos'>Apellidos:</label>
				<input name="persona[apellidos]" class="required alpha" value="{$persona.apellidos|escape}"/>
			</div>
			<div class='ui-field'>
				<label>Género:</label>
				<input type='radio' name='persona[genero]' value='M' {if !isset($persona.genero) or $persona.genero eq 'M'}checked='checked'{/if}/><label>Masc.</label>
				<input type='radio' name='persona[genero]' value='F' {if $persona.genero eq 'F'}checked='checked'{/if}/><label>Fem.</label>
			</div>
			<div class='ui-field'>
				<label for='persona_cod_estado_civil'>Estado Civil:</label>
				{html_select name='persona[cod_estado_civil]' options=$estados_civiles selected=$persona.cod_estado_civil|default:0 title='Estado Civil'}
			</div>
			<div class='ui-field'>
				<label for='persona_fecha_nacimiento'>Fecha Nacim.</label>
				<input class="date" name="persona[fecha_nacimiento]" value="{$persona.fecha_nacimiento}" readonly="readonly"/>
			</div>
			<div class='ui-field'>
				<label>Ciudad Nacim.</label>
				<input class="autocompletable ac-q-ciudad" title="Ciudad de Nacimiento"/>
				<input type="hidden" id="persona_cod_lugar_nacimiento" name="persona[cod_lugar_nacimiento]"/>
			</div>
		</fieldset>

		<!-- DOMICILIO -->
		<fieldset>
			<div class='ui-field'>
				<label for='persona_telefono'>Teléfono:</label>
				{html_input name='persona[telefono]' class='phone numeric' value=$persona.telefono}
			</div>
			<div class='ui-field'>
				<label for='persona_tel_celular'>Celular:</label>
			{html_input name='persona[tel_celular]' class='phone numeric' value=$persona.tel_celular}
			</div>
			<div class='ui-field'>
				<label for='persona_telefono_alt'>Teléfono Alt.:</label>
				{html_input name='persona[telefono_alt]' class='phone numeric' value=$persona.telefono_alt}
			</div>
			<div class='ui-field'>
				<label for='persona_email'>E-mail.</label>
				{html_input name='persona[email]' class='email' title='Correo Electrónico' value=$persona.email|lower maxlength=100}
			</div>
			<div class='ui-field'>
				<label for='persona_email_2'>E-mail Alt.</label>
				{html_input name='persona[email_2]' class='email' title='Correo Electrónico Alternativo' value=$persona.email_2|lower maxlength=100}
			</div>
			<div class='ui-field'>
				<label for='persona_direccion'>Direcci&oacute;n:</label>
			{html_input name='persona[direccion]' class='address' title='Dirección' value=$persona.direccion}
			</div>
			<div class='ui-field'>
				<label for='persona_direccion_alt'>Direcci&oacute;n Alt.:</label>
				{html_input name='persona[direccion_alt]' class='address' title='Dirección Alternativa' value=$persona.direccion_alt}
			</div>
			<div class="ui-field">
				<label for='persona_cod_ciudad'>Ciudad:</label>
				<input class="autocompletable ac-q-ciudad"  title="Ciudad de Residencia"/>
				<input type="hidden" id="persona_cod_ciudad" name="persona[cod_ciudad]"/>
			</div>
			<div class='ui-field'>
				<label for='persona_barrio'>Barrio:</label>
				<input class="autocompletable ac-q-barrio" title="Nombre del Barrio"/>
				<input type="hidden" name="persona[cod_lugar_nacimiento]" />
			</div>
			<div class='ui-field'>
				<label for='persona_comuna'>Comuna:</label>
				{html_input name='persona[comuna]' class='numeric' value=$persona.comuna|string_format:"%1d"}
			</div>
			<div class='ui-field'>
				<label for='persona_comuna'>Estrato:</label>
				{html_select name='persona[estrato]' options=$estratos title='Estrato' selected=$persona.estrato }
			</div>
			<div class='ui-field'>
				<label for='persona_hijos' title='Numero de Hijos'>N&deg;. de Hijos:</label>
				{html_input name='persona[hijos]' class='numeric' title='Numero de Hijos' value=$persona.hijos }
			</div>
			<div class='ui-field'>
				<label for='persona_enEmbarazo' title='En Embarazo'>En Embarazo: </label>
				<input type='checkbox' name='persona[enEmbarazo]' id='persona_enEmbarazo' title='En Embarazo' {if $persona.enEmbarazo} checked='checked' {/if} value='t'/>
			</div>
		</fieldset>
		<fieldset id='fieldset-exenciones'>
			<legend>Condiciones de Exenci&oacute;n</legend>
			<div class='ui-field'>
				<label for='persona_cod_discapacidad'>Discapacidad</label>
				{html_select name='persona[cod_discapacidad]' options=$discapacidades selected=$persona.cod_discapacidad|default:0}
			</div>
			<div class='ui-field'>
				<label for='persona_cod_etnia'>Etnia</label>
				{html_select name='persona[cod_etnia]' options=$etnias selected=$persona.cod_etnia|default:0}
			</div>			
		</fieldset>
    
    {html_input name='persona[updated_by]' class='hidden' title='Realizado por' value=$persona.updated_by }
		<div class='ui-button-bar'>
			<button id='bt-registrarPersona'>Aceptar</button><br/>
			<button type='reset'>Deshacer</button>
			<button type='button' id='bt-cancelarActualizacion'>Cancelar</button>
		</div>
  </form>
	{if isset($message)}
	<script type='text/javascript'>jAlert("{$message}")</script>
	{/if}
</div>
