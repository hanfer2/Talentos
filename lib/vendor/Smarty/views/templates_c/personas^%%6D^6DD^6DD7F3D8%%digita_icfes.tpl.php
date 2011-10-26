<?php /* Smarty version 2.6.26, created on 2011-09-23 10:42:28
         compiled from templates/_public/pages/menu/digita_icfes.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', 'templates/_public/pages/menu/digita_icfes.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['siat_menu']->pruebaActiva != null): ?>
  <?php if ($this->_tpl_vars['siat_menu']->getTipoPruebaActiva() == @I_TIPO_SIMULACRO): ?>
    <li class="menu"><?php echo smarty_function_link_to(array('name' => 'Verificar Simulacro','controler' => 'i_cuestionarios_estudiantes','action' => 'view','cod_prueba' => $this->_tpl_vars['siat_menu']->pruebaActiva), $this);?>
</li>
    <li class="menu"><?php echo smarty_function_link_to(array('name' => 'Corregir Simulacro','controler' => 'i_cuestionarios_estudiantes','action' => 'edit'), $this);?>
</li>
  <?php else: ?>
    <li class="menu"><?php echo smarty_function_link_to(array('name' => 'Registrar Promedios Icfes','cod_prueba' => $this->_tpl_vars['siat_menu']->pruebaActiva,'controller' => 'icfes','action' => 'add'), $this);?>
</li>
  <?php endif; ?>
<?php endif; ?>