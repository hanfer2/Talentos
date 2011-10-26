<div id='dialog-nuevoHorario' class='dialog ui-form'>
	<h3 class="h-3"></h3>
	<div id="wrapper-horario-fechas" class="boxed">
		<div class="ui-field">
			<label for="horario_fecha_inicio">Fecha Inicio:</label>
			<input class="date required" id="horario_fecha_inicio"/>
		</div>
		<div class='ui-field'>
			<label for="horario_fecha_cierre">Fecha Fin:</label>
			<input class="date required" id="horario_fecha_cierre"/>
		</div>
		<div class='ui-field'>
			<label>Periodicidad:</label>
			{html_select name="horario_periodicidad" options=$periodicidades selected=1}
		</div>
	</div>
	<div id='wrapper-horario-info' class="boxed">
		<div class='ui-field'>
			<label for="horario_sede">Sede:</label>
			{html_select name='horario[sede]' options=$sedes }
		</div>
		<div class='ui-field'>
			<label for="horario_edificio">Edif:</label>
			<input name='horario[edificio]' id="horario_edificio"/>
		</div>
		<div class='ui-field'>
			<label for="horario_salon">Sal&oacute;n:</label>
			<input name='horario[salon]'id="horario_salon"/>
		</div>
		<div class='ui-field'>
			<label for="horario_cod_docente">Docente:</label>
			{html_select name='horario[cod_docente]' options=$docentes}
		</div>
		<div>
		<label class='textarea-label' for="horario_anuncios">Anuncios:</label>
			<textarea name='horario[anuncios]' cols="27" rows="10" id="horario_anuncios"></textarea>
		</div>
		
		<!-- DATOS OCULTOS-->
		<input type="hidden" name="cod_componente" id="nuevoHorario-cod_componente"/>
		<input type="hidden" name="hora_inicio" id="nuevoHorario-hora_inicio"/>
	</div>
</div>
