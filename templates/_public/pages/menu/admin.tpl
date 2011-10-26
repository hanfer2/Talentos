<!-- MENU ESTUDIANTES -->
<li><a href="javascript:void(0)" class="jm-submenu">Participantes</a>
  <ul>
    <li><span class="jm-title">Usuarios</span></li>
    <li>{link_to name='Registrar Usuario' controller='personas' action='add'}</li>
    <li><span class="jm-title">Listados</span></li>
    <li>{link_to name='Listado de Participantes' controller='estudiantes'}</li>
    
    <li><span class="jm-title">Reportes</span></li>
    <li>{link_to name='Informe General' controller='estudiantes' action='informe'}</li>
    <li>{link_to name='Informe de Inactivos' controller='estudiantes' action='inactivos'}</li>
    <li>{link_to name='Informe de Ingresos/Bajas' controller='estudiantes_movimientos' }</li>
    {if $siat_user->isRoot()}
    <li><a href="javascript:void(0)" class="jm-submenu">Informe de Cambios</a>
      <ul>
        <li><span class="jm-title">Registro de Cambios</span></li>
        <li>{link_to name='Cambios de Estado' controller='auditoria' action='view' cambio='estado' }</li>
        <li>{link_to name='Cambios de Doc. Id' controller='auditoria' action='view' cambio='cedula'}</li>
        <li>{link_to name='Cambios de Rol' controller='auditoria' action='view' cambio='rol'}</li>
      </ul>
    </li>
    {/if}
    <li><span class="jm-separator"></span></li>
    
    <li><a href="javascript:void(0)" class="jm-submenu">Observaciones</a>
      <ul>
        <li>{link_to name='Listado' controller=observaciones}</li>
        <li>{link_to name='Consultar' controller=observaciones action=view}</li>
      </ul>
    </li>
    
   <!-- MENU EGRESADOS -->
    <li><a href="javascript:void(0)" class="jm-submenu">Egresados</a>
      <ul>
        <li><span class="jm-title">Egresados</span></li>
         <li>{link_to name='Listado de Egresados' controller='egresados'}</li>
        <li>{link_to name='Registrar Egresado' controller='egresados' action='add'}</li>
        <li>{link_to name='Reporte de Egresados' controller='egresados' action='informe'}</li>
        <li><span class="jm-separator"></span></li>
        <li>{link_to name='Universidades' controller='universidades'}</li>
      </ul>
    </li>
  </ul>
</li>
<!-- MENU DOCENTES -->
<li><a href="javascript:void(0)" class="jm-submenu">Docentes</a>
  <ul>
    <li><span class="jm-title">Listados</span></li>
      <li>{link_to name='Listado General' controller='docentes'}</li>
      <li>{link_to name='Listado por Cursos' controller='docentes' action='cursos'}</li>
    <li><span class="jm-separator"></span></li>
      <li>{link_to name='Registrar Docente' controller='personas' action='add' tipo=$smarty.const.COD_TIPO_DOCENTE}</li>
  </ul>
</li>
<!-- MENU PROGRAMAS -->
<li><a href="javascript:void(0)" class="jm-submenu">PNAT</a>
  <ul>
    <li><span class="jm-title">PNAT</span></li>
    <li>{link_to name='Listado de PNAT' controller='programas'}</li>
    <li><span class="jm-title">Componentes</span></li>
    <li>{link_to name='Listado de Componentes' controller='componentes'}</li>
  </ul>
</li>
<!-- MENU CURSOS -->
<li><a href="javascript:void(0)" class="jm-submenu">Cursos</a>
  <ul>
    <li><span class="jm-title">Cursos</span></li>
      <li>{link_to name='Listado de Cursos' controller='cursos'}</li>
    <li><span class="jm-title">Horarios</span></li>
      <li>{link_to name='Listado de Horarios' controller='horarios'}</li>      
      {if $siat_user->hasCredential('horario.edit')}
      <li>{link_to name='Configurar Horarios' controller='horarios' action='edit'}</li>
      {/if}
    {if $siat_config->get('cursos_especiales.enabled')}
    <li><span class="jm-title">Cursos Especiales</span></li>
    <li>{link_to name='Listado Cursos Especiales' controller='cursos_especiales'}</li>     
    <li>{link_to name='Editar Horarios Especiales' controller='horarios' action=edit t=ce}</li>   
    {/if}
    {if $siat_user->hasCredential('horario.edit')}
    <li><span class="jm-title">Salones</span></li>
    <li>{link_to name='Gestion de Salones' controller='salones'}</li> 
    {/if}
  </ul>
