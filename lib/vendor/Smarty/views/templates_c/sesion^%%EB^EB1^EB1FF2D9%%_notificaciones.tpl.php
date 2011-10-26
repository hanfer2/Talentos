<?php /* Smarty version 2.6.26, created on 2011-10-03 15:52:16
         compiled from modules/sesion/templates/_notificaciones.tpl */ ?>
<div id="popup-notificaciones">
	<?php $_from = $this->_tpl_vars['notificaciones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mensaje']):
?>
		<div class="notificacion-msg">
			<?php echo $this->_tpl_vars['mensaje']; ?>

		</div>
	<?php endforeach; endif; unset($_from); ?>
</div>