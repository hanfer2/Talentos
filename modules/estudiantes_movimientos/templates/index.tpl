<div class="ui-widget decorated">
  <h1>Reporte de Ingresos/Bajas de Participantes</h1>
  <h2>{$nombre_programa}</h2>
  
  <table class="table" style="width:250px">
    <thead>
      <tr>
        <th class="ui-state-default">Fecha</th>
        <th class="ui-state-default">Ingresos</th>
        <th class="ui-state-default">Bajas</th>
        <th class="ui-state-default">Total</th>
      </tr>
    </thead>
    <tbody>
  
  {foreach from=$mov item=dia}
    <tr>
      <td>{link_to name=$dia.fecha|date_format action=view fecha=$dia.fecha}</td>
      <td>{$dia.ingresos}</td>
      <td>{$dia.bajas}</td>
      {math equation="t+i-b" i=$dia.ingresos b=$dia.bajas t=$total assign=total}
      <td>{$total}</td>
    </tr>
  {/foreach}
  </tbody>
  </table>
  <div class="date-report">{"now"|date_format}</div>
</div>
