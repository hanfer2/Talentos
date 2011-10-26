<?php /* Smarty version 2.6.26, created on 2011-07-05 14:30:14
         compiled from modules/estudiantes/templates/cambiarCurso.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_select', 'modules/estudiantes/templates/cambiarCurso.tpl', 10, false),array('function', 'to_sql', 'modules/estudiantes/templates/cambiarCurso.tpl', 22, false),)), $this); ?>
<?php if ($this->_tpl_vars['cod_curso'] != null): ?> 	<div class='ui-form' id='form-cambiarCurso'>
		<h3><?php echo $this->_tpl_vars['nombre_persona']; ?>
</h3>
		<div class='ui-field'>
			<label>Curso Actual</label>
			<span class='inputable center' id='sp-nombre_curso_actual'><?php echo $this->_tpl_vars['nombre_curso']; ?>
</span>
		</div>
		<div class='ui-field'>
			<label>Nuevo Curso </label>
			<?php echo smarty_function_html_select(array('name' => 'persona[cod_curso]','options' => $this->_tpl_vars['cursos']), $this);?>

		</div>
		<input type='hidden' name=persona[cod_interno] value='<?php echo $this->_tpl_vars['cod_interno']; ?>
'/>
		<div class='ui-button-bar'>
			<button id='bt-cambiarCurso'>Cambiar Curso</button>
		</div>
	</div>
<?php else: ?> 	<div class='ui-form ui-form form-select-curso' id='form-asignarCurso'>
		<h3><?php echo $this->_tpl_vars['nombre_persona']; ?>
</h3>
		<div class="ui-field">
      <label for="cod_programa"><?php echo $this->_config[0]['vars']['PNAT']; ?>
</label>
			<?php echo smarty_function_to_sql(array('classname' => 'TPrograma','assign' => 'programas_sql'), $this);?>

			<?php echo smarty_function_html_select(array('name' => 'cod_programa','options' => $this->_tpl_vars['programas_sql']), $this);?>

    </div>
    <div class="ui-field">
      <label for="cod_curso">Curso</label>
			<?php echo smarty_function_to_sql(array('classname' => 'TSubgrupo','assign' => 'cursos_sql'), $this);?>

      <?php echo smarty_function_html_select(array('name' => 'cod_curso','options' => $this->_tpl_vars['cursos_sql'],'title' => 'Curso'), $this);?>

    </div>
		<input type='hidden' name=persona[cod_interno] value='<?php echo $this->_tpl_vars['cod_interno']; ?>
'/>
		<div class='ui-button-bar'>
			<button id='bt-asignarCurso'>Asignar Curso</button>
		</div>
	</div>
<?php endif; ?>