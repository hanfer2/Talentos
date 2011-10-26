<div class="ui-widget decorated" id='ajax-listadoEgresados'>
 {if (empty($egresados))}
	{include_template file=error message="No se hallaron <strong>Participantes Egresados con Ingreso a Educaci&oacute;n Superior</strong> pertenecientes al PNAT $cod_programa"}
 {else}
		 <h1>
					Listado de Estudiantes Egresados<br/>
					Con Ingreso a Educaci&oacute;n Superior
		 </h1>
		 <h2>Plan {info classname='TPrograma' func='nombre' args=$cod_programa}</h2>
	  <table class="table dataTable" id="table-ListadoIES">
	 	<thead>
	 	 <tr>
	    <th>C&oacute;digo</th>
	 		<th>Doc. Id</th>
	 		<th style="width:5cm">Nombre</th>
	 		<th style="width:3cm">Direcci&oacute;n</th>
	 		<th>Tel&eacute;fonos</th><th title='Correo Electŕ&oacute;nico'>Correo E.</th>
	 		<th class='column-select-filter'>G&eacute;nero</th>
	 		<th>Edad<div style="font-size:8pt;">(A&ntilde;os)</div></th>
	 		<th>Colegio</th>
	 		<th class="column-select-filter long-select" title="Instituci&oacute;n de Educaci&oacute;n Superior">Inst. Educ. Sup.</th>
	 		<th class="column-select-filter long-select">Carrera</th>
	 		<th class="column-select-filter">Ciudad</th>
	 		<th>Fecha<br/>Ingreso</th>
	 	 </tr>
	 	</thead>
	 	<tbody>
	 {foreach from=$egresados item=egresado}
	 	<tr>
	 	  <td>{$egresado.cod_estud}</td>
	 		<td>{persona_url cedula=$egresado.cedula}</td>
			<td>{link_to name=$egresado.fullname|escape action='view' cedula=$egresado.cedula}</td>
	 		<td>{$egresado.direccion|escape}</td>
	 		<td>{join parts="`$egresado.telefono`;`$egresado.tel_celular`"|escape sep=', '}</td>
	 		<td>{join parts="`$egresado.email`;`$egresado.email_2`"|escape sep=', '}</td>
	 		<td>{$egresado.genero|escape}</td>
	 		<td>{$egresado.edad|escape}</td>
	 		<td>{$egresado.nombre_colegio|escape}</td>
			<td>{link_to name=$egresado.nombre_universidad controller='universidades' action='egresados' cod_universidad=$egresado.cod_universidad}</td>
			<td>{link_to name=$egresado.nombre_carrera controller='universidades' action='egresados' cod_universidad=$egresado.cod_universidad cod_carrera=$egresado.cod_carrera}</td>
			<td>{$egresado.nombre_ciudad|escape}</td>
			<td class='date'>{$egresado.fecha_ingreso|date_format}</td>
		</tr>
	 {/foreach}
	 	</tbody>
	  </table>
  {/if}
	<div class="ui-toolbar">
		{link_to name='Registrar Egresados I.E.S.' action='add' cod_programa = $cod_programa}
	</div>
</div>
