<?php /* Smarty version 2.6.26, created on 2011-11-16 16:38:57
         compiled from modules/horarios/templates/_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select', 'modules/horarios/templates/_form.tpl', 14, false),)), $this); ?>
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
			<?php echo smarty_function_html_select(array('name' => 'horario_periodicidad','options' => $this->_tpl_vars['periodicidades'],'selected' => 1), $this);?>

		</div>
	</div>
	<div id='wrapper-horario-info' class="boxed">
		<div class='ui-field'>
			<label for="horario_sede">Sede:</label>
			<?php echo smarty_function_html_select(array('name' => 'horario[sede]','options' => $this->_tpl_vars['sedes']), $this);?>

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
			<?php echo smarty_function_html_select(array('name' => 'horario[cod_docente]','options' => $this->_tpl_vars['docentes']), $this);?>

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