{if !isset($cod_prueba)}
	{include_template file="programas_icfes" title="Reporte Icfes Estudiantes"}
	<div class='ajax-response' id="ajax-reporteIcfesEstudiantes"></div>
{else}
	<div class='ui-widget decorated'>
		<h1>Listado de Puntajes Icfes</h1>
		<h2>{$nombre_prueba}</h2>
		<table class="table dataTable" id="table-listadoIcfes">
		<thead>
			<tr>
				<th >Doc. Id.</th>
        <th >Nombre</th>
        <th class="column-hidden" >Email</th>
        <th class="column-hidden">Tel&eacute;fono</th>
				<th >Registro Icfes</th>
				<th >Lenguaje</th>				
        <th >Matem&aacute;ticas</th>				
        <th >Sociales</th>				
        <th >Filosof&iacute;a</th>				
        <th >Biolog&iacute;a</th>				
        <th >Qu&iacute;mica</th>				
        <th >F&iacute;sica</th>				
        <th >Idioma</th>				
        <th title="Interdisciplinar" >Interdisc.</th>				
        <th class="total">Promedio</th>
			</tr>
			</thead>
			<tbody>
			{foreach from=$icfes item=l_icfes}
				<tr>
					<td>{persona_url cedula=$l_icfes.cedula}</td>
					<td>{$l_icfes.nombrecompleto|escape}</td>
          <td>{$l_icfes.email}</td>
          <td>{$l_icfes.telefono}</td>
          <td>{$l_icfes.num_registro_icfes}</td>
					<td>{$l_icfes.lenguaje}</td>          
          <td>{$l_icfes.matematica}</td>          
          <td>{$l_icfes.sociales}</td>          
          <td>{$l_icfes.filosofia}</td>          
          <td>{$l_icfes.biologia}</td>          
          <td>{$l_icfes.quimica}</td>          
          <td>{$l_icfes.fisica}</td>          
          <td>{$l_icfes.idioma|number_format:2}</td>         
          <td>{$l_icfes.interdisciplinar}</td>          
          <td class="total">{math equation="(l+m+s+f+b+q+c+i+d)/9" format="%.2f" l=$l_icfes.lenguaje m=$l_icfes.matematica s=$l_icfes.sociales f=$l_icfes.filosofia q=$l_icfes.quimica c=$l_icfes.fisica i=$l_icfes.idioma d=$l_icfes.interdisciplinar}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
		<div>		
{/if}
