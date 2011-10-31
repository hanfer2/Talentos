<!-- {capture assign=links}
	{if is_super_admin_login()}-->

	<!-- {/if}
{/capture}-->
{if empty($grupo)}
	<!-- {include file=#EMPTY_RESULTS_FILE# links=$links}-->

{else}

<div class="ui-widget decorated">
  <h1>Listado de Asistencias Por Curso grupo {$g.grupo}</h1>
 
 <table class='table dataTable non-paginable' id='table-inasistenciasGeneral'>
    <thead>
      <tr><th rowspan="3" >GRUPO</th>
 <th colspan='10'>INASISTENCIAS</th>

	</tr>
	<tr>
		<th colspan='5'>JUSTIFICADAS</th>
		<th colspan='4'>INJUSTIFICADAS</th>
		<th class='column-total' title='Total de Inasistencias' rowspan='3'>TOTAL INASISTENCIAS</th>
	</tr>
	<tr>
    
		
		<th>EXCUSA MÉDICA</th>
		<th>CALAMIDAD</th>
    <th>ESTUDIO</th>
    <th>TRANSPORTE+</th>
		<th class='column-total' title='Total de Inasistencias Justificadas'>TOTAL</th>
    
		
		<th>NO JUSTIFICADA</th>
		<th>TRABAJO</th>
    <th>TRANSPORTE-</th>
		<th class='column-total' title='Total de Inasistencias No Justificadas'>TOTAL</th>
      </tr>
    </thead>
    <tbody>
			{foreach from=$grupo item=grupo}
     <tr>
        <td>{$grupo.nombre_grupo }</td>
        <td>{$grupo.excusamedica|default:0	}</td>
        <td>{$grupo.calamidad|default:0	}</td>
        <td>{$grupo.estudio|default:0	}</td>
         <td>{$grupo.transporte|default:0	}</td>
          <td class='total total-asistenciasJustificadas'></td>
         <td>{$grupo.nojustificada|default:0	}</td>
          <td>{$grupo.trabajo|default:0	}</td>
           <td>{$grupo.transportemenos|default:0	}</td>
             <td class='total total-asistenciasInjustificadas'></td>
            <td>{$grupo.inasistencias|default:0	}</td>
      </tr>
      {/foreach}
    </tbody>
  </table>
   <div class='date-report'>Generado: <span class='date'>{'now'|date_format}</span></div>
  <!--
  <div class="ui-toolbar">{$links}</div>
{if is_super_admin_login()}
{include_partial module='programas' file='add.tpl"}
{/if}-->
</div>
{/if}

