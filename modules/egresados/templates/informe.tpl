{if is_blank($cod_programa)}
	{include_template file='programa.form' title='Informe de Egresados' extra="TRUE"}
	<div class='ajax-response' id="ajax-informe-egresados"></div>
{else}
	<div class='ui-widget decorated ui-informe-panel'>
		<h1>Informe de Egresados<br/>	con Ingreso a Educaci&oacute;n Superior</h1>
		<h2>{nombre_programa cod_programa=$cod_programa}</h2>
		<h3>{'now'|date_format}</h3>
    {if isset($informe) and $informe == FALSE}
      <p><span class='ui-icon ui-icon-alert error-icon inline-icon'></span> No hay estudiantes reportados como egresados para este {#PNAT#}</p>
    {else}
      <div class="ui-toolbar non-printable">
        <a href="#" id="link-collapseAll">Informe Resumido</a> | 
        <a href="#" id="link-expandAll">Informe Detallado</a>
      </div>
      {foreach from=$universidades key=cod_universidad item=universidad}
      <table class='component-report'>
      <tbody>
        <tr>
        {count var=$carreras.$cod_universidad assign='cant_univ'}
          <td class='name-component-report' rowspan="{$cant_univ}">
          {$cod_universidad} - {link_to name=$universidad.nombre controller='universidades' action='egresados' cod_universidad=$cod_universidad}
          </td>
          {foreach from=$carreras.$cod_universidad key=cod_carrera item=carrera}
            <td class='informe-nombre-carreras'>
            {$cod_carrera} - {link_to name=$carrera.nombre controller='universidades' action='egresados' cod_universidad=$cod_universidad cod_carrera=$cod_carrera}
            </td>
            <th class='informe-cant-egresados'>{$carrera.counter}</th>
        </tr>
          {/foreach}
      </tbody>
      <tfoot class='clickable'>
        <tr>
          <td colspan="2" class='name-component-report' >
            <span>{$universidad.nombre|escape}</span>
            <span> - {pluralize count=$cant_univ singular='Carrera' plural='Carreras'}</span>
          </td>
          <th class='informe-cant-egresados'>{$universidad.counter}</th>
        </tr>
      </tfoot>
      </table>
      {/foreach}

      <table class='summary-report'>
      <tbody>
        <tr>
          <td class='total-label-sumary-report'>
            Total Estudiantes<br/>con Ingreso a la Educaci&oacute;n Superior
          </td>
          <th class='total-sumary-report'style=" ">{$totalIES}</th>
        </tr>
      </tbody>
      </table>
      
      <div class="date-report"> Generado: <span class="date">{'now'|date_format:#TIMESTAMP_FORMAT#}</span></div>
    {/if}
	</div>
{/if}
