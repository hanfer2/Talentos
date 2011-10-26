<div class="ui-widget decorated">
  <h1>Reporte de Ingresos/Bajas</h1>
  <h2>Fecha {$fecha|date_format}</h2>
  
  <div class="ui-toolbar">
      {link_to name="Listado de Ingresos/bajas"}
  </div>
  
  <div class="toolbar fg-toolbar tb-main">
    <a href="#accdn-item-ingresos" class="fg-button ui-state-default ui-state-active ui-corner-left">Ingresos</a>
    <a href="#accdn-item-bajas" class="fg-button ui-state-default ui-state-default ui-corner-right">Bajas</a>
  </div>
  
  <div style="width: 600px" id="accdn-reporte" class="accdn">
    <div class="accdn-item ui-corner-all" id="accdn-item-ingresos">
    <h3 class="ui-state-default ui-corner-all">Ingresos</h3>
    <table class="dataTable table" id="table-ingresos">
      <thead>
        <tr><th>Doc. Id</th><th>Nombre</th><th>Curso</th><th>Realizado Por</th></tr>
      </thead>
      <tbody>
        {foreach from=$ingresos item=ingreso}
        <tr>
          <td>{persona_url cedula=$ingreso.cedula}</td>
          <td>{$ingreso.fullname|escape}</td>
          <td>{$ingreso.nombre_grupo}</td>
          <td>{$ingreso.creado_por|default:"Sistema"|escape}</td>
        </tr>
        {/foreach}
      </tbody>
    </table>
    </div>
    
    <div class="accdn-item ui-corner-all ui-helper-hidden" id="accdn-item-bajas">
    <h3 class="ui-state-default ui-corner-all">Bajas</h3>
    <table class="dataTable table" id="table-bajas">
      <thead>
        <tr><th>Doc. Id</th><th>Nombre</th><th>Curso</th><th>Realizado Por</th></tr>
      </thead>
      <tbody>
        {foreach from=$bloqueados item=bloqueado}
        <tr>
          <td>{persona_url cedula=$bloqueado.cedula}</td>
          <td>{$bloqueado.fullname|escape}</td>
          <td>{$bloqueado.nombre_grupo}</td>
          <td>{$bloqueado.creado_por}</td>
        </tr>
        {/foreach}
      </tbody>
    </table>
    </div>
  </div>
  
  <script type="text/javascript">
    {literal}
    $(function(){
      $("a",".tb-main").click(function(){
        var target = this.hash;
        var jqTarget = $(target);
        var _this = $(this);
        
       
        
        jqTarget.slideToggle();
        _this.toggleClass("ui-state-active");
        return false;
      });
    })
    
    {/literal}
  </script>
</div>

