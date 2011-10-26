<div class="ui-widget decorated non-printable">
  <h1>Informe de Docentes</h1>
  <div class="ui-form ui-form-inline" id="form-informe">
    <div class="ui-field">
      <label>{#PNAT#}</label>
			{info classname='TPrograma' func='toSQL' assign='programas_sql' }
      {html_select name='cod_programa'  options=$programas_sql}
    </div>
    <div id="div-seleccionaTipoInformeDocentes">
      <div class="ui-field inline">
        <label>Por Componente</label>
				{info classname='TComponente' func='toSQL' assign='componentes_sql' }
				{html_select name='cod_componente'  options=$componentes_sql}
      </div>
      <div class="ui-field inline">
        <label>Por Cursos</label>
				{info classname='TSubgrupo' func='toSQL' assign='subgrupos_sql' }
				{html_select name='cod_curso'  options=$subgrupos_sql}
      </div>
    </div>
  </div>
  <div id="ajax-docentes-informe"></div>
  
</div>
