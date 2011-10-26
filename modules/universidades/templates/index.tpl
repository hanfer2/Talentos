{if empty($universidades)}
	{include file=#EMPTY_RESULTS:FILE#}
{else}
<div class="ui-widget decorated">
  <h1>Listado de Universidades</h1>
  <table class="table dataTable" id="table-listadoUniversidades">
    <thead>
      <tr>
				<th>C&oacute;digo</th>
				<th class='column-select-filter'>Nombre</th>
				<th class='column-select-filter'>Ciudad</th>
			</tr>
    </thead>
    <tbody>
		{foreach from=$universidades item=universidad}
      <tr>
				<td>{link_to name=$universidad.codigo action='carreras' cod_universidad=$universidad.codigo cod_ciudad=$universidad.cod_ciudad}</td>
				<td>{link_to name=$universidad.nombre action='egresados' cod_universidad=$universidad.codigo}</td>
        <td>{$universidad.nombre_ciudad|escape}</td>
      </tr>
     {/foreach}
    </tbody>
  </table>
    <div class="ui-toolbar">
		{link_to name='Registrar Universidad' action='add'} | 
		{link_to name='Listado de Egresados' controller='egresados'} | 
		{link_to name='Registrar Egresado' controller='egresados' action='add'}  
  </div>
{/if}
</div>
