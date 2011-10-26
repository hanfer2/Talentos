{capture assign=links}
	{if is_super_admin_login()}
	<a href="#" id="link-registrarNuevoPlan">Registrar Nuevo PNAT</a>
	{/if}
{/capture}
{if empty($programas)}
	{include file=#EMPTY_RESULTS_FILE# links=$links}
{else}
<div class="ui-widget decorated">
  <h1>Listado de {#PNAT#}</h1>
  <table class="table dataTable">
    <thead>
      <tr><th rowspan="2" >C&oacute;digo</th><th rowspan="2">Nombre</th>
        <th colspan="2">1r Semestre</th><th colspan="2">2r Semestre</th>
        <th rowspan="2">Activo</th>
      </tr>
      <tr>
        <th>Fecha Inicio</th><th>Fecha Cierre</th>
        <th>Fecha Inicio</th><th>Fecha Cierre</th>
      </tr>
    </thead>
    <tbody>
			{foreach from=$programas item=programa}
      <tr>
        <td>{$programa.codigo}</td>
        <td>{link_to name=$programa.nombre action='view' cod_programa=$programa.codigo}</td>
        <td class="date">{$programa.fecha_inicio_1|date_format}</td>
        <td class="date">{$programa.fecha_cierre_1|date_format}</td>
        <td class="date">{$programa.fecha_inicio_2|date_format}</td>
        <td class="date">{$programa.fecha_cierre_2|date_format}</td>
        <td>{if date_compare($programa.fecha_cierre_2, date("Y-M-D")) lt 0 and date_contains($programa.fecha_inicio_1, $programa.fecha_cierre_2)}&#10004;{else}&#10008;{/if}</td>
      </tr>
      {/foreach}
    </tbody>
  </table>
  <div class="ui-toolbar">{$links}</div>
{if is_super_admin_login()}
{include_partial module='programas' file='add.tpl"}
{/if}
</div>
{/if}
