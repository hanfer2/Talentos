{if is_blank($cod_prueba)}
  {include_template file='simulacros_con_cuestionario' title='Reporte Individual por Componentes'}
  <div class="ajax-response" id='ajax-reporteIndividualCualitativos-prueba'></div>
{elseif is_blank($cedula)}
  {include_template file="persona.form" title="Reporte Individual Por Componentes"}
  <div class="ajax-response" id='ajax-reporteIndividualCualitativos-estudiante'></div>
{else}
  <div class="ui-widget decorated">
    <h1>Reporte Individual Por Componentes Cualitativos</h1>
    <h2>{persona_url cedula=$cedula} - {$nombre_persona}</h2>
    <h3>{$nombre_prueba}</h3>

    {if empty($reporte)}
    <p>No se hallaron registros de componentes cualitativos para este participante en esta prueba.</p>
    {else}
    <div class="ui-toolbar">
      <a href="{url_for controller=i_cuestionarios_estudiantes action=view cod_prueba=$cod_prueba cedula=$cedula}">Consultar Respuestas de esta Prueba</a> | 
			<a href="{url_for controller=icfes action=view cod_prueba=$cod_prueba cedula=$cedula}">Consultar Icfes del Participante</a>
			<br/>
			<a href="{url_for controller=i_competencias_estudiantes action=view cod_prueba=$cod_prueba cedula=$cedula}">Reporte por Competencias</a>
    </div>
    <div class="dataTables_wrapper">
			<div class="fg-toolbar ui-widget-header ui-corner-top"></div>
      <table class="table" id="table-cualitativos_estudiantes-individual">
        <thead>
          <tr>
						<th class="ui-state-default">Área</th><th class="ui-state-default">Componente</th>
						<th class="ui-state-default" title="Número de Preguntas">N&deg; de Preguntas</th>
						<th class="ui-state-default" title="Número de Respuestas Correctas">N&deg; Resp. Correctas</th>
						<th class=" ui-state-default porcentaje total">%</th>
					</tr>
        </thead>
          {foreach from=$__componentes key=componente item=cualitativos}
          <tr>
            <td class="header-row" rowspan="{$cualitativos|@count}">{$componente|escape|capitalize}</td>
             {foreach from=$cualitativos item=cualitativo}
              <td>{$cualitativo.nombre_cualitativo|escape}</td>
              <td>{$cualitativo.cantidad_preguntas}</td>
              {assign var=cod_cualitativo value=$cualitativo.cod_cualitativo}
              <td>{$reporte.$componente.$cod_cualitativo.puntaje|string_format:"%.0f"}</td>
							<td class="total">{math equation="x*100/y" x=$reporte.$componente.$cod_cualitativo.puntaje y=$cualitativo.cantidad_preguntas format="%.2f%%"}</td>
              </tr>
              {/foreach}
          
          {/foreach}
       </table>
       <div class="fg-toolbar ui-widget-header ui-corner-bottom"></div>
    </div>

    {/if}
  </div>
{/if}
