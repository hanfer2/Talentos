{if !isset($cedula)}
		{include_template file='persona.form' title="Listado de Observaciones"}
 
	<div class='ajax-request'></div>
{else}
{include_partial file='new.tpl' module="observaciones"}
<div class='ui-widget decorated'>
	<h1>Listado de Observaciones Individual</h1>
	<h2>{persona_url cedula=$cedula} - {$nombre_persona}</h2>
	
	<div id='wrapper-listado-observaciones' class="frm-6">
	{foreach from=$observaciones key=tipo item=anotaciones}
		<div id='wrapper-{$tipo|lower}' class='wrapper-tipoObservacion ui-corner-all'>
			<h4 class='ui-state-default'>{$tipo|capitalize|escape} ({$tipo|@count})</h4>
			<div id='inner-{$tipo|lower}' class='inner-observaciones'>
			{foreach from=$anotaciones item=observacion name=observaciones}
				<div class='ui-widget-content ui-corner-all observacion-content' id='observacion-{$observacion.codigo}'>
					<h2 class='observacion-idx'> {$tipo|capitalize} No. {$smarty.foreach.observaciones.iteration}</h2>
					<p class="observacion-text">{$observacion.observacion|escape}</p>
					<div class="date">{$observacion.fecha_registro|date_format}</div>
					<div class='ui-toolbar'>
						<a id="prueba1" href='#{$observacion.codigo}' class='link-delete link-eliminarObservacion'><span class='ui-icon ui-icon-close link-icon inline-icon'></span>Eliminar</a>
					</div>
				</div>
			{/foreach}
			</div>
		</div>
	{foreachelse}
		<p>Este estudiante no tiene observaciones registradas</p>
	{/foreach}
	</div>
	
	<div id='ui-toolbar'>
		<a href="#" id="link-toggleNuevaObservacion">Agregar Nueva Observacion</a>
	</div>

</div>
{/if}
