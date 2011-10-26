{if !isset($cod_curso)}
	{include_template file='curso.form' title='Configurar Horarios'}
	<div class="ajax-response"></div>
{else}
<div class="ui-widget decorated">
	<h1>Configuraci&oacute;n de Horarios</h1>
	<h2>{nombre_programa cod_programa=$cod_programa}</h2>
	{if empty($componentes)}
		<p class="error-zeroItems">No hay componentes registrados para este PNAT</p>
	{else}
	<form action="{url_for action=configurar}" method='post'>
		<input type='hidden' name='horario[cod_curso]' value='{$cod_curso}'/>
		<div class='wrapper-full-calendar' id='wrapper-full-calendar-{$cod_curso}'>
			<h2 class='ui-state-default'>Curso {$nombre_curso}</h2>
			<div class='wrapper-list-componentes'>
				{foreach from=$componentes item=componente name=componentes}	
					{assign var=cod_componente value=$componente.codigo}
					{assign var=info_horario value=$horario.$cod_componente[0]}
					<div class='wrapper-horario-componente'>
						<h5 class='nombre_componente ui-state-default'>{$componente.nombre|escape}</h5>
						<div class='wrapper-inner-componente'>
							<input type='hidden' name="horarios[{$componente.codigo}][cod_horario]" value='{$info_horario.cod_horario|default:"`$cod_curso``$cod_componente``$semestre`"}'/>
							<div class='wrapper-select-dia'>
								<label>D&iacute;a: </label>
								{html_select name="horarios[`$componente.codigo`][dia]" options=$dias_semana selected=$info_horario.dia|default:""}
							</div>
							<div>
								<label>Hora Inicio</label>
								<input class="hour hora-inicio" name='horarios[{$componente.codigo}][hora_inicio]' value='{$info_horario.hora_inicio|truncate:5:''}'/>
							</div>
							<div>
								<label>Hora Fin</label>
								<input class="hour hora-fin" name='horarios[{$componente.codigo}][hora_fin]' value='{$info_horario.hora_fin|truncate:5:''}'/>
							</div><br/>
							<div>
								<label>Fecha Inicio</label>
								<input class="date fecha-inicio" name='horarios[{$componente.codigo}][fecha_inicio]' value='{$info_horario.fecha_inicio}'/>
							</div>
							<div>
								<label>Fecha Fin</label>
								<input class="date fecha-fin" name='horarios[{$componente.codigo}][fecha_fin]' value='{$info_horario.fecha_fin}'/>
							</div><hr/>
							<div class='ui-field'>
								<label>Sede: </label>
								{html_select name="horarios[`$componente.codigo`][sede]" options=$sedes selected=$info_horario.sede|default:""}
							</div>
							<div class='ui-field'>
								<label>Edificio: </label>
								<input name='horarios[{$componente.codigo}][edificio]' maxlength="30" value='{$info_horario.edificio}'/>
							</div>
							<div class='ui-field'>
								<label>Sal&oacute;n </label>
								<input name='horarios[{$componente.codigo}][salon]' maxlength="30" value='{$info_horario.salon}'/>
							</div>
							<div class='ui-field'>
								<label>Docente</label>
							{html_select name="horarios[`$componente.codigo`][cod_docente]" options=$docentes selected=$info_horario.cod_docente|default:""}
							</div>
							<div>
								<label>Observaciones</label>
								<textarea rows='5' name='horarios[{$componente.codigo}][observaciones]'>{$info_horario.observaciones}</textarea>
							</div>
						</div>
					</div>
					{if $smarty.foreach.componentes.iteration % 3 eq 0}<div class="clear"></div>{/if}
				{/foreach}
			</div>
		</div>

		<div class='button-bar'>
			<button>Aceptar</button>
		</div>
	</form>
		{/if}
</div>
{/if}
