<?php /* Smarty version 2.6.26, created on 2011-07-27 20:51:12
         compiled from modules/egresados/templates/add.form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select', 'modules/egresados/templates/add.form.tpl', 35, false),array('function', 'link_to', 'modules/egresados/templates/add.form.tpl', 45, false),)), $this); ?>
<div id="wrapper-form-ies" class="ui-state-active">
  <h3>Formulario de Ingreso a Eduaci&oacute;n Superior</h3>

  <div class="ui-form" id="form-ies" >
    <input name="cedula" type="hidden" id="egresados_cedula" value="<?php echo $this->_tpl_vars['cedula']; ?>
"/>
    <div id="panel-campos-dinamicos" class="ui-panel">
      <div class="ui-field" id="panel-Ciudad">
        <label for="cod_ciudad">Ciudad</label>
        <input type="text" id="nombre_ciudad" size="28" value="SANTIAGO DE CALI" class="autocompletable"/>
        <input type="hidden" id="cod_ciudad" size="28" value="<?php echo @COD_CIUDAD_CALI; ?>
"/>
      </div>

      <div class="ui-field" id="panel-Universidad">
        <label for="nombre_universidad">Universidad</label>
        <input type="text" id="nombre_universidad" size="28" class="autocompletable"/>
        <input type="hidden" name="IES[cod_universidad]" id="cod_universidad"/>
				<div class="clear"></div>
      </div>

      <div class="ui-field" id="panel-Carrera">
        <label for="nombre_carrera">Carrera</label>
        <input type="hidden" id="cod_carrera" name="IES[cod_carrera]"/>
        <input type="text" id="nombre_carrera" size="28" class="autocompletable" />
        <span class="ui-icon ui-icon-folder-open right-icon clickable ui-corner-all" title="Mostrar Todas las Carreras de esta Universidad" id="icon-mostrarTodasCarreras"></span>
        
      </div>
    </div>
		<div id="panel-campos-estaticos" class="ui-panel">
			<div class="ui-field" >
				<label for="fechaIngreso">Fecha Ingreso </label>
				<input type="text" class="date" id="fecha_ingreso" name="IES[fecha_ingreso]" readonly="readonly"/>
			</div>
			<div class="ui-field" >
				<label for="nSemestre">Nro. Semestres </label>
				<?php echo smarty_function_html_select(array('name' => "IES[nSemestres]",'options' => $this->_tpl_vars['semestres'],'id' => 'nSemestres','selected' => 10), $this);?>

			</div>  
		</div>  
		<div class="ui-button-bar">  
			<button id="bt-registrarEgresadoIES">Registrar</button>  
		</div>  
		<div id="loading-message"></div>
  </div>  
  
	<div class="ui-toolbar">  
		<?php echo smarty_function_link_to(array('name' => 'Adicionar Universidad','controller' => 'universidades','action' => 'add'), $this);?>
 |
		<?php echo smarty_function_link_to(array('name' => 'Listado de Universidades','controller' => 'universidades'), $this);?>

	</div>
  
  <!-- Dialog 'Mostrar Todas las Carreras'-->
  <div id="widget-mostrarTodasCarreras"></div>
</div>