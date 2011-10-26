<li class='menu'>{link_to name='Mis Datos' controller='personas' action='view' cedula=$smarty.session.user.cedula}</li>
<li class='menu'>{link_to name='Mi Horario' controller='horarios' action='view' cedula=$smarty.session.user.cedula}</li>
<li class='menu'>{link_to name='Mis Cursos' controller='docentes' action='cursos' cedula=$smarty.session.user.cedula}</li>
<li class='menu'><a href="#">Icfes</a>
 <ul>
   <li>{link_to name='Individual' controller='icfes' action='reporteIndividual'}</li>
   <li>{link_to name='Detallado' controller='icfes' action='reporteDetallado'}</li>
   <li>{link_to name='Comparativa' controller='icfes' action='comparativas'}</li>
 </ul>
	
