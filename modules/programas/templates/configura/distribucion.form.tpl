{assign var=grupos value=$oConfig->grupos()}
<form method="post" action="{url_for controller=programas action=create_cursos}" class="frm-4">
<table class="table dataTable dt-non-paginable dt-non-filterable dt-unsortable" id='table-cuposCursos'>
  <thead>
    <tr>
      <th>Curso</th>
			{foreach from=$grupos item=grupo}
      <th>{$grupo}</th>
      {/foreach}
    </tr>
  </thead>
  <tbody>
		{section start=1 name=cursos loop=$oConfig->maxPorCursos()+1}
		{assign var=curso value=$smarty.section.cursos.index}
    <tr>
      <td>{$curso|lpad:2}</td>
			{foreach from=$grupos item=grupo}
      <td>{html_input name="programa[cursos][$grupo][`$curso`]" value=$oConfig->consultarCupo($grupo, $curso)}</td>
       {/foreach}
    </tr>
    {/section}
  </tbody>
  <tfoot>
    <tr>
      <th></th>
			{foreach from=$grupos item=grupo}<th></th>{/foreach}
    </tr>
    <tr><th colspan="{math equation='x + 1' x=$grupos|@count}"></th></tr>
  </tfoot>
</table>
<input type="hidden" name="cod_programa" value="{$cod_programa}"/>
<button id="bt-crearCursos">Crear Cursos</button>
</form>
