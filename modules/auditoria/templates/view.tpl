<div class="ui-widget decorated">
  
  {if !isset($all)} 
  <h1>Listado Cambios de {$auditoria}</h1>
  <h2>{$nombre_programa}</h2>
  <div>
    {if isset($cedula)}
    <h2>{persona_url} - {$fullname}</h2>
    <h3>{$auditoria} Actual <span class='resaltar'> {$persona} </span></h3>
    {/if}
    
    {if empty($cambios)}
    <div class="ui-state-error frm-4 ui-corner-all">
      <span class="ui-icon ui-icon-alert error-icon left-icon"></span>
      No se hallaron cambios de {$auditoria}
    </div>
    {else}
      <table class="table dataTable">
        <thead>
          <tr>
            <th class="ui-state-default">Fecha</th>
            {if !isset($cedula)}
            <th class="ui-state-default">Doc. ID.</th>
            <th class="ui-state-default">Nombre</th>
            {/if}  
            <th class="ui-state-default">Realizado por</th>
            <th class="ui-state-default">Estado Previo</th>
            <th class="ui-state-default">Estado Actual</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$cambios item=cambio}
          <tr>
            <td>{$cambio.fecha|date_format:#TIMESTAMP_FORMAT#}</td>
            {if !isset($cedula)}
            <td>{persona_url cedula=$cambio.cedula}</td>
            <td>{link_to name=$cambio.fullname action='view_all' cedula=$cambio.cedula}</td>
            {/if}     
            
            <td>{$cambio.realizado_por}</td>
            <td>{$cambio.estado_previo}</td>
            <td>{$cambio.estado_nuevo}</td>
          </tr>
          {/foreach}
        </tbody>
      </table>
    {/if}
  </div>

  {else}
  <h1>Listado de Cambios</h1>
    <h2>{persona_url cedula=$cedula} - {$fullname}</h2>
    <div class="accdn ui-corner-all" id="accdn-reporte_cambios" style="width: 650px">
      {include_partial file="_view.tpl" nombre_campo="Estado" auditable=$estado cambios=$cambios_estado}
      {include_partial file="_view.tpl" nombre_campo="Doc. ID" auditable=$cedula cambios=$cambios_cedula}
      {include_partial file="_view.tpl" nombre_campo="Rol" auditable=$rol cambios=$cambios_rol}
    </div>
  {/if}
  <div class="date-report">Generado: <strong class="date">{'now'|date_format:#TIMESTAMP_FORMAT#}</strong></div>
</div>
<style type="text/css">
  {literal}
  span.estado_actual { 
    color: red; 
    font-weight: bold;
  }
  {/literal}
 </style>

