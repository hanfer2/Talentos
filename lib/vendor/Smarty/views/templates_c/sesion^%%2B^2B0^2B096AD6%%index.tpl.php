<?php /* Smarty version 2.6.26, created on 2011-11-21 20:47:56
         compiled from ./modules/sesion/templates//index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_image', './modules/sesion/templates//index.tpl', 2, false),array('function', 'include_partial', './modules/sesion/templates//index.tpl', 5, false),)), $this); ?>
<div style="margin: 1cm auto; text-align: center;" >
  <?php echo smarty_function_html_image(array('file' => 'PortadaTalentos.jpg','alt' => 'portada Talentos','width' => 800,'height' => 600), $this);?>

</div>
<?php if (! empty ( $this->_tpl_vars['notificaciones'] )): ?>
	<?php echo smarty_function_include_partial(array('file' => '_notificaciones','notificaciones' => $this->_tpl_vars['notificaciones']), $this);?>

<?php endif; ?>