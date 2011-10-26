<div class='ui-widget decorated'>
	<h1>{$title}</h1>
	<div class="ui-form form-select-grupo-curso" id="form-{$title|camelize}">
    <div class="ui-field">
      <label for="cod_programa">{#PNAT#}</label>
			{to_sql classname='TPrograma' assign=programas_sql}
			{html_select name='cod_programa' options=$programas_sql}
    </div>
    <div class="ui-field">
      <label for="cod_grupo">Grupos</label>

    </div>
    <div class="ui-field">
      <label for="cod_curso">Cursos</label>
			{to_sql classname='TSubgrupo' assign=cursos_sql}
      {html_select name='cod_curso' options=$cursos_sql  extra=$extra}
    </div>
    <div class="ui-button-bar">
      <button id="bt-{$title|camelize}">Consultar</button>
    </div>
		{$links}
  </div>
</div>

