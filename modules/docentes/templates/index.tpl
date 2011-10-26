{if isset($cod_programa)}
  <div class="ui-widget decorated">
    <h1>Listado de Docentes</h1>
    {if $cod_programa neq '0'}<h2>{$nombre_programa}</h2>{/if}
    {if (empty($docentes)) }
      {include_template file='message_empty_results'}
    {else}
      <div class="ui-toolbar">
        {link_to name='Listado de Docentes Por Cursos' controller='docentes' action='cursos'} |
        {link_to name='Informe de Docentes' controller='docentes' action='informe'}
      </div>
      <table class="table dataTable">
        <thead>
          <tr>
            {if is_super_admin_login()}
            <th>Cód</th>
            {/if}
            <th>C&eacute;dula</th><th>Nombre</th>
            <th class='column-select-filter'>G&eacute;nero</th><th>Tel&eacute;fono</th>
            <th>Celular</th><th>Direcci&oacute;n</th><th>E-mail</th>
            <th class='column-select-filter'>Ciudad</th>
            <th class='column-select-filter date'>Fecha Ingreso</th>
          </tr>
        </thead>
        <tbody>
          {foreach from=$docentes item=docente}
          <tr>
            {if is_super_admin_login()}
            <td>{$docente.cod_interno}</td>
            {/if}
            <td>{persona_url cedula=$docente.cedula}</td>
            <td>{$docente.fullname|escape}</td>
            <td>{$docente.genero|escape}</td>
            <td>{$docente.telefono|escape}</td>
            <td>{$docente.tel_celular|escape}</td>
            <td>{$docente.direccion|escape}</td>
            <td>{$docente.email|lower|escape}</td>
            <td>{$docente.ciudad|escape}</td>
            <td>{$docente.fecha_ingreso|date_format}</td>
          </tr>
          {/foreach}
        </tbody>
      </table>
    {/if}
  </div>
{else}
  {include_template file="programa.form" title="Listado de Docentes" extra=TODOS}
  <div id='ajax-listadoDeDocentes'></div>
{/if}

