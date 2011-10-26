<div class='ui-widget decorated'>
	<h1>Horario</h1>
	{if isset($cedula)}<h2>{persona_url cedula=$cedula id='link-cedula'} - {$nombre_persona|escape}</h2>{/if}
	{if isset($nombre_curso)}
		{if is_admin_login()}
			<h3> Curso {link_to name=$nombre_curso controller='cursos' action=view cod_curso=$cod_curso}</h3>
		{else}
			<h3> Curso {$nombre_curso}</h3>
		{/if}
		<span class='hidden' id='sp-cod_curso'>{$cod_curso}</span>
	{/if}
	<div class='fullCalendar'></div>
</div>
