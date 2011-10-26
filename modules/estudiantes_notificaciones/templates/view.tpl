<h1>Listado de Notificaciones</h1>
{if isset($cedula)}
<h2>{$cedula}-{$nombre_persona}</h2>
{elseif isset($global) and $global eq 1}
<h2>A todos los participantes</h2>
{elseif isset($cod_curso)}
<h2>Curso {$nombre_curso}</h2>
{elseif isset($cod_grupo)}
<h2> Grupo {$cod_grupo}</h2>
{/if}

<div id="panel-enotificaciones">
	
	<div class="rtoolbar"><a href="#" id="link-nuevaNotificacion" class="link-add rlink"><span class="icon"></span>Nueva Notificaci&oacute;n</a></div>
	 {include_partial file='add.tpl' module="estudiantes_notificaciones" }
   {include_partial file='_notificaciones.tpl' module="estudiantes_notificaciones" }
    
</div>
