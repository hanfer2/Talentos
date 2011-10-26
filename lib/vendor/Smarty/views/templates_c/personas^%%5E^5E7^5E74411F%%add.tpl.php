<?php /* Smarty version 2.6.26, created on 2011-10-04 16:11:09
         compiled from modules/estudiantes_notificaciones/templates/add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'modules/estudiantes_notificaciones/templates/add.tpl', 3, false),)), $this); ?>
<div class="ui-form frm-5 hfrm boxed" id="wrapper-new-notificacion">
	<h2>Nueva Notificaci&oacute;n</h2>
	<label for="notificacion_fecha_inicio" class="required">Fecha Inicio</label><input class="date" name="notificacion[fecha_inicio]" id="notificacion_fecha_inicio" value="<?php echo ((is_array($_tmp='now')) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
"/>
	<label for="notificacion_fecha_fin">Fecha Fin</label><input class="date" name="notificacion[fecha_fin]" id="notificacion_fecha_fin"/>
	<div><label class="required" for="notificacion_mensaje">Mensaje:</label><br/><textarea cols="60" rows="10" id="notificacion_mensaje" name="notificacion[mensaje]"></textarea></div>
	<div class="ui-button-bar">
		<button class="ui-button ui-widget ui-corner-all ui-state-default ui-button-text-icon right-button" id="bt-agregarNotificacion">
			<span class="ui-icon ui-icon-disk ui-button-icon-primary"></span><span class="ui-button-text">Guardar</span>
		</button>
		<button class="ui-button ui-widget ui-corner-all ui-state-default ui-button-text-icon right-button" id="bt-cancelarNuevaNotificacion">
			<span class="ui-icon ui-icon-close ui-button-icon-primary"></span><span class="ui-button-text">Cancelar</span>
		</button>
	</div>
  <?php if (isset ( $this->_tpl_vars['cedula'] )): ?>
    <input type="hidden" name="cedula" value="<?php echo $this->_tpl_vars['cedula']; ?>
"/>
  <?php elseif (isset ( $this->_tpl_vars['global'] ) && $this->_tpl_vars['global'] == 1): ?>
    <input type="hidden" name="global" value="1"/>
  <?php elseif (isset ( $this->_tpl_vars['cod_curso'] )): ?>
    <input type="hidden" name="cod_curso" value="<?php echo $this->_tpl_vars['cod_curso']; ?>
"/>
  <?php elseif (isset ( $this->_tpl_vars['cod_grupo'] )): ?>
    <input type="hidden" name="cod_grupo" value="<?php echo $this->_tpl_vars['cod_grupo']; ?>
"/>
  <?php endif; ?>
	<div class="clear"></div>
</div>