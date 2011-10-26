{if !isset($cod_programa)}
	{include_template file='programa.form' title='Reporte de Comparativas Icfes'}
	<div class='ajax-request'></div>
{else}
<div class='decorated ui-widget'>
	<h1>Reporte de Comparativas</h1>
	<h2>{$nombre_programa}</h2>
	{if $tipos_icfes == null}
		<div class='empty-message-error'>
			No hay a&uacute;n Pruebas Icfes/Simulacros Registrados para {$nombre_programa}
		</div>
	{else}
  <div class="tabs" id="tabs-icfesComparativas">
    <ul>
      <li><a href="#tab-promediosGeneralesRelativo">Promedios Respecto a otra prueba</a></li>
      <li><a href="#tab-promediosGeneralesAbsoluto">Promedios Absolutos</a></li>
    </ul>

  

    <!-- PROMEDIOS GENERALES RELATIVOS -->
    <div id="tab-promediosGeneralesRelativo">
      <h3>Comparativa de Promedios Generales Icfes</h3>
      <h4>con respecto al N&deg; de Estudiantes de <strong>{$ultimo_icfes.nombre|escape}</strong></h4>
      <table id='table-promediosRelativo' class='table dataTable dt-non-paginable table-icfesComparativas'>
        <thead>
          <tr>
            <th>COMPONENTES</th>
            {foreach from=$tipos_icfes item=icfes}
							{assign var=cod_prueba value=$icfes.codigo}
            <th>
              <div class='nombrePrueba'>{$icfes.nombre|escape}</div>
              <div class='subtitle-header'>{$icfes.fecha|date_format}</div>
							<div class='subtitle-header'>Participantes: {$promedios.relative.$cod_prueba.cantidad}</div>
            </th>
            {/foreach}
          </tr>
        </thead>
        <tbody>
        {foreach from=$componentes item=componente}
          <tr>
            <td>{$componente|escape|lower|capitalize}</td>
            {foreach from=$tipos_icfes item=icfes}
							{assign var=cod_prueba value=$icfes.codigo}
							{assign var=componente_in_lower value=$componente|lower}
							<td>
								{$promedios.relative.$cod_prueba.$componente_in_lower|string_format:"%.2f"}
							</td>
            {/foreach}
          </tr>
          {/foreach}
        </tbody>
      </table>
      <div id='chart-container-relativo' style='margin:0 auto; margin-top:8mm; width:20cm'></div>
    </div>
    
      <!-- PROMEDIOS GENERALES ABSOLUTOS -->
    <div id="tab-promediosGeneralesAbsoluto">

      <h3>Comparativa de Promedios Generales Icfes</h3>
      <table id='table-promediosAbsoluto' class='table dataTable dt-non-paginable table-icfesComparativas'>
        <thead>
          <tr>
            <th>COMPONENTES</th>
            {foreach from=$tipos_icfes item=icfes}
							{assign var=cod_prueba value=$icfes.codigo}
							<th>
								<div class='nombrePrueba'>{$icfes.nombre|escape}</div>
								<div class='subtitle-header'>{$icfes.fecha|date_format}</div>
								<div class='subtitle-header'>Participantes: <strong>{$promedios.absolute.$cod_prueba.cantidad}</strong></div>
							</th>
            {/foreach}
          </tr>
        </thead>
        <tbody>
					{foreach from=$componentes item=componente}
          <tr>
            <td>{$componente|escape|lower|capitalize}</td>
            {foreach from=$tipos_icfes item=icfes}
							{assign var=cod_prueba value=$icfes.codigo}
							{assign var=componente_in_lower value=$componente|lower}
							<td>
								{$promedios.absolute.$cod_prueba.$componente_in_lower|string_format:"%.2f"}
							</td>
            {/foreach}
          </tr>
          {/foreach}
        </tbody>
      </table>
      
      <div id='chart-container-absoluto' style='margin:0 auto; margin-top:8mm; width:20cm'></div>
    </div>
  </div>
  
  {/if}
</div>
{/if}
