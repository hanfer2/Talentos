<div class="ui-widget decorated non-printable ">
  <h1>{$title}</h1>
  <div class="ui-form form-simulacrosSinPrueba" id="form-{$title|camelize}">
    <div class="ui-field">
      <label>{#PNAT#}</label>
			{info classname='TPrograma' func='toSQL' assign='programas_sql'}
			{html_select name='cod_programa' options=$programas_sql extra=$extra}
    </div>
    <div class='ui-field'>
			<label>Simulacro</label>
			{info classname='ITIpo' func='simulacros' assign='simulacros_sql'}
			{html_select name='cod_prueba' options=$simulacros_sql}
    </div>
    {$moreFields}
    <div class="ui-button-bar">
      <button id="bt-{$title|camelize}">Consultar</button>
    </div>
  </div>
  {if !empty($links)} $links{/if}
</div>
