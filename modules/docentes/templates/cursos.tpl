{if not (isset($cedula) or isset($cod_componente))}
  <div class="ui-widget decorated">
    <h1>Listado de Docentes Por Curso</h1>
    <div class='ui-form'>
      <div class="ui-field">
        <label for="cod_programa">{#PNAT#}</label>
        {info classname='TPrograma' func='toSQL' assign='programas_sql'}
        {html_select name='cod_programa' options=$programas_sql}
      </div>
      <div class="ui-field">
        <label for="cod_componente">Componente</label>
        {info classname='TComponente' func='toSQL' assign='componentes_sql'}
        {html_select name='cod_componente' options=$componentes_sql extra='TODOS'}
      </div>
      <div class='ui-toolbar'>
		<button id='bt-listadoDocentesCursos'>Aceptar</button>
      </div>
    </div>
  </div>
  <div class='ajax-response' id='ajax-listadoDocentesCursos'></div>
{else}
  
    <div class="ui-widget decorated">
      <h1>{if (isset($cedula))} Listado de Cursos {else} Listado de Docentes Por Curso {/if}</h1>
      {if isset($cedula)} 
        <h2>{persona_url cedula=$cedula} - {info classname='TPersona' func='nombre' args=$cedula}</h2>
      {/if}
      
      {if (empty($docentes)) }
         {include_template file='message_empty_results'}
      {else}
      
      {if is_admin_login()}
      <div class="ui-toolbar">
        {link_to name="Listado Completo de Docentes" controller="docentes"} |
        {link_to name='Listado de Docentes Por Curso' controller="docentes" action="cursos"}<br/>
        {link_to name='Informe de Docentes' controller='docentes' action='informe'}
      </div>
      {/if}
      <table class="table dataTable dt-unsortable" id='table-cursosDocente'>
        <thead>
          <tr>
            {if (!isset($cedula))}
              <th class="column-hidden">Docente</th>
            {/if}
            <th>Componente</th>
            <th>Curso</th>
            <th>{#PNAT#}</th>
          </tr>
        </thead>
        <tbody>
          {foreach from = $docentes item = docente}
          <tr>
            {if !isset($cedula) }
              <td>{persona_url cedula=$docente.cedula} - {$docente.fullname|escape}.<br/> Tels: {join sep="," parts="`$docente.telefono`;`$docente.tel_celular`"|escape}; E-mail:{$docente.email|lower}</td>
            {/if}
            <td>{$docente.nombre_componente|escape}</td>
            <td>{link_to name=$docente.nombre_grupo controller=cursos action=view cod_curso=$docente.cod_curso}</td>
            <td>{$docente.cod_programa}</td>
         </tr>
          {/foreach}
        </tbody>
      </table>
    </div>
  {/if}
{/if}
