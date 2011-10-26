<div class="ui-widget decorated" id='ajax-listadoEgresados'>
  {assign var='ASPIRANTES_IES_TEXT' value='Aspirantes a Ingreso a Educaci&oacute;n Superior'}
  {if (empty($egresados))}
		{capture assign=err_message}
		<p>No se hallaron <strong>Participantes Egresados 
			{if $noIES} {$ASPIRANTES_IES_TEXT}{/if}</strong>
			Registrados pertenecientes al PNAT {$cod_programa}
		</p>
		{/capture}
		{include_template file=error message=$err_message}
  {else}
  <h1>Listado de Estudiantes Egresados {if $noIES} <br/>{$ASPIRANTES_IES_TEXT}{/if}</h1>
  <h2>{nombre_programa cod_programa=$cod_programa	}</h2>
  <table class="table dataTable" id="table-ListadoIES">
    <thead>
      <tr>
      	<th>C&oacute;digo</th>
        <th>Doc. Id</th>
        <th>Nombre</th>
        <th>Direcci&oacute;n</th>
        <th>Tel&eacute;fonos</th>
        <th title='Correo Electr&oacute;nico'>Correo E.</th>
        <th class='column-select-filter'>G&eacute;nero</th>
        <th>Edad<br/><div style="font-size:8pt">(A&ntilde;os)</div></th>
				<th class='column-select-filter long-select' >Colegio</th>
        {if !$noIES}
        <th class='column-select-filter'>Ingreso<br/>Educ.Sup.</th>
        <th class='column-select-filter'>Laborando</th>
        {/if}
      </tr>
    </thead>
    <tbody>
      {foreach from=$egresados item=egresado}
      <tr>
      	<td>{$egresado.cod_estud}</td>
        <td>{persona_url cedula=$egresado.cedula}</td>
        <td>
					{if is_blank($egresado.cod_universidad)}
						{$egresado.fullname|escape}
						<div>{link_to name='Registrar' action='add' cedula=$egresado.cedula}</div>
          {else}
						{link_to name=$egresado.fullname action='view' cedula=$egresado.cedula}
          {/if}
        </td>
        <td>{$egresado.direccion|escape}</td>
        <td>{join parts="`$egresado.telefono`;`$egresado.tel_celular`"|escape sep=', '}</td>
        <td>{join parts="`$egresado.email`;`$egresado.email_2`"|escape sep=', '}</td>
        <td>{$egresado.genero|escape}</td>
        <td>{$egresado.edad|escape}</td>
        <td>{$egresado.nombre_colegio|escape}</td>
				{if !$noIES}
        <td>{if is_blank($egresado.cod_universidad)} &#10008; {else} &#10003; {/if}</td>
        <td>{if is_blank($egresado.ocupacion)} &#10008; {else} &#10003; {/if}</td>
        {/if}
      </tr>
      {/foreach}
    </tbody>
  </table>
  {/if}
  <div class="ui-toolbar">
		{link_to name='Registrar Egresados' view='add' cod_programa=$cod_programa}
  </div>
</div>


