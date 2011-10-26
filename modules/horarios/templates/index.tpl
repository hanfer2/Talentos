{if !isset($cod_curso)}
	{include_template file='cursos_all' title='Horarios Por Cursos'}
	<div class="ajax-response" id='ajax-horarios'></div>
{else}
	<div class="ui-widget decorated">
	 <div id="full-calendar" class='full-calendar'></div>
	</div>
{/if}

