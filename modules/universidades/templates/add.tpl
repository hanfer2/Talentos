<div class="ui-widget decorated"> 
  <h1>Creaci&oacute;n de Universidades</h1>
  <div class="ui-form" id="form-crearUniviersidad" style="width:9cm">
    <div class="ui-field">
      <label for="universidad_cod_ciudad">Ciudad</label>
      {html_select name="universidad[cod_ciudad]" options=$ciudades selected=$smarty.const.COD_CIUDAD_CALI}
    </div>
    <div class="ui-field">
      <label for="universidad_nombre" class="required">Nombre</label>
      <input name="universidad[nombre]" maxlength=100 size=28/>
    </div>
    <div class="ui-field">
      <label for="nombre">Abreviatura</label>
      <input name="universidad[abreviatura]" maxlength=15 size=28/>
    </div>
    <div class="ui-button-bar">
      <button id="bt-crearUniversidad"> Aceptar</button>
    </div>
  </div>
  <div class="ui-toolbar">
  {link_to name="Listado de Universidades"} |
  {link_to name="Listado de Carreras" controller=Carreras} |
  {link_to name="Listado de Egresados" controller=Egresados} |
  {link_to name="Registrar Egresado" controller=Egresados action=add}
  </div>
</div>
