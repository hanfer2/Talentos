<div class="ui-widget decorated non-printable">
  <h1>{$title}</h1>
  <div class="ui-form" id="form-{$title|camelize}">
    <div class="ui-field">
      <label>{#PNAT#}</label>
			{info classname='TPrograma' func='toSQL' assign='programas_sql'}
			{html_select name='cod_programa' options=$programas_sql extra=$extra}
    </div>
    {$moreFields}
    <div class="ui-button-bar">
      <button id="bt-{$title|camelize}">Consultar</button>
    </div>
  </div>
  {if !empty($links)}{$links}{/if}
</div>
