<?php /* Smarty version 2.6.26, created on 2011-11-02 15:12:30
         compiled from ./modules/i_cuestionarios_estudiantes/templates//add.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/i_cuestionarios_estudiantes/templates//add.tpl', 2, false),array('function', 'url_for', './modules/i_cuestionarios_estudiantes/templates//add.tpl', 18, false),array('modifier', 'markdown', './modules/i_cuestionarios_estudiantes/templates//add.tpl', 12, false),array('modifier', 'zeropad', './modules/i_cuestionarios_estudiantes/templates//add.tpl', 32, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_prueba'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'simulacros_con_cuestionario','title' => 'Cargar Notas'), $this);?>

	<div class='ajax-response ajax-buscarUsuario'></div>
<?php else: ?>
	<?php if (! isset ( $this->_tpl_vars['cedula'] )): ?>
		<?php echo smarty_function_include_template(array('file' => "persona.form",'title' => 'Cargar Notas Simulacro'), $this);?>

		<input type="hidden" name="cod_prueba" id="cod_prueba" value="<?php echo $this->_tpl_vars['cod_prueba']; ?>
"/>
		<div class='ajax-response' id='ajax-cargarNotasSimulacro'></div>
	<?php else: ?>
	<div class='decorated ui-widget'>
		<?php if ($this->_tpl_vars['nombre_persona'] == null): ?>
			<?php echo smarty_function_include_template(array('file' => 'error','message' => ((is_array($_tmp="USUARIO **".($this->_tpl_vars['cedula'])."** NO HALLADO")) ? $this->_run_mod_handler('markdown', true, $_tmp) : smarty_modifier_markdown($_tmp))), $this);?>

		<?php else: ?>
		<h1>Subir Notas <?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h1>
		<h2><?php echo $this->_tpl_vars['cedula']; ?>
 - <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
			<?php if ($this->_tpl_vars['estudianteCalificado']): ?>
				<p>El cuestionario de este participante ya ha sido registrado</p>
				<a href="<?php echo smarty_function_url_for(array('action' => 'view','cod_prueba' => $this->_tpl_vars['cod_prueba'],'cedula' => $this->_tpl_vars['cedula']), $this);?>
" target="_blank">Consultar Formulario de este Participante</a>
			<?php elseif ($this->_tpl_vars['preguntas'] == null): ?>
				<p>Esta prueba no tiene asociado un cuestionario aún</p>
			<?php else: ?>
				<form action="<?php echo smarty_function_url_for(array('action' => 'save'), $this);?>
" method="post" id="form-subirCuestionarioCalificado">
					<input type="hidden" value="<?php echo $this->_tpl_vars['cedula']; ?>
" name="cedula"/>
					<input type="hidden" value="<?php echo $this->_tpl_vars['cod_prueba']; ?>
" name="cod_prueba"/>
					<?php $_from = $this->_tpl_vars['preguntas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nombre_componente'] => $this->_tpl_vars['preguntasComponente']):
?>
					<div class="wrapper-respuestasComponente">
						<h5 class='header-nombreComponente ui-state-default'><span class="h-text"><?php echo $this->_tpl_vars['nombre_componente']; ?>
</span><span class="icon-status"></span></h5>
						<div class="inner-respuestasComponente hidden">
						<?php $_from = $this->_tpl_vars['preguntasComponente']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pregunta_componente'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pregunta_componente']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pregunta']):
        $this->_foreach['pregunta_componente']['iteration']++;
?>
						<div class="questions-line-field">
							<div  class="ui-field inline pregunta-numeral">
								Pregunta <?php echo ((is_array($_tmp=$this->_tpl_vars['pregunta']['numeral'])) ? $this->_run_mod_handler('zeropad', true, $_tmp, 3) : zeropad($_tmp, 3)); ?>
: <input class='input-helper' tabindex="<?php echo $this->_foreach['pregunta_componente']['iteration']; ?>
" style="width:10mm"/>
							</div>
							<div class='letras-respuestas ui-field inline'>
							<?php $_from = $this->_tpl_vars['letras']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['letra']):
?>
								<label class="lb-letraRespuesta" for="respuestas_<?php echo $this->_tpl_vars['pregunta']['codigo']; ?>
_<?php echo $this->_tpl_vars['letra']; ?>
"><?php echo $this->_tpl_vars['letra']; ?>
</label> 
								<input type="checkbox" value="t" name="respuestas[<?php echo $this->_tpl_vars['pregunta']['codigo']; ?>
][<?php echo $this->_tpl_vars['letra']; ?>
]" id="respuestas_<?php echo $this->_tpl_vars['pregunta']['codigo']; ?>
_<?php echo $this->_tpl_vars['letra']; ?>
"/>
							<?php endforeach; endif; unset($_from); ?>
							</div>
							<div class='status-icon inline'></div>
						</div>
						<?php endforeach; endif; unset($_from); ?>
						</div>
					</div>
					<?php endforeach; endif; unset($_from); ?>
					<div class='ui-button-bar'>
						<button type="button" id="bt-subirCuestionarioCalificado">Aceptar</button>
					</div>
				</form>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>
<?php endif; ?>