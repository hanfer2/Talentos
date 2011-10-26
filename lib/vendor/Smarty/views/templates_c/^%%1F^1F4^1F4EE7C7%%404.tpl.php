<?php /* Smarty version 2.6.26, created on 2011-07-06 16:48:54
         compiled from ./templates/_public/pages/404.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_image', './templates/_public/pages/404.tpl', 3, false),)), $this); ?>
<div class='ui-widget decorated error-page-panel error-404'>
	<h1 class="page-error-title">Error 404 - P&aacute;gina No Encontrada</h1>
	<?php echo smarty_function_html_image(array('file' => '404.png'), $this);?>

	<div class="err-msg"><?php echo $this->_tpl_vars['message']; ?>
</div>
	<div class="ui-toolbar"><span class="ui-icon ui-icon-arrowthick-1-w error-icon inline-icon"></span><a href="javascript:history.back(1)">Volver</a></div>
</div> 