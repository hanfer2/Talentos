{if !isset($cod_curso)}
	{include_template file='curso_especial.form' title='Horarios Cursos Especiales'}
	<div class="ajax-response" id='ajax-horarios'></div>
{else}
	<div class="ui-widget decorated">
    <h1>Horarios Cursos Especiales</h1>
    <h2>{$nombre_curso}</h2>
	 <div id="fullcalendar-horarios_especiales" class='full-calendar'>
   </div>
	</div>
{/if}
