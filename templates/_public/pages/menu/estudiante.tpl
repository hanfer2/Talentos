<li class='menu'>{link_to name='Mis Datos' controller='personas' action='view' cedula=$smarty.session.user.cedula}</li>
<li class='menu'>{link_to name='Mi Horario' controller='horarios' action='view' cedula=$smarty.session.user.cedula}</li>
<li class='menu'>{link_to name='Mi Asistencia' controller='asistencias' action='view' cedula=$smarty.session.user.cedula}</li>
<li class='menu'>{link_to name='Icfes' controller='icfes' action='reporteIndividual' cedula=$smarty.session.user.cedula}</li>
