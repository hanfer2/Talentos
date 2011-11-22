<?php /* Smarty version 2.6.26, created on 2011-11-21 20:45:51
         compiled from templates/_public/pages/menu/estudiante.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', 'templates/_public/pages/menu/estudiante.tpl', 1, false),)), $this); ?>
<li class='menu'><?php echo smarty_function_link_to(array('name' => 'Mis Datos','controller' => 'personas','action' => 'view','cedula' => $_SESSION['user']['cedula']), $this);?>
</li>
<li class='menu'><?php echo smarty_function_link_to(array('name' => 'Mi Horario','controller' => 'horarios','action' => 'view','cedula' => $_SESSION['user']['cedula']), $this);?>
</li>
<li class='menu'><?php echo smarty_function_link_to(array('name' => 'Mi Asistencia','controller' => 'asistencias','action' => 'view','cedula' => $_SESSION['user']['cedula']), $this);?>
</li>
<li class='menu'><?php echo smarty_function_link_to(array('name' => 'Icfes','controller' => 'icfes','action' => 'reporteIndividual','cedula' => $_SESSION['user']['cedula']), $this);?>
</li>