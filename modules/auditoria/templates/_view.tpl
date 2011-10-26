<div class="accdn-item ui-corner-all">
  <h3 class="ui-state-default">Cambios de {$nombre_campo}</h3>
  <div> <span class="ui-icon ui-icon-arrow-1-e inline-icon"></span>{$nombre_campo} Actual <span class='estado_actual'>{$auditable}</span></div>
    {if empty($cambios)}
    <div>
      <p class="ui-state-highlight ui-corner-all notif-block msg-s4">
        <span class="ui-icon ui-icon-info inline-icon"></span> 
        Este estudiante NO reporta cambios de <strong>{$nombre_campo}</strong> hasta el momento.
      </p>
    </div>
    {else}
    <table class="table dataTable">
      <thead>
        <tr>
          <th class="ui-state-default">Fecha</th>           
          <th class="ui-state-default">Realizado por</th>
          <th class="ui-state-default">Antes</th>
          <th class="ui-state-default">Después</th>
        </tr>
      </thead>
      <tbody>
        {foreach from=$cambios item=cambio}
        <tr>
          <td>{$cambio.fecha|date_format:#TIMESTAMP_FORMAT#}</td> 
          <td>{$cambio.realizado_por}</td>
          <td>{$cambio.estado_previo}</td>
          <td>{$cambio.estado_nuevo}</td>
        </tr>
        {/foreach}
      </tbody>
    </table>
    {/if}
</div>
