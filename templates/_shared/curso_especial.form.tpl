{php}
  AppLoader::load_model('CursoEspecial');
{/php}
<div class="ui-widget decorated non-printable">
  <h1>{$title}</h1>
  <div class="ui-form form-select-curso-especial" id="form-{$title|camelize}">
    <div class="ui-field">
      <label for="cod_programa">{#PNAT#}</label>
			{to_sql classname='TPrograma' assign=programas_sql}
			{html_select name='cod_programa' options=$programas_sql}
    </div>
    <div class="ui-field">
      <label for="cod_curso">Curso</label>
			{to_sql classname='CursoEspecial' assign=cursos_sql}
      {html_select name='cod_curso' options=$cursos_sql  extra=$extra title='Curso'}
    </div>
    <div class="ui-button-bar">
      <button id="bt-{$title|camelize}">Consultar</button>
    </div>
		{$links}
  </div>
</div>