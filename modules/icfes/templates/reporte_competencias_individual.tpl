<div class="ui-widget decorated">
<h1>Reporte de Competencias Por Curso</h1>
<h2>{$nombre_prueba} - Curso {$nombre_curso}</h2>
{if !isset($estudiantes)}
	<p>Este curso para esta prueba no presenta aún competencias registradas</p>
{else}
	{foreach from=$estudiantes item=estudiante}
	{/foreach}
{/if}
</div>
