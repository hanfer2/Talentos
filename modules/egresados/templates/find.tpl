<div class="decorated ui-widget">
  <h1>Listado de Egresados</h1>
  <div class="ui-form" id="form-listadoEgresados">
    <div class="ui-field" id="select-programa">
      <label> {#PNAT#}</label> 
			{info classname='TPrograma' func='toSQL' assign='programas_sql'}
			{html_select name='cod_programa' options=$programas_sql}
    </div>
    <div class="ui-field">
      <label>Tipo: </label>
      {html_select name='tipo' options=$tipos}
    </div>
    <div class="ui-button-bar">
      <button id="bt-listadoEgresados">Consultar</button>
    </div>
    <div class="ui-toolbar">
			{link_to name='Registrar Nuevo Egresado' controller='egresados' action='add'}
    </div>
  </div>
</div>
<div class="ajax-response"></div>
