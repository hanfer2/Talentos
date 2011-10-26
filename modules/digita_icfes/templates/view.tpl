<div class="ui-widget decorated">
  <h1>Formularios Digitados Por {$nombre_persona}</h1>
  {if $cod_prueba == null}
    <p>No hay prueba activa actualmente</p>
  {else}
    <h3>{$nombre_prueba}</h3>
    <div class="ui-toolbar">
      {link_to name="Reporte Digitadores" action=reporte}
    </div>
    {if $estudiantes == null}
      <p>Este Digitador No reporta Formularios Diligenciados</p>
    {else}
      <table class="table dataTable dt-non-paginable">
        <thead>
          <tr>
            <th>Doc. Id</th>
            <th>Nombre</th>
            <th>Curso</th>
            <th>Correcciones</th>
          </tr>
        </thead>
        
        <tbody>
          {foreach from=$estudiantes item=estudiante}
          <tr>
            <td>{$estudiante.cedula}</td>
            <td>{link_to name=$estudiante.fullname controller=icfes action=add cedula=$estudiante.cedula}</td>
            <td>{$estudiante.nombre_grupo}</td>
            <td>{$estudiante.correcciones}</td>
          </tr>
          {/foreach}
        </tbody>
      </table>
      {/if}
  {/if}
</div>
