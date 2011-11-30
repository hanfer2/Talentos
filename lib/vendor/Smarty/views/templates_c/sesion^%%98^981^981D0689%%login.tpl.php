<?php /* Smarty version 2.6.26, created on 2011-11-30 14:09:25
         compiled from templates/_layouts/login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_script', 'templates/_layouts/login.tpl', 8, false),array('function', 'include_public', 'templates/_layouts/login.tpl', 18, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_config[0]['vars']['charset']; ?>
"/>
    <meta name="Autor" content="Dintev"/>
    <link rel="icon" href="./templates/_public/img/favicon.ico"/>
    <?php echo smarty_function_include_script(array('file' => 'jquery','type' => 'js'), $this);?>

    <?php echo smarty_function_include_script(array('file' => 'jquery-ui','type' => 'js'), $this);?>

    <?php echo smarty_function_include_script(array('file' => 'utils','type' => 'js'), $this);?>

    <?php echo smarty_function_include_script(array('file' => 'login','type' => 'js','module' => 'sesion'), $this);?>

    
    <?php echo smarty_function_include_script(array('file' => 'estilo','type' => 'css'), $this);?>

    <?php echo smarty_function_include_script(array('file' => 'sesion_login','type' => 'css','module' => 'sesion'), $this);?>

    <title> Plan de Nivelaci&oacute;n Acad&eacute;mica</title>
</head>
<body id='login-template' >
  <?php echo smarty_function_include_public(array('file' => 'header'), $this);?>

  <hr/>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['content_for_layout']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div id='footer-panel' >
    <div id="footer-address"><?php echo $this->_config[0]['vars']['FOOTER_TEXT']; ?>
</div><br/>
    <p class="w3c-validator">
      <a href="http://validator.w3.org/check?uri=referer">
        <img src="http://www.w3.org/Icons/valid-xhtml10"
              alt="Valid XHTML 1.0 Strict" height="31" width="88" />
      </a>
    </p>
  </div>
	<?php if (! is_blank ( $this->_tpl_vars['message'] )): ?>
	<script type='text/javascript'>
		jAlert("<?php echo $this->_tpl_vars['message']; ?>
", "Error");
	</script>
	<?php endif; ?>
</body>
		<?php if (date ( n ) == 12): ?>
			<?php echo smarty_function_include_script(array('file' => 'jsnow'), $this);?>
	
    <?php endif; ?>
</html>
