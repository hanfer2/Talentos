<?php /* Smarty version 2.6.26, created on 2011-09-04 00:45:23
         compiled from templates/_public/pages/menu/visitante.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', 'templates/_public/pages/menu/visitante.tpl', 5, false),)), $this); ?>
<!-- MENU ESTUDIANTES -->
<li><a href="javascript:void(0)" class="jm-submenu">Participantes</a>
  <ul>
    <li><span class="jm-title">Listados</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Listado de Participantes','controller' => 'estudiantes','cod_programa' => '001','st' => @COD_ESTADO_EGRESADO), $this);?>
</li>
    
    <li><span class="jm-title">Reportes</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Informe General','controller' => 'estudiantes','action' => 'informe','cod_programa' => '001'), $this);?>
</li>
    <li><?php echo smarty_function_link_to(array('name' => 'Informe de Inactivos','controller' => 'estudiantes','action' => 'inactivos','cod_programa' => '001'), $this);?>
</li>
    <li><span class="jm-separator"></span></li>
    
    <li><a href="javascript:void(0)" class="jm-submenu">Observaciones</a>
      <ul>
        <li><?php echo smarty_function_link_to(array('name' => 'Listado','controller' => 'observaciones','cod_programa' => '001'), $this);?>
</li>
        <li><?php echo smarty_function_link_to(array('name' => 'Consultar','controller' => 'observaciones','action' => 'view'), $this);?>
</li>
      </ul>
    </li>
  </ul>
</li>
<li><a href="javascript:void(0)" class="jm-submenu">Egresados</a>
  <ul>
    <li><span class="jm-title">Egresados</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Listado de Egresados','controller' => 'egresados'), $this);?>
</li>
    <li><?php echo smarty_function_link_to(array('name' => 'Reporte de Egresados','controller' => 'egresados','action' => 'informe','cod_programa' => '001'), $this);?>
</li>
  </ul>
</li>
<!-- MENU DOCENTES -->
<li><a href="javascript:void(0)" class="jm-submenu">Docentes</a>
  <ul>
    <li><span class="jm-title">Listados</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Listado General','controller' => 'docentes','cod_programa' => '001'), $this);?>
</li>
    <li><?php echo smarty_function_link_to(array('name' => 'Listado por Cursos','controller' => 'docentes','action' => 'cursos'), $this);?>
</li>
  </ul>
</li>
<!-- MENU PROGRAMAS -->
<li><?php echo smarty_function_link_to(array('name' => 'PNAT','controller' => 'programas','action' => 'view','cod_programa' => '001'), $this);?>
</li>

<!-- MENU ICFES-->
<li ><a href="javascript:void(0)" class="jm-submenu">Icfes</a>
  <ul>
    <li><span class="jm-title">Reportes</span></li>
      <li><?php echo smarty_function_link_to(array('name' => 'Reporte Individual','controller' => 'icfes','action' => 'reporteIndividual'), $this);?>
</li>
      <li><?php echo smarty_function_link_to(array('name' => 'Reporte General','controller' => 'icfes','action' => 'reporteDetallado'), $this);?>
</li>
      <li><?php echo smarty_function_link_to(array('name' => 'Comparativas entre Pruebas','controller' => 'icfes','action' => 'comparativas','cod_programa' => '001'), $this);?>
</li>
  </ul>
</li>