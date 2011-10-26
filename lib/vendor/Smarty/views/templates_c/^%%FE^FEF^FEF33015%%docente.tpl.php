<?php /* Smarty version 2.6.26, created on 2011-09-05 14:36:09
         compiled from templates/_public/pages/menu/docente.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', 'templates/_public/pages/menu/docente.tpl', 1, false),)), $this); ?>
<li class='menu'><?php echo smarty_function_link_to(array('name' => 'Mis Datos','controller' => 'personas','action' => 'view','cedula' => $_SESSION['user']['cedula']), $this);?>
</li>
<li class='menu'><?php echo smarty_function_link_to(array('name' => 'Mi Horario','controller' => 'horarios','action' => 'view','cedula' => $_SESSION['user']['cedula']), $this);?>
</li>
<li class='menu'><?php echo smarty_function_link_to(array('name' => 'Mis Cursos','controller' => 'docentes','action' => 'cursos','cedula' => $_SESSION['user']['cedula']), $this);?>
</li>
<li class='menu'><a href="#">Icfes</a>
 <ul>
   <li><?php echo smarty_function_link_to(array('name' => 'Individual','controller' => 'icfes','action' => 'reporteIndividual'), $this);?>
</li>
   <li><?php echo smarty_function_link_to(array('name' => 'Detallado','controller' => 'icfes','action' => 'reporteDetallado'), $this);?>
</li>
   <li><?php echo smarty_function_link_to(array('name' => 'Comparativa','controller' => 'icfes','action' => 'comparativas'), $this);?>
</li>
 </ul>
	