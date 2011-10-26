<?php /* Smarty version 2.6.26, created on 2011-07-06 16:42:14
         compiled from templates/_public/footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url_for', 'templates/_public/footer.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['toolbar'] !== false): ?>
<div class='ui-toolbar' id='toolbar-externalLinks'>
	<a href="<?php echo smarty_function_url_for(array('controller' => 'sesion'), $this);?>
">Inicio</a> | 
	<a href="http://talentos.univalle.edu.co">Portal Talentos</a> | 
	<a href="https://proxse13.univalle.edu.co/talentos/moodle/">Campus Virtual</a>
</div>
<?php endif; ?>
<div id="footer-panel">
  <div>| Direcci&oacute;n de Nuevas Tecnología y Educaci&oacute;n Virtual | NIT: 890.399.010-6 |
    Tel&eacute;fonos: (572) 318 2631 - 318 2680 - 318 2690 - 318 2602. - Fax 318 2605 |<br/>
    Edificio 317 - Oficina 1005 (Antiguo CREE), A.A. 25360. Ciudad Universitaria Mel&eacute;ndez | Cali - Colombia
  </div><br/>
</div>