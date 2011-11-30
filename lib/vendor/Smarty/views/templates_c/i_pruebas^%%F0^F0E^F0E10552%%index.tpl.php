<?php /* Smarty version 2.6.26, created on 2011-11-04 14:37:11
         compiled from ./modules/i_pruebas/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/i_pruebas/templates//index.tpl', 2, false),array('function', 'url_for', './modules/i_pruebas/templates//index.tpl', 31, false),array('function', 'html_select', './modules/i_pruebas/templates//index.tpl', 63, false),array('modifier', 'escape', './modules/i_pruebas/templates//index.tpl', 31, false),array('modifier', 'capitalize', './modules/i_pruebas/templates//index.tpl', 32, false),array('modifier', 'date_format', './modules/i_pruebas/templates//index.tpl', 32, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_programa'] )): ?>
	<?php echo smarty_function_include_template(array('file' => "programa.form",'title' => 'Listado de Pruebas','action' => 'index'), $this);?>

	<div class="ajax-response"></div>
<?php else: ?>
	<div class='ui-widget decorated'>
		<h1>Listado de Pruebas</h1>
		<h2><?php echo $this->_tpl_vars['nombre_programa']; ?>
</h2>
    
    <?php if ($this->_tpl_vars['pruebas'] == null): ?>
    <p class="ui-state-highlight ui-corner-all notif-block frm-5"><span class="ui-icon ui-icon-alert inline-icon"></span> Este programa aun no reporta pruebas creadas</p>
    <?php else: ?>
		<table class="table">
      <thead>
        <tr>
          <th class="ui-state-default" rowspan="2">Nombre</th>
          <th class="ui-state-default" rowspan="2">Tipo</th>
          <th class="ui-state-default" rowspan="2">Fecha</th>
          <th class="ui-state-default" colspan="3">Opciones</th>
        </tr>
        <tr>
          <th class="ui-state-default">Visible</th>
          <th class="ui-state-default">Editable</th>
          <th class="ui-state-default">Acciones</th>
        </tr>
			</thead>
			<tbody>
        <!--Siempore esta tomando el codigo 10 cambie el que cambie, antes no tomaba nada-->
			<?php $_from = $this->_tpl_vars['pruebas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['prueba']):
?>
				<tr>
           <input type="hidden" value="<?php echo $this->_tpl_vars['prueba']['codigo']; ?>
" id="codno"/>
					<td><a class="nombre_prueba" href="<?php echo smarty_function_url_for(array('action' => 'view','controller' => 'icfes','cod_prueba' => $this->_tpl_vars['prueba']['codigo']), $this);?>
" id="elcodigo"><?php echo ((is_array($_tmp=$this->_tpl_vars['prueba']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['prueba']['tipo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</td><td><?php echo ((is_array($_tmp=$this->_tpl_vars['prueba']['fecha'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
					<td><input type="checkbox" class="chk-visibilidadPrueba" name="visibilidad_prueba[<?php echo $this->_tpl_vars['prueba']['codigo']; ?>
]" value="<?php echo $this->_tpl_vars['prueba']['visible']; ?>
" <?php if ($this->_tpl_vars['prueba']['visible'] == 't'): ?>checked="checked" <?php endif; ?>/></td>
          <td><?php if ($this->_tpl_vars['prueba']['tipo'] != @I_TIPO_SIMULACRO): ?><input type="checkbox" class="chk-pruebaEditable" name="editable_prueba[<?php echo $this->_tpl_vars['prueba']['codigo']; ?>
]" value="<?php echo $this->_tpl_vars['prueba']['editable']; ?>
" <?php if ($this->_tpl_vars['prueba']['editable'] == 't'): ?>checked="checked" <?php endif; ?>/><?php endif; ?></td>
					<td>
					<?php if ($this->_tpl_vars['prueba']['tipo'] == @I_TIPO_SIMULACRO): ?>
					<a href="#<?php echo $this->_tpl_vars['prueba']['codigo']; ?>
" class="link-procesarPrueba"><span class="ui-icon ui-icon-play link-icon inline-icon"></span> Procesar</a>
					<?php endif; ?>
         
					</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</tbody>
		</table>
    <?php endif; ?>
    
		<div>
      <!--- TOOLBAR-->
      <div class="ui-toolbar">
        <div class="left-icon"><span class="ui-icon ui-icon-gear left-icon link-icon"></span><a href="#" id="link-sysPruebas" class="link">Opciones</a></div>
        <a href="#" id="link-registrarPrueba"><span class="ui-icon ui-icon-plus inline-icon link-icon"></span>Registrar Nueva Prueba</a>
      </div>
      
      <!--- FORM NUEVA PRUEBA-->
      <div class="ui-form boxed hidden frm-3" id="form-registrarPrueba">
        <h1>Registrar Prueba</h1>
        <div class="ui-field">
          <label for="prueba_nombre">Nombre:</label>
          <input name="prueba[nombre]" id="prueba_nombre" class="required" maxlength="20"/>
        </div>
        <div class="ui-field">
          <label for="prueba_tipo">Tipo:</label>
          <?php echo smarty_function_html_select(array('name' => "prueba[tipo]",'options' => $this->_tpl_vars['tipos_icfes']), $this);?>

        </div>
        <div class="ui-field">
          <label for="prueba_fecha">Fecha:</label>
          <input name="prueba[fecha]" id="prueba_fecha" class="date required" />
        </div>
        <input type="hidden" name="prueba[cod_programa]" value="<?php echo $this->_tpl_vars['cod_programa']; ?>
"/>
        <div class="ui-button-bar">
          <button id='bt-registrarPrueba'>Aceptar</button>
        </div>
      </div>
      
      <!-- FORM OPCIONES-->
      <div class="ui-form boxed hidden frm-3 ui-widget-content" id="frm-sys-pruebas">
        <h1>Opciones de Configuraci&oacute;n</h1>
        <div class="ui-field">
          <label for="settings_i_prueba_activa">Prueba en Proceso </label>
          <?php echo smarty_function_html_select(array('name' => "settings[i_prueba_activa]",'options' => $this->_tpl_vars['simulacros'],'extra' => 'NULL','selected' => $this->_tpl_vars['prueba_activa']), $this);?>

        </div>
        <div>
          <button id="bt-i_pruebas-guardarConfiguraciones">Aceptar</button>
        </div>
      </div>
      <div class="clear"></div>
    </div>
</div>
<?php endif; ?>