</li>
<!-- MENU ICFES-->
<li ><a href="javascript:void(0)" class="jm-submenu">Icfes</a>
  <ul>
    <li><span class="jm-title">Reportes</span></li>
      <li>{link_to name='Reporte Individual' controller='icfes' action='reporteIndividual'}</li>
      <li>{link_to name='Reporte General' controller='icfes' action='reporteDetallado'}</li>
      <li>{link_to name='Comparativas entre Pruebas' controller='icfes' action='comparativas'}</li>
      <li>{link_to name='Puntajes Icfes' controller='icfes' action='listado_icfes'}</li>
      {if is_root_login()}
      <li><span class="jm-title">Digitadores</span></li>      
      <li>{link_to name='Registrar Icfes' controller='icfes' action='add'}</li>
      <li>{link_to name='Reporte Digitadores' controller='digita_icfes' action='reporte'}</li>
      {/if}
      {if is_super_admin_login()}
      <li><span class="jm-title">Pruebas</span></li>
      <li>{link_to name="Listado de Pruebas" controller=i_pruebas}</li>
        {if $siat_user->hasCredential('i_cuestionarios.edit')}
        <li><a href="javascript:void(0)" class="jm-submenu">Cuestionarios</a>
          <ul>
            <li><span class="jm-title">Cuestionarios</span></li>
            <li>{link_to name="Consultar Cuestionario" controller=i_cuestionarios action=view}</li>
            <li>{link_to name="Registrar Cuestionario" controller=i_cuestionarios action=add}</li>
            <li>{link_to name="Reporte de Cuestionarios" controller=i_cuestionarios action=informe}</li>
            <li><span class="jm-title">Ingreso de Notas</span></li>
            <li>{link_to name="Diligenciar Cuestionario" controller=i_cuestionarios_estudiantes action=add}</li>
            <li>{link_to name="Revisar Cuestionarios" controller=i_cuestionarios action=check disabled=disabled}</li>
          </ul>
        </li>
        {/if}
    {/if}
    
  </ul>
</li>
<!-- MENU ASISTENCIA-->
<li ><a href="javascript:void(0)" class="jm-submenu">Asistencias</a>
  <ul>
    {if is_admin_login()}
      <li>{link_to name='Registrar Asistencia' controller='asistencias' action='registrar'}</li>
      {if $siat_config->get('cursos_especiales.enabled')}
        <li>{link_to name='Registrar Asistencias Cursos Especiales' controller='asistencias' action=registrar t=ce}</li>
      {/if}
    {/if}
    <li><span class="jm-title">Reportes</span></li>
    <li>{link_to name='Reporte Individual' controller='asistencias' action='view' }</li>
    <li>{link_to name='Reporte por Grupo' controller='asistencias' action='index' cod_programa='003'}</li>
      <li>{link_to name='Reporte por Componentes' controller='asistencias' action='componentes' cod_programa='003'}</li>
    <li>{link_to name='Reporte por Cursos' controller='asistencias' action='general' cod_curso=''}</li>
    <li>{link_to name='Reporte General' controller='asistencias' action='general'}</li>
    <li><span class='jm-separator'></span></li>
    <li>{link_to name='Formatos de Asistencia' controller='asistencias' action='formatos'}</li>
    
  </ul>
</li>

{if $siat_user->isRoot()}
  <li class="jm-rightItem jm-iconItem">
    <a href="javascript:void(0)"><span class="ui-icon ui-icon-carat-1-s"></span></a>
    <ul>
      <li><a href="{url_for controller='configuraciones'}" title="Opciones"><span class="ui-icon ui-icon-wrench"></span>Opciones</a></li>
    </ul>
  </li>
{/if}
