<?php /* Smarty version 2.6.26, created on 2011-11-01 15:00:38
         compiled from templates/_public/includes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_script', 'templates/_public/includes.tpl', 3, false),)), $this); ?>
<link rel="icon" href="./templates/_public/img/favicon.ico"/>

<?php echo smarty_function_include_script(array('file' => 'jquery'), $this);?>

<?php echo smarty_function_include_script(array('file' => 'jquery-ui'), $this);?>

<?php echo smarty_function_include_script(array('file' => 'mootools'), $this);?>


<?php echo smarty_function_include_script(array('file' => 'utils'), $this);?>


<?php echo smarty_function_include_script(array('file' => 'estilo','type' => 'CSS'), $this);?>

<?php echo smarty_function_include_script(array('file' => 'jquery-ui','type' => 'CSS'), $this);?>

<?php echo smarty_function_include_script(array('file' => 'menu','type' => 'CSS'), $this);?>

<?php echo smarty_function_include_script(array('file' => 'dataTable','type' => 'CSS'), $this);?>

