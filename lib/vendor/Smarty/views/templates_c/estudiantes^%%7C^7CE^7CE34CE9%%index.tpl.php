<?php /* Smarty version 2.6.26, created on 2011-11-28 21:52:02
         compiled from ./modules/estudiantes/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'info', './modules/estudiantes/templates//index.tpl', 9, false),array('function', 'html_select', './modules/estudiantes/templates//index.tpl', 10, false),array('function', 'link_open_external', './modules/estudiantes/templates//index.tpl', 28, false),array('function', 'nombre_programa', './modules/estudiantes/templates//index.tpl', 30, false),array('function', 'link_to', './modules/estudiantes/templates//index.tpl', 41, false),array('function', 'persona_url', './modules/estudiantes/templates//index.tpl', 61, false),array('function', 'join', './modules/estudiantes/templates//index.tpl', 65, false),array('modifier', 'current', './modules/estudiantes/templates//index.tpl', 32, false),array('modifier', 'escape', './modules/estudiantes/templates//index.tpl', 63, false),array('modifier', 'lower', './modules/estudiantes/templates//index.tpl', 66, false),array('modifier', 'string_format', './modules/estudiantes/templates//index.tpl', 70, false),array('modifier', 'implode', './modules/estudiantes/templates//index.tpl', 86, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_programa'] )): ?>
	
	<div class="ui-widget decorated non-printable">
  <h1>Listado de Participantes</h1>
  
  <div class="ui-form" id="form-listadoDeParticipantes">
    <div class="ui-field">
      <label><?php echo $this->_config[0]['vars']['PNAT']; ?>
</label>
			<?php echo smarty_function_info(array('classname' => 'TPrograma','func' => 'toSQL','assign' => 'programas_sql'), $this);?>

			<?php echo smarty_function_html_select(array('name' => 'cod_programa','options' => $this->_tpl_vars['programas_sql'],'extra' => $this->_tpl_vars['extra']), $this);?>

    </div>
    <div class='ui-field chk-buttonset'>
			<input type='checkbox' value='11' checked='checked' id="chk-listadoActivos"/><label class='left-label' for="chk-listadoActivos">Activos</label> |
			<input type='checkbox' value='12' id="chk-listadoInactivos"/><label class='left-label' for="chk-listadoInactivos">Inactivos</label> |
			<input type='checkbox' value='13' id="chk-listadoEgresados"/><label class='left-label' for="chk-listadoEgresados">Egresados</label>
		</div>
    <div class="ui-button-bar">
      <button id="bt-listadoDeParticipantes">Consultar</button>
    </div>
    
  </div>
</div>

	<div class='ajax-response' id="ajax-listadoDeParticipantes"></div>
<?php elseif (count ( $this->_tpl_vars['estudiantes'] ) != 0): ?>
	
<div class="ui-widget decorated">
	<?php echo smarty_function_link_open_external(array(), $this);?>

  <h1>Listado de Participantes</h1>
  <h2><?php echo smarty_function_nombre_programa(array(), $this);?>
</h2>
  <?php if (count ( $this->_tpl_vars['nombres_estados'] ) == 1): ?>
    <h5><?php echo current($this->_tpl_vars['nombres_estados']); ?>
</h5>
  <?php else: ?>
    <div class="ui-buttonset" id="buttonset-filtro-estados">
    <?php $_from = $this->_tpl_vars['nombres_estados']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estado']):
?><a href="#<?php echo $this->_tpl_vars['estado']; ?>
" class="ui-state-default ui-corner-all fg-button fg-button-rect"><?php echo $this->_tpl_vars['estado']; ?>
</a><?php endforeach; endif; unset($_from); ?>
    </div>
  <?php endif; ?>
  <div class="clear"></div>
  <?php if (! is_xhr ( )): ?>
  <div class="ui-toolbar">
		<?php echo smarty_function_link_to(array('name' => 'Listado de Participantes de otro PNAT'), $this);?>

  </div>
  <?php endif; ?>
  <table class="table dataTable" id="table-listadoEstudiantes">
    <thead>
      <tr>
				<th>Doc. Id</th><th>C&oacute;digo</th>
				<th>Apellidos</th><th>Nombres</th>
				<th>Tel&eacute;fonos</th><th>E-mail</th><th>Direccion</th><th>Barrio</th>
				<th class='column-default-hidden'>Edad</th><th>Comuna</th>
				<th class='column-select-filter'>Estado</th>
				<th class='column-select-filter'>Curso</th>
				<?php if (! isset ( $this->_tpl_vars['cod_programa'] )): ?>
				<th class='column-select-filter'><?php echo $this->_config[0]['vars']['PNAT']; ?>
</th>
				<?php endif; ?>
			</tr>
    </thead>
    <tbody>
      <?php $_from = $this->_tpl_vars['estudiantes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['estudiante']):
?>
      <tr>
        <td><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['estudiante']['cedula']), $this);?>
</td>
				<td><?php echo $this->_tpl_vars['estudiante']['cod_estud']; ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['apellidos'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['nombres'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
			  <td><?php echo smarty_function_join(array('parts' => ((is_array($_tmp=($this->_tpl_vars['estudiante']['telefono']).";".($this->_tpl_vars['estudiante']['tel_celular']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'sep' => ', '), $this);?>
</td>        
        <td><?php echo smarty_function_join(array('parts' => ((is_array($_tmp=((is_array($_tmp=($this->_tpl_vars['estudiante']['email']).";".($this->_tpl_vars['estudiante']['email_2']))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)),'sep' => ', '), $this);?>
</td>
        <td><?php echo $this->_tpl_vars['estudiante']['direccion']; ?>
</td>
      <td><?php echo $this->_tpl_vars['estudiante']['nombre']; ?>
</td>
        <td><?php echo $this->_tpl_vars['estudiante']['edad']; ?>
</td>
 			  <td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['comuna'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.0f") : smarty_modifier_string_format($_tmp, "%.0f")); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['estudiante']['nombre_estado'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        <td><?php echo smarty_function_link_to(array('name' => ((is_array($_tmp=$this->_tpl_vars['estudiante']['nombre_grupo'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)),'controller' => 'cursos','action' => 'view','cod_curso' => $this->_tpl_vars['estudiante']['cod_grupo']), $this);?>
</td>
 				<?php if (! isset ( $this->_tpl_vars['cod_programa'] )): ?>
        <td><?php echo smarty_function_link_to(array('name' => $this->_tpl_vars['estudiante']['cod_programa'],'cod_programa' => $this->_tpl_vars['estudiante']['cod_programa']), $this);?>
</td>
        <?php endif; ?>
      </tr>
      <?php endforeach; endif; unset($_from); ?>
    </tbody>
  </table>
  <div class="toTop">Arriba<span class="ui-icon"></span></div>
</div>
<?php else: ?>
	<div class='ui-widget decorated'>
		<h1>No se hallaron registros</h1>
		<h2><?php echo smarty_function_nombre_programa(array(), $this);?>
</h2>
		<p>No se hallaron estudiantes <?php echo ((is_array($_tmp=",")) ? $this->_run_mod_handler('implode', true, $_tmp, $this->_tpl_vars['nombres_estados']) : implode($_tmp, $this->_tpl_vars['nombres_estados'])); ?>
 pertenecientes al PNAT <?php echo $this->_tpl_vars['nombre_programa']; ?>
</p>
		<div class="ui-toolbar"><?php echo smarty_function_link_to(array('name' => "Modificar Búsqueda"), $this);?>
</div>
	</div>
<?php endif; ?>