<h3 class="ui-state-default ui-corner-top"><span class="counter">{$counter}.</span> Cargar {$tipo|ucwords}</h3>
<form action="{url_for action=cargar_participantes}" method="post" enctype="multipart/form-data" class="frm-3">
  <label>Listado de Participantes:</label><input name="participante" type="file"/><br/>
  <input type="hidden" name="tipo" value="{$tipo}"/>
  <button>Cargar</button>
</form>
