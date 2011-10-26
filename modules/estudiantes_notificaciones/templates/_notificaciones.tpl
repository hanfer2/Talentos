
<div id="listado-notificaciones" class="accdn ui-corner-all">
 
{foreach from=$notificaciones item=notificacion}
	<div class="notificacion ui-corner-all accdn-item">
		<p class='notificacion-msg'>{$notificacion.mensaje|escape}</p>
		<span class="date tiny">{$notificacion.fecha_inicio|date_format}</span>
		{if $notificacion.fecha_fin}
		- <span class="date tiny">{$notificacion.fecha_fin|date_format}</span>
		{/if}
		<div class="ui-toolbar frm-1_5 rtoolbar">
      <a href="#{$link_delete}-{$notificacion.cod_mensaje}" class="link-icon link-delete"><span class="icon"></span> Eliminar</a>
    
		</div>
		<div class="clear"></div>
	</div>
{/foreach}
<p id="cantidad-notificaciones" class="accdn-summary">{$notificaciones|@count} notificaciones</p>
</div>

