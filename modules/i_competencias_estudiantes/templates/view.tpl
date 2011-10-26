{if is_blank($cod_prueba)}
  {include_template file='simulacros_con_cuestionario' title='Reporte Individual por Competencias'}
  <div class="ajax-response" id='ajax-reporteIndividualCompetencias-prueba'></div>
{elseif is_blank($cedula)}
  {include_template file="persona.form" title="Reporte Individual Por Competencias"}
  <div class="ajax-response" id='ajax-reporteIndividualCompetencias-estudiante'></div>
{else}
  <div class="ui-widget decorated">
    <h1>Reporte Individual Por Competencias</h1>
    <h2>{persona_url cedula=$cedula} - {$nombre_persona}</h2>
    <h3>{$nombre_prueba}</h3>

    {if empty($reporte)}
    <p>No se hallaron registros de competencias para este participante en este prueba.</p>
    {else}
    <div class="ui-toolbar">
      <a href="{url_for controller=i_cuestionarios_estudiantes action=view cod_prueba=$cod_prueba cedula=$cedula}">Consultar Respuestas de esta Prueba</a> | 
    <a href="{url_for controller=icfes action=view cod_prueba=$cod_prueba cedula=$cedula}">Consultar Icfes del Participante</a>
    <br/>
<a href="{url_for controller=i_cualitativos_estudiantes action=view cod_prueba=$cod_prueba cedula=$cedula}">Reporte por Componentes Cualitativos</a>
    </div>
    <div>
      <table class="table" id="table-competencias_estudiantes-individual">
        <thead>
          <tr><th class="ui-state-default">Componente/Área</th><th class="ui-state-default">Competencia</th>
	       <th class="ui-state-default" title="Número de Respuestas Correctas">N&deg; Resp. Correctas</th><th class=" ui-state-default porcentaje total">%</th></tr>
        </thead>
          {foreach from=$__componentes key=componente item=competencias}
          <tr>
            <td class="header-row" rowspan="{$competencias|@count}">{$componente|escape|capitalize}</td>
             {foreach from=$competencias item=competencia}
              <td>{$competencia.nombre_competencia|escape} ({$competencia.cantidad_preguntas})</td>
              {assign var=cod_competencia value=$competencia.cod_competencia}
              <td>{$reporte.$componente.$cod_competencia.puntaje|string_format:"%.0f"}</td>
	      <td class="total">{math equation="x*100/y" x=$reporte.$componente.$cod_competencia.puntaje y=$competencia.cantidad_preguntas format="%.2f%%"}</td>
              </tr>
              {/foreach}
          
          {/foreach}
       </table>
    </div>

    {/if}
  </div>
{/if}
