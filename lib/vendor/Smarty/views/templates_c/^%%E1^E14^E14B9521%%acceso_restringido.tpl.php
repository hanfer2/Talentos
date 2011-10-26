<?php /* Smarty version 2.6.26, created on 2011-09-11 22:03:19
         compiled from ./templates/_public/pages/acceso_restringido.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_image', './templates/_public/pages/acceso_restringido.tpl', 3, false),array('function', 'link_to', './templates/_public/pages/acceso_restringido.tpl', 7, false),)), $this); ?>
<div class='decorated error-page-panel'>
  <h1>USUARIO NO AUTORIZADO</h1>
  <?php echo smarty_function_html_image(array('file' => 'warning.png'), $this);?>

  <p class="err-msg">Usted no está autorizado para acceder a esta aplicación</p>
  <?php if (! is_user_login ( )): ?>
  <div class="ui-toolbar">
		<?php echo smarty_function_link_to(array('name' => 'Ingresar','action' => 'login'), $this);?>

  </div>
  <?php endif; ?>
</div>