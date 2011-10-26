<div class="ui-widget decorated non-printable ">
  <h1>{$title}</h1>
  <div class="ui-form form-simulacrosConCuestionario" id="form-{$title|camelize}">
		<p class="explanation-text">
				Seleccione la prueba cuyo cuestionario desea consultar.
		</p>
    <div class="ui-field">
      <label>{#PNAT#}</label>
			{info classname='TPrograma' func='toSQL' assign='programas_sql'}
			{html_select name='cod_programa' options=$programas_sql extra=$extra}
    </div>
    <div class='ui-field'>
			<label>Simulacro</label>
			{info classname='ITIpo' func='simulacrosConCuestionario' assign='simulacros_sql'}
			{html_select name='cod_prueba' options=$simulacros_sql}
    </div>
    {$moreFields}
    <div class="ui-button-bar">
      <button id="bt-{$title|camelize}">Consultar</button>
    </div>
    <p class="notice-text bottom-notice">
			 <strong class='text-notice-label'>Nota:</strong> Aquí <strong>SÓLO</strong> se listan los Simulacros con Cuestionarios Registrados 
		</p>
  </div>
  
  {if !empty($links)} $links{/if}
</div>
