<div class="ui-widget decorated">
  <h1>Proceso de Matr&iacute;cula</h1>
  <h2>{nombre_programa cod_programa = $oConfig->cod_programa}</h2>

  <div class="accdn ui-corner-all frm-5">  
  {if not $tiene_cursos}
    <div class="accdn-item ui-corner-all">
      <h3 class="ui-state-default ui-corner-top"><span class="counter">1.</span> Distribución de Cursos</h3>
      {include_partial file='configura/distribucion.form.tpl' oConfig=$oConfig}
    </div>
  {else}
    <div class="accdn-item ui-corner-all">
      <h3 class="ui-state-default ui-corner-top"><span class="counter">1.</span> Distribución de Cursos</h3>  
      <div class="ui-state-highlight notif-block ui-corner-all frm-4">
        <span class="ui-icon ui-icon-alert inline-icon"></span> Este programa ya tiene sus cursos creados.<br/>
      </div>
      <div class="ui-toolbar">
      {link_to name="Ver Listado de Cursos" controller="cursos" action=index cod_programa=$cod_programa} 
      </div>
    </div>
    <div class="accdn-item ui-corner-all">
      {include_partial file='configura/cargar_participantes.tpl' counter=2 tipo="participantes"}
    </div>
    
    <div class="accdn-item ui-corner-all">
      {include_partial file='configura/cargar_participantes.tpl' counter=3 tipo="colegios"}
    </div>
    <div class="accdn-item ui-corner-all">
      {include_partial file='configura/cargar_participantes.tpl' counter=4 tipo="icfes"}
    </div>
    
    <div class="accdn-item ui-corner-all">
      {include_partial file='configura/asignar_cursos.tpl' counter=5 }
    </div>
    
  {/if}
  </div>
</div>
