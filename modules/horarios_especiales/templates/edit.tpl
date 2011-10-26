{if !isset($cod_curso)}
	{include_template file='curso_especial.form' title='Editar Horarios Especiales'}
	<div class="ajax-response" id='ajax-horarios'></div>
{else}
	<div class="ui-widget decorated widget-configurar-horarios">
    <h1>Editar Horarios Especiales</h1>
    <h2>{$nombre_curso}</h2>
    
    <div class="item-componente ui-corner-all">
      <span class="item-nombre_componente">{$componente.nombre}</span>
    </div>
    
	 <div id="fullcalendar-horarios_especiales" class='full-calendar'></div>
   <div class="clear"></div>

	</div>
{/if}
