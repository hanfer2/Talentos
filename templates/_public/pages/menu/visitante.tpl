<!-- MENU ESTUDIANTES -->
<li><a href="javascript:void(0)" class="jm-submenu">Participantes</a>
  <ul>
    <li><span class="jm-title">Listados</span></li>
    <li>{link_to name='Listado de Participantes' controller='estudiantes' cod_programa='001' st=$smarty.const.COD_ESTADO_EGRESADO}</li>
    
    <li><span class="jm-title">Reportes</span></li>
    <li>{link_to name='Informe General' controller='estudiantes' action='informe' cod_programa='001'}</li>
    <li>{link_to name='Informe de Inactivos' controller='estudiantes' action='inactivos' cod_programa='001'}</li>
    <li><span class="jm-separator"></span></li>
    
    <li><a href="javascript:void(0)" class="jm-submenu">Observaciones</a>
      <ul>
        <li>{link_to name='Listado' controller=observaciones cod_programa='001'}</li>
        <li>{link_to name='Consultar' controller=observaciones action=view}</li>
      </ul>
    </li>
  </ul>
</li>
<li><a href="javascript:void(0)" class="jm-submenu">Egresados</a>
  <ul>
    <li><span class="jm-title">Egresados</span></li>
    <li>{link_to name='Listado de Egresados' controller='egresados'}</li>
    <li>{link_to name='Reporte de Egresados' controller='egresados' action='informe' cod_programa='001'}</li>
  </ul>
</li>
<!-- MENU DOCENTES -->
<li><a href="javascript:void(0)" class="jm-submenu">Docentes</a>
  <ul>
    <li><span class="jm-title">Listados</span></li>
    <li>{link_to name='Listado General' controller='docentes' cod_programa='001'}</li>
    <li>{link_to name='Listado por Cursos' controller='docentes' action='cursos'}</li>
  </ul>
</li>
<!-- MENU PROGRAMAS -->
<li>{link_to name='PNAT' controller='programas' action=view cod_programa='001'}</li>

<!-- MENU ICFES-->
<li ><a href="javascript:void(0)" class="jm-submenu">Icfes</a>
  <ul>
    <li><span class="jm-title">Reportes</span></li>
      <li>{link_to name='Reporte Individual' controller='icfes' action='reporteIndividual'}</li>
      <li>{link_to name='Reporte General' controller='icfes' action='reporteDetallado'}</li>
      <li>{link_to name='Comparativas entre Pruebas' controller='icfes' action='comparativas' cod_programa='001'}</li>
  </ul>
</li>
