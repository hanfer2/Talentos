<div class="ui-widget decorated">
  <h1>Reporte de Digitadores Icfes</h1>
  {if $cod_prueba == null}
    <p>No hay prueba activa actualmente</p>
  {else}
    <h2>{$nombre_prueba}</h2>
    
    <div style="font-size: 14pt">
      Total Formularios Diligenciados: <span id="sp-totalDiligenciados"></span>
    </div>
    
    <table class="table dataTable dt-non-paginable" id="table-reporte-formulariosDiligenciados">
      <thead>
        <tr>
          <th>Doc. Id</th>
          <th>Nombre Digitador</th>
          <th>Formularios</th>
          <th>Correcciones</th>
        </tr>
      </thead>
      
      <tbody>
        {foreach from=$digitadores item=digitador}
        <tr>
          <td>{$digitador.cedula}</td>
          <td>{link_to name=$digitador.fullname action=view cedula=$digitador.cedula}</td>
          <td class="td-diligenciados">{$digitador.diligenciados}</td>
          <td>{$digitador.correcciones}</td>
        </tr>
        {/foreach}
      </tbody>
    </table>
    <br/>
    
    {literal}
    <script type="text/javascript">
      $(function(){
        var suma = 0;
        $(".td-diligenciados").each(function(){
          suma += parseInt(this.innerHTML);
        })
        $("#sp-totalDiligenciados").html(suma);
      })
    </script>
    <style type="text/css">
      #table-reporte-formulariosDiligenciados_wrapper{width: 500px}
    </style>
    {/literal}
  {/if}
</div>
