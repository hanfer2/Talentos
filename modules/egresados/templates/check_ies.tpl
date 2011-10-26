<div class="ui-widget decorated">
{if $exists}
	<h1>Registrar Egresado con Ingreso a Educaci&oacute;n Superior</h1>
	<h2>{persona_url cedula=$cedula} - {$nombre_persona}</h2>
	{if $estaInactivo}
		<p class="error-message msg-s3_5"><span class="ui-icon left-icon ui-error-icon ui-icon-alert"></span>Este estudiante se encuentra inactivo</p>
	{elseif $estaReportado}
	<p>Este estudiante ya tiene registrado su Ingreso a Educaci&oacute;n Superior</p>
	<div>{link_to name="Ver Egresado" action=view cedula=$cedula}	</div>
	{else}
		{include_partial file="add.form.tpl"}
	{/if}
{else}
	{** SI EL ESTUDIANTE NO ES HALLADO **}
	{include_template file=error message="El estudiante identificado con el Doc.Id <strong>$cedula</strong>,<br/> no fue hallado en el sistema" title="Estudiante No Hallado"}
{/if}
</div>
