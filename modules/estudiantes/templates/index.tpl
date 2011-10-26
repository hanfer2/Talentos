{if !isset($cod_programa)}
	
	<div class="ui-widget decorated non-printable">
  <h1>Listado de Participantes</h1>
  
  <div class="ui-form" id="form-listadoDeParticipantes">
    <div class="ui-field">
      <label>{#PNAT#}</label>
			{info classname='TPrograma' func='toSQL' assign='programas_sql'}
			{html_select name='cod_programa' options=$programas_sql extra=$extra}
    </div>
    <div class='ui-field chk-buttonset'>
			<input type='checkbox' value='11' checked='checked' id="chk-listadoActivos"/><label class='left-label' for="chk-listadoActivos">Activos</label> |
			<input type='checkbox' value='12' id="chk-listadoInactivos"/><label class='left-label' for="chk-listadoInactivos">Inactivos</label> |
			<input type='checkbox' value='13' id="chk-listadoEgresados"/><label class='left-label' for="chk-listadoEgresados">Egresados</label>
		</div>
    <div class="ui-button-bar">
      <button id="bt-listadoDeParticipantes">Consultar</button>
    </div>
    
  </div>
</div>

	<div class='ajax-response' id="ajax-listadoDeParticipantes"></div>
{elseif count($estudiantes) != 0}
	
<div class="ui-widget decorated">
	{link_open_external}
  <h1>Listado de Participantes</h1>
  <h2>{nombre_programa}</h2>
  {if count($nombres_estados) eq 1}
    <h5>{$nombres_estados|@current}</h5>
  {else}
    <div class="ui-buttonset" id="buttonset-filtro-estados">
    {foreach from=$nombres_estados item=estado}<a href="#{$estado}" class="ui-state-default ui-corner-all fg-button fg-button-rect">{$estado}</a>{/foreach}
    </div>
  {/if}
  <div class="clear"></div>
  {if !is_xhr()}
  <div class="ui-toolbar">
		{link_to name="Listado de Participantes de otro PNAT"}
  </div>
  {/if}
  <table class="table dataTable" id="table-listadoEstudiantes">
    <thead>
      <tr>
				<th>Doc. Id</th><th>C&oacute;digo</th>
				<th>Apellidos</th><th>Nombres</th>
				<th>Tel&eacute;fonos</th><th>E-mail</th><th>Direccion</th>
				<th class='column-default-hidden'>Edad</th><th>Comuna</th>
				<th class='column-select-filter'>Estado</th>
				<th class='column-select-filter'>Curso</th>
				{if !isset($cod_programa)}
				<th class='column-select-filter'>{#PNAT#}</th>
				{/if}
			</tr>
    </thead>
    <tbody>
      {foreach from=$estudiantes item=estudiante}
      <tr>
        <td>{persona_url cedula=$estudiante.cedula}</td>
				<td>{$estudiante.cod_estud}</td>
        <td>{$estudiante.apellidos|escape}</td>
        <td>{$estudiante.nombres|escape}</td>
			  <td>{join parts="`$estudiante.telefono`;`$estudiante.tel_celular`"|escape sep=', '}</td>        
        <td>{join parts="`$estudiante.email`;`$estudiante.email_2`"|escape|lower sep=', '}</td>
        <td>{$estudiante.direccion}</td>
        <td>{$estudiante.edad}</td>
 			  <td>{$estudiante.comuna|string_format:"%.0f"}</td>
        <td>{$estudiante.nombre_estado|escape}</td>
        <td>{link_to name=$estudiante.nombre_grupo|escape controller=cursos action=view cod_curso=$estudiante.cod_grupo}</td>
 				{if !isset($cod_programa)}
        <td>{link_to name=$estudiante.cod_programa cod_programa=$estudiante.cod_programa}</td>
        {/if}
      </tr>
      {/foreach}
    </tbody>
  </table>
  <div class="toTop">Arriba<span class="ui-icon"></span></div>
</div>
{else}
	<div class='ui-widget decorated'>
		<h1>No se hallaron registros</h1>
		<h2>{nombre_programa}</h2>
		<p>No se hallaron estudiantes {","|implode:$nombres_estados} pertenecientes al PNAT {$nombre_programa}</p>
		<div class="ui-toolbar">{link_to name="Modificar Búsqueda"}</div>
	</div>
{/if}
