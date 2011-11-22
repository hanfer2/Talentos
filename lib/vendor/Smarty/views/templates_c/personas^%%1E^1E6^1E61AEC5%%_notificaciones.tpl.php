<?php /* Smarty version 2.6.26, created on 2011-11-21 20:45:46
         compiled from modules/estudiantes_notificaciones/templates/_notificaciones.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'modules/estudiantes_notificaciones/templates/_notificaciones.tpl', 6, false),array('modifier', 'date_format', 'modules/estudiantes_notificaciones/templates/_notificaciones.tpl', 7, false),array('modifier', 'count', 'modules/estudiantes_notificaciones/templates/_notificaciones.tpl', 18, false),)), $this); ?>

<div id="listado-notificaciones" class="accdn ui-corner-all">
 
<?php $_from = $this->_tpl_vars['notificaciones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['notificacion']):
?>
	<div class="notificacion ui-corner-all accdn-item">
		<p class='notificacion-msg'><?php echo ((is_array($_tmp=$this->_tpl_vars['notificacion']['mensaje'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
		<span class="date tiny"><?php echo ((is_array($_tmp=$this->_tpl_vars['notificacion']['fecha_inicio'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</span>
		<?php if ($this->_tpl_vars['notificacion']['fecha_fin']): ?>
		- <span class="date tiny"><?php echo ((is_array($_tmp=$this->_tpl_vars['notificacion']['fecha_fin'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</span>
		<?php endif; ?>
		<div class="ui-toolbar frm-1_5 rtoolbar">
      <a href="#<?php echo $this->_tpl_vars['link_delete']; ?>
-<?php echo $this->_tpl_vars['notificacion']['cod_mensaje']; ?>
" class="link-icon link-delete"><span class="icon"></span> Eliminar</a>
    
		</div>
		<div class="clear"></div>
	</div>
<?php endforeach; endif; unset($_from); ?>
<p id="cantidad-notificaciones" class="accdn-summary"><?php echo count($this->_tpl_vars['notificaciones']); ?>
 notificaciones</p>
</div>
