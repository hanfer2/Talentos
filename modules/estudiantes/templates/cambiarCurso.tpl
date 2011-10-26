{if $cod_curso != null} {*Si tiene algun curso*}
	<div class='ui-form' id='form-cambiarCurso'>
		<h3>{$nombre_persona}</h3>
		<div class='ui-field'>
			<label>Curso Actual</label>
			<span class='inputable center' id='sp-nombre_curso_actual'>{$nombre_curso}</span>
		</div>
		<div class='ui-field'>
			<label>Nuevo Curso </label>
			{html_select name='persona[cod_curso]' options=$cursos}
		</div>
		<input type='hidden' name=persona[cod_interno] value='{$cod_interno}'/>
		<div class='ui-button-bar'>
			<button id='bt-cambiarCurso'>Cambiar Curso</button>
		</div>
	</div>
{else} {*Si no pertenece a ningun curso*}
	<div class='ui-form ui-form form-select-curso' id='form-asignarCurso'>
		<h3>{$nombre_persona}</h3>
		<div class="ui-field">
      <label for="cod_programa">{#PNAT#}</label>
			{to_sql classname='TPrograma' assign=programas_sql}
			{html_select name='cod_programa' options=$programas_sql}
    </div>
    <div class="ui-field">
      <label for="cod_curso">Curso</label>
			{to_sql classname='TSubgrupo' assign=cursos_sql}
      {html_select name='cod_curso' options=$cursos_sql title='Curso' }
    </div>
		<input type='hidden' name=persona[cod_interno] value='{$cod_interno}'/>
		<div class='ui-button-bar'>
			<button id='bt-asignarCurso'>Asignar Curso</button>
		</div>
	</div>
{/if}
