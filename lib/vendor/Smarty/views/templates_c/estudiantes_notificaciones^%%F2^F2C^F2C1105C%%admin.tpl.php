<?php /* Smarty version 2.6.26, created on 2011-10-04 16:47:45
         compiled from templates/_public/pages/menu/admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'link_to', 'templates/_public/pages/menu/admin.tpl', 5, false),array('function', 'url_for', 'templates/_public/pages/menu/admin.tpl', 142, false),)), $this); ?>
<!-- MENU ESTUDIANTES -->
<li><a href="javascript:void(0)" class="jm-submenu">Participantes</a>
  <ul>
    <li><span class="jm-title">Usuarios</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Registrar Usuario','controller' => 'personas','action' => 'add'), $this);?>
</li>
    <li><span class="jm-title">Listados</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Listado de Participantes','controller' => 'estudiantes'), $this);?>
</li>
    
    <li><span class="jm-title">Reportes</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Informe General','controller' => 'estudiantes','action' => 'informe'), $this);?>
</li>
    <li><?php echo smarty_function_link_to(array('name' => 'Informe de Inactivos','controller' => 'estudiantes','action' => 'inactivos'), $this);?>
</li>
    <li><?php echo smarty_function_link_to(array('name' => 'Informe de Ingresos/Bajas','controller' => 'estudiantes_movimientos'), $this);?>
</li>
    <?php if ($this->_tpl_vars['siat_user']->isRoot()): ?>
    <li><a href="javascript:void(0)" class="jm-submenu">Informe de Cambios</a>
      <ul>
        <li><span class="jm-title">Registro de Cambios</span></li>
        <li><?php echo smarty_function_link_to(array('name' => 'Cambios de Estado','controller' => 'auditoria','action' => 'view','cambio' => 'estado'), $this);?>
</li>
        <li><?php echo smarty_function_link_to(array('name' => 'Cambios de Doc. Id','controller' => 'auditoria','action' => 'view','cambio' => 'cedula'), $this);?>
</li>
        <li><?php echo smarty_function_link_to(array('name' => 'Cambios de Rol','controller' => 'auditoria','action' => 'view','cambio' => 'rol'), $this);?>
</li>
      </ul>
    </li>
    <?php endif; ?>
    <li><span class="jm-separator"></span></li>
    
    <li><a href="javascript:void(0)" class="jm-submenu">Observaciones</a>
      <ul>
        <li><?php echo smarty_function_link_to(array('name' => 'Listado','controller' => 'observaciones'), $this);?>
</li>
        <li><?php echo smarty_function_link_to(array('name' => 'Consultar','controller' => 'observaciones','action' => 'view'), $this);?>
</li>
      </ul>
    </li>
    
   <!-- MENU EGRESADOS -->
    <li><a href="javascript:void(0)" class="jm-submenu">Egresados</a>
      <ul>
        <li><span class="jm-title">Egresados</span></li>
         <li><?php echo smarty_function_link_to(array('name' => 'Listado de Egresados','controller' => 'egresados'), $this);?>
</li>
        <li><?php echo smarty_function_link_to(array('name' => 'Registrar Egresado','controller' => 'egresados','action' => 'add'), $this);?>
</li>
        <li><?php echo smarty_function_link_to(array('name' => 'Reporte de Egresados','controller' => 'egresados','action' => 'informe'), $this);?>
</li>
        <li><span class="jm-separator"></span></li>
        <li><?php echo smarty_function_link_to(array('name' => 'Universidades','controller' => 'universidades'), $this);?>
</li>
      </ul>
    </li>
  </ul>
</li>
<!-- MENU DOCENTES -->
<li><a href="javascript:void(0)" class="jm-submenu">Docentes</a>
  <ul>
    <li><span class="jm-title">Listados</span></li>
      <li><?php echo smarty_function_link_to(array('name' => 'Listado General','controller' => 'docentes'), $this);?>
</li>
      <li><?php echo smarty_function_link_to(array('name' => 'Listado por Cursos','controller' => 'docentes','action' => 'cursos'), $this);?>
</li>
    <li><span class="jm-separator"></span></li>
      <li><?php echo smarty_function_link_to(array('name' => 'Registrar Docente','controller' => 'personas','action' => 'add','tipo' => @COD_TIPO_DOCENTE), $this);?>
</li>
  </ul>
</li>
<!-- MENU PROGRAMAS -->
<li><a href="javascript:void(0)" class="jm-submenu">PNAT</a>
  <ul>
    <li><span class="jm-title">PNAT</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Listado de PNAT','controller' => 'programas'), $this);?>
</li>
    <li><span class="jm-title">Componentes</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Listado de Componentes','controller' => 'componentes'), $this);?>
</li>
  </ul>
</li>
<!-- MENU CURSOS -->
<li><a href="javascript:void(0)" class="jm-submenu">Cursos</a>
  <ul>
    <li><span class="jm-title">Cursos</span></li>
      <li><?php echo smarty_function_link_to(array('name' => 'Listado de Cursos','controller' => 'cursos'), $this);?>
</li>
    <li><span class="jm-title">Horarios</span></li>
      <li><?php echo smarty_function_link_to(array('name' => 'Listado de Horarios','controller' => 'horarios'), $this);?>
</li>      
      <?php if ($this->_tpl_vars['siat_user']->hasCredential('horario.edit')): ?>
      <li><?php echo smarty_function_link_to(array('name' => 'Configurar Horarios','controller' => 'horarios','action' => 'edit'), $this);?>
</li>
      <?php endif; ?>
    <?php if ($this->_tpl_vars['siat_config']->get('cursos_especiales.enabled')): ?>
    <li><span class="jm-title">Cursos Especiales</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Listado Cursos Especiales','controller' => 'cursos_especiales'), $this);?>
</li>     
    <li><?php echo smarty_function_link_to(array('name' => 'Editar Horarios Especiales','controller' => 'horarios','action' => 'edit','t' => 'ce'), $this);?>
</li>   
    <?php endif; ?>
    <?php if ($this->_tpl_vars['siat_user']->hasCredential('horario.edit')): ?>
    <li><span class="jm-title">Salones</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Gestion de Salones','controller' => 'salones'), $this);?>
</li> 
    <?php endif; ?>
  </ul>
</li>
<!-- MENU ICFES-->
<li ><a href="javascript:void(0)" class="jm-submenu">Icfes</a>
  <ul>
    <li><span class="jm-title">Reportes</span></li>
      <li><?php echo smarty_function_link_to(array('name' => 'Reporte Individual','controller' => 'icfes','action' => 'reporteIndividual'), $this);?>
</li>
      <li><?php echo smarty_function_link_to(array('name' => 'Reporte General','controller' => 'icfes','action' => 'reporteDetallado'), $this);?>
</li>
      <li><?php echo smarty_function_link_to(array('name' => 'Comparativas entre Pruebas','controller' => 'icfes','action' => 'comparativas'), $this);?>
</li>
      <li><?php echo smarty_function_link_to(array('name' => 'Puntajes Icfes','controller' => 'icfes','action' => 'listado_icfes'), $this);?>
</li>
      <?php if (is_root_login ( )): ?>
      <li><span class="jm-title">Digitadores</span></li>      
      <li><?php echo smarty_function_link_to(array('name' => 'Registrar Icfes','controller' => 'icfes','action' => 'add'), $this);?>
</li>
      <li><?php echo smarty_function_link_to(array('name' => 'Reporte Digitadores','controller' => 'digita_icfes','action' => 'reporte'), $this);?>
</li>
      <?php endif; ?>
      <?php if (is_super_admin_login ( )): ?>
      <li><span class="jm-title">Pruebas</span></li>
      <li><?php echo smarty_function_link_to(array('name' => 'Listado de Pruebas','controller' => 'i_pruebas'), $this);?>
</li>
        <?php if ($this->_tpl_vars['siat_user']->hasCredential('i_cuestionarios.edit')): ?>
        <li><a href="javascript:void(0)" class="jm-submenu">Cuestionarios</a>
          <ul>
            <li><span class="jm-title">Cuestionarios</span></li>
            <li><?php echo smarty_function_link_to(array('name' => 'Consultar Cuestionario','controller' => 'i_cuestionarios','action' => 'view'), $this);?>
</li>
            <li><?php echo smarty_function_link_to(array('name' => 'Registrar Cuestionario','controller' => 'i_cuestionarios','action' => 'add'), $this);?>
</li>
            <li><?php echo smarty_function_link_to(array('name' => 'Reporte de Cuestionarios','controller' => 'i_cuestionarios','action' => 'informe'), $this);?>
</li>
            <li><span class="jm-title">Ingreso de Notas</span></li>
            <li><?php echo smarty_function_link_to(array('name' => 'Diligenciar Cuestionario','controller' => 'i_cuestionarios_estudiantes','action' => 'add'), $this);?>
</li>
            <li><?php echo smarty_function_link_to(array('name' => 'Revisar Cuestionarios','controller' => 'i_cuestionarios','action' => 'check','disabled' => 'disabled'), $this);?>
</li>
          </ul>
        </li>
        <?php endif; ?>
    <?php endif; ?>
    
  </ul>
</li>
<!-- MENU ASISTENCIA-->
<li ><a href="javascript:void(0)" class="jm-submenu">Asistencias</a>
  <ul>
    <?php if (is_admin_login ( )): ?>
      <li><?php echo smarty_function_link_to(array('name' => 'Registrar Asistencia','controller' => 'asistencias','action' => 'registrar'), $this);?>
</li>
      <?php if ($this->_tpl_vars['siat_config']->get('cursos_especiales.enabled')): ?>
        <li><?php echo smarty_function_link_to(array('name' => 'Registrar Asistencias Cursos Especiales','controller' => 'asistencias','action' => 'registrar','t' => 'ce'), $this);?>
</li>
      <?php endif; ?>
    <?php endif; ?>
    <li><span class="jm-title">Reportes</span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Reporte Individual','controller' => 'asistencias','action' => 'view'), $this);?>
</li>
    <li><?php echo smarty_function_link_to(array('name' => 'Reporte por Grupo','controller' => 'asistencias','action' => 'index','cod_programa' => '003'), $this);?>
</li>
    <li><?php echo smarty_function_link_to(array('name' => 'Reporte por Cursos','controller' => 'asistencias','action' => 'general','cod_curso' => ''), $this);?>
</li>
    <li><?php echo smarty_function_link_to(array('name' => 'Reporte General','controller' => 'asistencias','action' => 'general'), $this);?>
</li>
    <li><span class='jm-separator'></span></li>
    <li><?php echo smarty_function_link_to(array('name' => 'Formatos de Asistencia','controller' => 'asistencias','action' => 'formatos'), $this);?>
</li>
    
  </ul>
</li>

<?php if ($this->_tpl_vars['siat_user']->isRoot()): ?>
  <li class="jm-rightItem jm-iconItem">
    <a href="javascript:void(0)"><span class="ui-icon ui-icon-carat-1-s"></span></a>
    <ul>
      <li><a href="<?php echo smarty_function_url_for(array('controller' => 'configuraciones'), $this);?>
" title="Opciones"><span class="ui-icon ui-icon-wrench"></span>Opciones</a></li>
    </ul>
  </li>
<?php endif; ?>