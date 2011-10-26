{if empty($cursoxcomponente)}
	<p>No hay Inasistencias Reportadas</p>
{else}
<!--
    {include_template file='programa.form' title='Listado de Inasistencias'}
	<div class='ajax-response' id='ajax-listadoDeInasistencias'></div>
-->
<div class="ui-widget decorated">
  <h1>Listado de Asistencias Por Cursos Componente {$nombreComponente.nombrecomponente|escape}</h1>
 
  <table class='table dataTable non-paginable' id='table-inasistenciasGeneral'>
<thead>
	<tr>
	<th  rowspan='3'>CURSOS</th>
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
		{foreach from=$cursoxcomponente item=cursoxcomponente}
      <tr>
        <td>{$cursoxcomponente.curso|escape}</td>
        <td>{$cursoxcomponente.excusamedica|default:0} </td>
        <td>{$cursoxcomponente.calamidad|default:0} </td>
        <td>{$cursoxcomponente.estudio|default:0} </td>
        <td>{$cursoxcomponente.transportemas|default:0} </td>
       
      <td class='total total-asistenciasJustificadas'></td>
       
        <td>{$cursoxcomponente.nojustificada|default:0} </td>
        <td>{$cursoxcomponente.trabajo|default:0} </td>
        <td>{$cursoxcomponente.transportemenos|default:0} </td>
        
   <td class='total total-asistenciasInjustificadas'></td>
  
       <td>{$cursoxcomponente.total|default:0 }</td>
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

