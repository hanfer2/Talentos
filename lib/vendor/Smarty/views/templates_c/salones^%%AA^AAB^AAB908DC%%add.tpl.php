<?php /* Smarty version 2.6.26, created on 2011-07-06 16:44:34
         compiled from modules/salones/templates/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url_for', 'modules/salones/templates/add.tpl', 2, false),array('function', 'html_select', 'modules/salones/templates/add.tpl', 7, false),array('modifier', 'default', 'modules/salones/templates/add.tpl', 7, false),)), $this); ?>
  <h2>Registrar Sal&oacute;n en el Sistema</h2>		
	<form action="<?php echo smarty_function_url_for(array('action' => 'create'), $this);?>
" method='post' id='form-registrarSalon' >		
		<fieldset>
			<div id=''>
				<div class="ui-field">
					<label for='salon_sede'>Sede</label>
					<?php echo smarty_function_html_select(array('name' => 'salon[sede]','options' => $this->_tpl_vars['sedes'],'title' => 'Sede','selected' => ((is_array($_tmp=@$this->_tpl_vars['salon']['sede'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>

				</div>
				<div class='ui-field'>
					<label for='salon_edificio'>Edificio</label>
					<input name="salon[edificio]" />
				</div>
				<div class="ui-field">
					<label for="salon_descripcion">Sal&oacute;n</label>					
					<input name="salon[salon]" />
				</div>
			</div>		
		</fieldset>        
		<div class='ui-button-bar'>
			<button id='bt-registrarSalon'>Aceptar</button>
			<button type='button' id='bt-cancelarActualizacion' onclick="location.reload()">Cancelar</button>
		</div>
  </form>
	