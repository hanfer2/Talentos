{if !isset($cod_programa)}
	{include_template file='programa.form' title='Listado de Cursos'}
	<div class='ajax-response'></div>
{elseif !empty($cursos)}
<div class="ui-widget decorated">
	{link_open_external}
  <h1>Listado de Cursos</h1>
  <h2>{nombre_programa cod_programa=$cod_programa}</h2>
  <table class="table dataTable dt-non-paginable" id="table-listadoCursos">
    <thead>
      <tr>
        {if is_root_login()}
				<th>C&oacute;digo</th>
        {/if}
				<th class='column-select-filter'>Grupo</th><th>Curso</th>
        <th>Cupos</th>
				<th title='N&uacute;mero de Estudiantes Activos inscritos en el Curso'>N&deg;<br/>Estud.</th>
				<th class='column-select-filter'>Tipo</th>
			</tr>
    </thead>
    <tbody>
			{foreach from=$cursos item=curso}
        <tr>
          {if is_root_login()}
          <td>{$curso.codigo|escape}</td>
          {/if}
          <td>{link_to name=$curso.grupo action=index cod_grupo=$curso.grupo cod_programa=$cod_programa}</td>
          <td>{link_to name=$curso.subgrupo|zeropad:2 action=view cod_curso=$curso.codigo}</td>
          <td>{$curso.cupos}</td>
          <td>{$curso.cantidad_estudiantes}</td>
					<td>{$curso.tipo|default:"Académico"|escape}</td>
        </tr>
      {/foreach}
    </tbody>
  </table>
  <div class="ui-toolbar">
    <a href="#{if isset($cod_grupo)}{$cod_grupo}{/if}" id="link-verNotificaciones">Ver Notificaciones -{if isset($cod_grupo)} Grupo {$cod_grupo}{else}Globales{/if}</a>
  </div>
  <div class="toTop">Arriba<span class="ui-icon"></span></div>
</div>
{else}
	<div class="ui-widget decorated">
	<h1>No se hallaron registros</h1>
	<p>No se hallaron cursos</p>
	</div>
{/if}
