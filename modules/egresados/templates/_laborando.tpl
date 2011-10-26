<div class="ui-widget decorated">
	{if empty($egresados)}
		{include_template file=error message="No se hallaron reportados participantes egresados laborando pertenecientes al PNAT $cod_programa" title="Listado de Egresados Laborando"}
  {else}
  <h1>Listado de Egresados Laborando</h1>
  <h2>{nombre_programa cod_programa = $cod_programa}</h2>
  <table class="table dataTable" id="table-listadoEgresadosLaborando">
    <thead>
      <tr><th>Doc Id</th><th>Nombre</th><th>Ocupaci&oacute;n</th></tr>
    </thead>
    <tbody>
			{foreach from=$egresados item=egresado}
      <tr>
        <td>{persona_url cedula=$egresado.cedula}</td>
				<td>{link_to name=$egresado.fullname action='view' cedula=$egresado.cedula}</td>
				<td>{$egresado.ocupacion}</td>
      </tr>
       {/foreach}
    </tbody>
  </table>
  {/if}
</div>
