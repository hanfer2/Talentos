{if isset($cod_programa)}
<div class="ui-widget decorated">
  <h1>Listado Cursos Especiales</h1>
  <h2>{$nombre_programa}</h2>
  <div>
    
    <table class="table dataTable">
      <thead>
        <tr><th>Nombre</th><th>Componente</th></tr>
      </thead>
      <tbody>
        {foreach from=$cursos item=curso}
        <tr>
          <td>{$curso.nombre_grupo}</td>
          <td>{$curso.nombre_componente}</td>
        </tr>
        {/foreach}
      </tbody>
    </table>
  </div>
  <div class="ui-toolbar">
    <a id="link-agregarCursoEspecial" class="link" href="#">Agregar Curso Especial</a>
  </div>
 {include_partial file="add"}
</div>
{else}
  {include_template file="programa.form" title="Listado Cursos Especiales"}
  <div id="ajax-listadoCursosEspeciales"></div>
{/if}
