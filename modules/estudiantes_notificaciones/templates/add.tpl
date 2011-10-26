<div class="ui-form frm-5 hfrm boxed" id="wrapper-new-notificacion">
	<h2>Nueva Notificaci&oacute;n</h2>
	<label for="notificacion_fecha_inicio" class="required">Fecha Inicio</label><input class="date" name="notificacion[fecha_inicio]" id="notificacion_fecha_inicio" value="{'now'|date_format:'%Y-%m-%d'}"/>
	<label for="notificacion_fecha_fin">Fecha Fin</label><input class="date" name="notificacion[fecha_fin]" id="notificacion_fecha_fin"/>
	<div><label class="required" for="notificacion_mensaje">Mensaje:</label><br/><textarea cols="60" rows="10" id="notificacion_mensaje" name="notificacion[mensaje]"></textarea></div>
	<div class="ui-button-bar">
		<button class="ui-button ui-widget ui-corner-all ui-state-default ui-button-text-icon right-button" id="bt-agregarNotificacion">
			<span class="ui-icon ui-icon-disk ui-button-icon-primary"></span><span class="ui-button-text">Guardar</span>
		</button>
		<button class="ui-button ui-widget ui-corner-all ui-state-default ui-button-text-icon right-button" id="bt-cancelarNuevaNotificacion">
			<span class="ui-icon ui-icon-close ui-button-icon-primary"></span><span class="ui-button-text">Cancelar</span>
		</button>
	</div>
  {if isset($cedula)}
    <input type="hidden" name="cedula" value="{$cedula}"/>
  {elseif isset($global) and $global eq 1 }
    <input type="hidden" name="global" value="1"/>
  {elseif isset($cod_curso)}
    <input type="hidden" name="cod_curso" value="{$cod_curso}"/>
  {elseif isset($cod_grupo)}
    <input type="hidden" name="cod_grupo" value="{$cod_grupo}"/>
  {/if}
	<div class="clear"></div>
</div>
