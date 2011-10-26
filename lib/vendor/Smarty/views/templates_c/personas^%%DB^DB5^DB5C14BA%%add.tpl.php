<?php /* Smarty version 2.6.26, created on 2011-07-06 16:41:48
         compiled from ./modules/personas/templates//add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'persona_url', './modules/personas/templates//add.tpl', 5, false),array('function', 'url_for', './modules/personas/templates//add.tpl', 11, false),array('function', 'html_select', './modules/personas/templates//add.tpl', 14, false),array('function', 'html_input', './modules/personas/templates//add.tpl', 67, false),array('modifier', 'escape', './modules/personas/templates//add.tpl', 5, false),array('modifier', 'default', './modules/personas/templates//add.tpl', 14, false),array('modifier', 'lower', './modules/personas/templates//add.tpl', 79, false),array('modifier', 'string_format', './modules/personas/templates//add.tpl', 105, false),)), $this); ?>
<div class="ui-widget decorated" id="w-<?php echo $_GET['accion']; ?>
-usuario">

	<?php if ($_GET['accion'] == 'edit'): ?>
		<h1>Actualizar Usuario en el Sistema</h1>
		<h2><span id='header-link-cedula'><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
</span> - <?php echo ((is_array($_tmp=$this->_tpl_vars['nombre_persona'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</h2>
	<?php else: ?>
		<h1>Registrar Usuario en el Sistema</h1>
	<?php endif; ?>
	
	<div id='ajax-load-registrarPersona'></div>
	<form action="<?php echo smarty_function_url_for(array('action' => $_GET['accion'],'cedula' => $this->_tpl_vars['cedula']), $this);?>
" method='post' id='form-registrarPersona' class='hidden'>

  	<label>Tipo de Usuario</label>
		<?php echo smarty_function_html_select(array('name' => "persona[cod_tipo_per]",'options' => $this->_tpl_vars['tipos_personas'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['persona']['cod_tipo_per'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['tipo']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['tipo'])),'extra' => 'NULL'), $this);?>

  
		
		<!-- DATOS PERSONALES -->
		<fieldset>
			<div id='wrapper_cedula_fields'>
				<div class="ui-field">
					<label for='persona_cod_tipo_ced'>Tipo Doc. Id</label>
					<?php echo smarty_function_html_select(array('name' => 'persona[cod_tipo_ced]','options' => $this->_tpl_vars['tipos_cedulas'],'title' => 'Tipo de C&eacute;dula','selected' => ((is_array($_tmp=@$this->_tpl_vars['persona']['cod_tipo_ced'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>

				</div>
				<div class='ui-field'>
					<label class='required' for='persona_cedula'>Doc. Id</label>
					<input name="persona[cedula]" class="required numeric" value="<?php echo $this->_tpl_vars['persona']['cedula']; ?>
"/>
				</div>
				<div class="ui-field">
					<label for="persona_cod_expedida">Expedida en:</label>
					<input class="autocompletable ac-q-ciudad"/>
					<input type="hidden" id="persona_cod_expedida" name="persona[cod_expedida]"/>
				</div>
			</div>
		<?php if (isset ( $this->_tpl_vars['persona'] )): ?><input type='hidden' value='<?php echo $this->_tpl_vars['persona']['cod_interno']; ?>
' name='persona[cod_interno]' /><?php endif; ?>
			<div class='ui-field'>
				<label class='required' for='persona_nombres'>Nombres:</label>
				<input name="persona[nombres]" class="required alpha" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['nombres'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
			</div>
			<div class='ui-field'>
				<label class='required' for='persona_apellidos'>Apellidos:</label>
				<input name="persona[apellidos]" class="required alpha" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['persona']['apellidos'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
			</div>
			<div class='ui-field'>
				<label>Género:</label>
				<input type='radio' name='persona[genero]' value='M' <?php if (! isset ( $this->_tpl_vars['persona']['genero'] ) || $this->_tpl_vars['persona']['genero'] == 'M'): ?>checked='checked'<?php endif; ?>/><label>Masc.</label>
				<input type='radio' name='persona[genero]' value='F' <?php if ($this->_tpl_vars['persona']['genero'] == 'F'): ?>checked='checked'<?php endif; ?>/><label>Fem.</label>
			</div>
			<div class='ui-field'>
				<label for='persona_cod_estado_civil'>Estado Civil:</label>
				<?php echo smarty_function_html_select(array('name' => 'persona[cod_estado_civil]','options' => $this->_tpl_vars['estados_civiles'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['persona']['cod_estado_civil'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'title' => 'Estado Civil'), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_fecha_nacimiento'>Fecha Nacim.</label>
				<input class="date" name="persona[fecha_nacimiento]" value="<?php echo $this->_tpl_vars['persona']['fecha_nacimiento']; ?>
" readonly="readonly"/>
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
				<?php echo smarty_function_html_input(array('name' => 'persona[telefono]','class' => 'phone numeric','value' => $this->_tpl_vars['persona']['telefono']), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_tel_celular'>Celular:</label>
			<?php echo smarty_function_html_input(array('name' => 'persona[tel_celular]','class' => 'phone numeric','value' => $this->_tpl_vars['persona']['tel_celular']), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_telefono_alt'>Teléfono Alt.:</label>
				<?php echo smarty_function_html_input(array('name' => 'persona[telefono_alt]','class' => 'phone numeric','value' => $this->_tpl_vars['persona']['telefono_alt']), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_email'>E-mail.</label>
				<?php echo smarty_function_html_input(array('name' => 'persona[email]','class' => 'email','title' => 'Correo Electrónico','value' => ((is_array($_tmp=$this->_tpl_vars['persona']['email'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)),'maxlength' => 100), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_email_2'>E-mail Alt.</label>
				<?php echo smarty_function_html_input(array('name' => 'persona[email_2]','class' => 'email','title' => 'Correo Electrónico Alternativo','value' => ((is_array($_tmp=$this->_tpl_vars['persona']['email_2'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)),'maxlength' => 100), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_direccion'>Direcci&oacute;n:</label>
			<?php echo smarty_function_html_input(array('name' => 'persona[direccion]','class' => 'address','title' => 'Dirección','value' => $this->_tpl_vars['persona']['direccion']), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_direccion_alt'>Direcci&oacute;n Alt.:</label>
				<?php echo smarty_function_html_input(array('name' => 'persona[direccion_alt]','class' => 'address','title' => 'Dirección Alternativa','value' => $this->_tpl_vars['persona']['direccion_alt']), $this);?>

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
				<?php echo smarty_function_html_input(array('name' => 'persona[comuna]','class' => 'numeric','value' => ((is_array($_tmp=$this->_tpl_vars['persona']['comuna'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%1d") : smarty_modifier_string_format($_tmp, "%1d"))), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_comuna'>Estrato:</label>
				<?php echo smarty_function_html_select(array('name' => 'persona[estrato]','options' => $this->_tpl_vars['estratos'],'title' => 'Estrato','selected' => $this->_tpl_vars['persona']['estrato']), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_hijos' title='Numero de Hijos'>N&deg;. de Hijos:</label>
				<?php echo smarty_function_html_input(array('name' => 'persona[hijos]','class' => 'numeric','title' => 'Numero de Hijos','value' => $this->_tpl_vars['persona']['hijos']), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_enEmbarazo' title='En Embarazo'>En Embarazo: </label>
				<input type='checkbox' name='persona[enEmbarazo]' id='persona_enEmbarazo' title='En Embarazo' <?php if ($this->_tpl_vars['persona']['enEmbarazo']): ?> checked='checked' <?php endif; ?> value='t'/>
			</div>
		</fieldset>
		<fieldset id='fieldset-exenciones'>
			<legend>Condiciones de Exenci&oacute;n</legend>
			<div class='ui-field'>
				<label for='persona_cod_discapacidad'>Discapacidad</label>
				<?php echo smarty_function_html_select(array('name' => 'persona[cod_discapacidad]','options' => $this->_tpl_vars['discapacidades'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['persona']['cod_discapacidad'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

			</div>
			<div class='ui-field'>
				<label for='persona_cod_etnia'>Etnia</label>
				<?php echo smarty_function_html_select(array('name' => 'persona[cod_etnia]','options' => $this->_tpl_vars['etnias'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['persona']['cod_etnia'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

			</div>			
		</fieldset>
    
    <?php echo smarty_function_html_input(array('name' => 'persona[updated_by]','class' => 'hidden','title' => 'Realizado por','value' => $this->_tpl_vars['persona']['updated_by']), $this);?>

		<div class='ui-button-bar'>
			<button id='bt-registrarPersona'>Aceptar</button><br/>
			<button type='reset'>Deshacer</button>
			<button type='button' id='bt-cancelarActualizacion'>Cancelar</button>
		</div>
  </form>
	<?php if (isset ( $this->_tpl_vars['message'] )): ?>
	<script type='text/javascript'>jAlert("<?php echo $this->_tpl_vars['message']; ?>
")</script>
	<?php endif; ?>
</div>