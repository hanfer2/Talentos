<?php /* Smarty version 2.6.26, created on 2011-08-08 10:30:54
         compiled from modules/universidades/templates/carreras.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/universidades/templates/carreras.tpl', 4, false),array('function', 'link_to', 'modules/universidades/templates/carreras.tpl', 14, false),array('function', 'to_sql', 'modules/universidades/templates/carreras.tpl', 21, false),array('function', 'html_select', 'modules/universidades/templates/carreras.tpl', 22, false),array('modifier', 'default', 'modules/universidades/templates/carreras.tpl', 22, false),)), $this); ?>
<div class="ui-widget decorated widget-<?php echo $this->_tpl_vars['display_format']; ?>
">
	<h1>Listado de Carreras</h1>
	<?php if (empty ( $this->_tpl_vars['carreras'] )): ?>
		<?php echo smarty_function_include_template(array('file' => 'error','message' => 'Esta universidad no reporta aun carreras asociadas'), $this);?>

	<?php else: ?>
		<h2><?php echo $this->_tpl_vars['cod_universidad']; ?>
 - <?php echo $this->_tpl_vars['nombre_universidad']; ?>
</h2>
		<?php if (isset ( $this->_tpl_vars['nombre_ciudad'] )): ?><h3><?php echo $this->_tpl_vars['nombre_ciudad']; ?>
</h3><?php endif; ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_carreras.".($this->_tpl_vars['display_format'])."_table.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endif; ?>
	
	<?php if ($this->_tpl_vars['display_format'] != 'min'): ?>	
		<div class="ui-toolbar">
			<a href="#" id="link-adicionarCarrera">Adicionar carrera a esta Universidad</a> |
			<?php echo smarty_function_link_to(array('name' => 'Listado de Universidades'), $this);?>
 | 
			<?php echo smarty_function_link_to(array('name' => 'Registrar Egresado','controller' => 'egresados','action' => 'add'), $this);?>

		</div>
		<div id="form-adicionarCarrera" class='hidden ui-form'>
			<h2 class='header'>Adicionar Carrera</h2>
			<div class='ui-field'>
				<label>Ciudad</label>
				<?php echo smarty_function_to_sql(array('classname' => 'TCiudad','assign' => 'ciudades_sql'), $this);?>

				<?php echo smarty_function_html_select(array('name' => 'carrera[cod_ciudad]','options' => $this->_tpl_vars['ciudades_sql'],'selected' => ((is_array($_tmp=@$_GET['cod_ciudad'])) ? $this->_run_mod_handler('default', true, $_tmp, @COD_CIUDAD_CALI) : smarty_modifier_default($_tmp, @COD_CIUDAD_CALI))), $this);?>
<br/>
			</div>
			<div class='ui-field'>
				<label class="required">Nombre</label>
				<input name="carrera[nombre]" id="nombre_carrera"/><br/>
			</div>
			<input name="carrera[cod_universidad]" type="hidden" value="<?php echo $this->_tpl_vars['cod_universidad']; ?>
"/>
			<div class='ui-field'>
				<label>Modalidad</label>
				<?php echo smarty_function_html_select(array('name' => 'carrera[modalidad]','options' => $this->_tpl_vars['modalidades']), $this);?>
<br/>
			</div>
			<div class="ui-button-bar">
				<button id="bt-registrarCarrera">Registrar</button>
			</div>
		</div>
	<?php endif; ?>
</div>