<?php /* Smarty version 2.6.26, created on 2011-07-21 15:18:30
         compiled from modules/egresados/templates/_ies.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/egresados/templates/_ies.tpl', 3, false),array('function', 'info', 'modules/egresados/templates/_ies.tpl', 9, false),array('function', 'persona_url', 'modules/egresados/templates/_ies.tpl', 31, false),array('function', 'link_to', 'modules/egresados/templates/_ies.tpl', 32, false),array('function', 'join', 'modules/egresados/templates/_ies.tpl', 34, false),array('modifier', 'escape', 'modules/egresados/templates/_ies.tpl', 32, false),array('modifier', 'date_format', 'modules/egresados/templates/_ies.tpl', 42, false),)), $this); ?>
<div class="ui-widget decorated" id='ajax-listadoEgresados'>
 <?php if (( empty ( $this->_tpl_vars['egresados'] ) )): ?>
	<?php echo smarty_function_include_template(array('file' => 'error','message' => "No se hallaron <strong>Participantes Egresados con Ingreso a Educaci&oacute;n Superior</strong> pertenecientes al PNAT ".($this->_tpl_vars['cod_programa'])), $this);?>

 <?php else: ?>
		 <h1>
					Listado de Estudiantes Egresados<br/>
					Con Ingreso a Educaci&oacute;n Superior
		 </h1>
		 <h2>Plan <?php echo smarty_function_info(array('classname' => 'TPrograma','func' => 'nombre','args' => $this->_tpl_vars['cod_programa']), $this);?>
</h2>
	  <table class="table dataTable" id="table-ListadoIES">
	 	<thead>
	 	 <tr>
	    <th>C&oacute;digo</th>
	 		<th>Doc. Id</th>
	 		<th style="width:5cm">Nombre</th>
	 		<th style="width:3cm">Direcci&oacute;n</th>
	 		<th>Tel&eacute;fonos</th><th title='Correo Electŕ&oacute;nico'>Correo E.</th>
	 		<th class='column-select-filter'>G&eacute;nero</th>
	 		<th>Edad<div style="font-size:8pt;">(A&ntilde;os)</div></th>
	 		<th>Colegio</th>
	 		<th class="column-select-filter long-select" title="Instituci&oacute;n de Educaci&oacute;n Superior">Inst. Educ. Sup.</th>
	 		<th class="column-select-filter long-select">Carrera</th>
	 		<th class="column-select-filter">Ciudad</th>
	 		<th>Fecha<br/>Ingreso</th>
	 	 </tr>
	 	</thead>
	 	<tbody>
	 <?php $_from = $this->_tpl_vars['egresados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['egresado']):
?>
	 	<tr>
	 	  <td><?php echo $this->_tpl_vars['egresado']['cod_estud']; ?>
</td>
	 		<td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['egresado']['cedula']), $this);?>
</td>
			<td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=$this->_tpl_vars['egresado']['fullname'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'action' => 'view','cedula' => $this->_tpl_vars['egresado']['cedula']), $this);?>
</td>
	 		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['direccion'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
	 		<td><?php echo smarty_function_join(array('parts' => ((is_array($_tmp=($this->_tpl_vars['egresado']['telefono']).";".($this->_tpl_vars['egresado']['tel_celular']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'sep' => ', '), $this);?>
</td>
	 		<td><?php echo smarty_function_join(array('parts' => ((is_array($_tmp=($this->_tpl_vars['egresado']['email']).";".($this->_tpl_vars['egresado']['email_2']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'sep' => ', '), $this);?>
</td>
	 		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['genero'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
	 		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['edad'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
	 		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['nombre_colegio'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['egresado']['nombre_universidad'],'controller' => 'universidades','action' => 'egresados','cod_universidad' => $this->_tpl_vars['egresado']['cod_universidad']), $this);?>
</td>
			<td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['egresado']['nombre_carrera'],'controller' => 'universidades','action' => 'egresados','cod_universidad' => $this->_tpl_vars['egresado']['cod_universidad'],'cod_carrera' => $this->_tpl_vars['egresado']['cod_carrera']), $this);?>
</td>
			<td><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['nombre_ciudad'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			<td class='date'><?php echo ((is_array($_tmp=$this->_tpl_vars['egresado']['fecha_ingreso'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
		</tr>
	 <?php endforeach; endif; unset($_from); ?>
	 	</tbody>
	  </table>
  <?php endif; ?>
	<div class="ui-toolbar">
		<?php echo smarty_function_link_to(array('name' => 'Registrar Egresados I.E.S.','action' => 'add','cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>

	</div>
</div>