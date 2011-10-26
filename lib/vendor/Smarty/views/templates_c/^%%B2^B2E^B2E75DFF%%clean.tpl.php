<?php /* Smarty version 2.6.26, created on 2011-07-25 09:52:37
         compiled from templates/_layouts/clean.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_script', 'templates/_layouts/clean.tpl', 10, false),array('function', 'include_public', 'templates/_layouts/clean.tpl', 28, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo @CHARSET; ?>
"/>
    <meta name="Autor" content="Dintev"/>
    
    <link rel="icon" href="./templates/_public/img/favicon.ico"/>
    
    <?php echo smarty_function_include_script(array('file' => 'jquery'), $this);?>

		<?php echo smarty_function_include_script(array('file' => 'jquery-ui'), $this);?>


		<?php echo smarty_function_include_script(array('file' => 'estilo','type' => 'CSS'), $this);?>

		<?php echo smarty_function_include_script(array('file' => 'jquery-ui','type' => 'CSS'), $this);?>

		<?php echo smarty_function_include_script(array('file' => 'menu','type' => 'CSS'), $this);?>


    <title><?php echo $this->_config[0]['vars']['PREFIX_PAGETITLE']; ?>
 <?php echo $this->_tpl_vars['pageTitle']; ?>
</title>
  </head>
  <script type="text/javascript">
  <?php echo '
  jQuery(function($){
		$("a.jm-submenu").append("<span class=\'ui-icon jm-icon\'/>")
	})
  '; ?>

  </script>
  <body>
  <div class="non-printable" id='header-section-layout'>
    <?php echo smarty_function_include_public(array('file' => 'header'), $this);?>

    <?php if (is_user_login ( )): ?>
      <?php echo smarty_function_include_public(array('file' => 'menu'), $this);?>

    <?php else: ?>
      <div style="height:38px; margin-bottom:5mm"></div>
    <?php endif; ?>
  </div>
  <div id='main-section-layout'>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['content_for_layout']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  </div>
  <div class="non-printable" id='foot-section-layout'>
  <?php echo smarty_function_include_public(array('file' => 'footer'), $this);?>

  </div>
</body>
</html>