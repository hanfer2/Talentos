<div class="ui-widget decorated">
  <h1>Registrar nueva Carrera</h1>
  <form action="{url_for controller='carreras' action='add'}+++" method="post">
    <div class="ui-field">
      <label for="carrera_cod_ciudad">Ciudad</label>
      <?php echo html_select_tag_by_query('carrera[cod_ciudad]', TCiudad::toSQL())?>
    </div>
    <div class="ui-field">
      <label for="universidad_nombre">Universidad</label>
      <input id="universidad_nombre"/>
      <input type="hidden" name="carrera[cod_universidad]"/>
    </div>
    <div class="ui-field">
      <label for="carrera_nombre">Nombre</label>
      <input id="carrera_nombre" name="carrera[nombre]"/>
    </div>
    <div class="ui-button-bar">
      <button>Crear</button>
    </div>
  </form>
</div>