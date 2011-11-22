<?php /* Smarty version 2.6.26, created on 2011-11-02 15:46:00
         compiled from ./modules/i_cuestionarios_estudiantes/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 2, false),array('function', 'url_for', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 17, false),array('function', 'persona_url', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 22, false),array('function', 'link_to', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 26, false),array('modifier', 'underscorify', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 13, false),array('modifier', 'zeropad', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 57, false),array('modifier', 'upper', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 60, false),array('modifier', 'lower', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 76, false),array('modifier', 'substr', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 76, false),array('modifier', 'array_sum', './modules/i_cuestionarios_estudiantes/templates//view.tpl', 108, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_prueba'] )): ?>
	<?php echo smarty_function_include_template(array('file' => 'simulacros_con_cuestionario','title' => 'Mostrar Respuestas De Participante'), $this);?>

	<div class='ajax-response'></div>
<?php else: ?>
	<?php if (! isset ( $this->_tpl_vars['cedula'] )): ?>
		<?php echo smarty_function_include_template(array('file' => "persona.form",'title' => 'Mostrar Respuestas De Participante En Simulacro'), $this);?>

		<div class='ajax-response' id='ajax-mostrarNotasSimulacro'></div>
	<?php else: ?>
		<div class='ui-widget decorated'>
			<div class="menu sidebar sb-r sidebar-fixed">
				<h3 class="ui-state-default">COMPONENTES</h3>
				<?php $_from = $this->_tpl_vars['respuestas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nombre_componente'] => $this->_tpl_vars['preguntas']):
?>
					<a href="#c-<?php echo ((is_array($_tmp=$this->_tpl_vars['nombre_componente'])) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)); ?>
"><?php echo $this->_tpl_vars['nombre_componente']; ?>
</a>
				<?php endforeach; endif; unset($_from); ?>
        <?php if (is_root_login ( ) || $this->_tpl_vars['is_digita_icfes_login']): ?>
				<hr/>
				<a href="<?php echo smarty_function_url_for(array('action' => 'edit','cedula' => $this->_tpl_vars['cedula'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>
" class="link-edit"><span class="icon"></span> Editar Respuestas</a>
        <?php endif; ?>
			</div>
			
			<h1>Respuestas De Participante en <?php echo $this->_tpl_vars['nombre_prueba']; ?>
</h1>
			<h2><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
 - <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
			
					
			<div class="ui-toolbar">
				<?php echo smarty_function_link_to(array('name' => 'Consultar Icfes','controller' => 'icfes','action' => 'view','cedula' => $this->_tpl_vars['cedula']), $this);?>
 |
				<?php if ($this->_tpl_vars['cantidad_respuestas'] > 0): ?>
					<?php echo smarty_function_link_to(array('name' => 'Reporte Competencias','controller' => 'i_competencias_estudiantes','action' => 'view','cedula' => $this->_tpl_vars['cedula'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>
 | 
					<?php echo smarty_function_link_to(array('name' => "Reporte Componentes/Cualitativos",'controller' => 'i_cualitativos_estudiantes','action' => 'view','cedula' => $this->_tpl_vars['cedula'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>

				
				<?php else: ?>
				<a class="link-add" href="<?php echo smarty_function_url_for(array('action' => 'add','cedula' => $this->_tpl_vars['cedula'],'cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>
"><span class="icon ui-icon error-icon"></span>Ingresar Notas</a>
				<?php endif; ?>
			</div>
			<?php if ($this->_tpl_vars['cantidad_respuestas'] > 0): ?>
			<div class="frm-4 info-summary ui-corner-all">
				Cantidad de Preguntas Respondidas: <strong><?php echo $this->_tpl_vars['cantidad_respuestas']; ?>
</strong><br/>
				<?php if (is_root_login ( )): ?>
				Diligenciado Por: <strong><?php echo $this->_tpl_vars['nombre_digitador']; ?>
</strong><br/>
				<?php endif; ?>
			</div>
			<?php else: ?>
			<div class="ui-state-notice ui-corner-all frm-3"><span class="ui-icon ui-icon-alert left-icon error-icon"></span>Este cuestionario no ha sido diligenciado a&uacute;n</div>
			<?php endif; ?>
			<div class="fg-toolbar center ui-helper-clearfix" id="menu-toggleRespuestasComponentes">
						<a href="#" class="fg-button fg-button-icon-left ui-state-default ui-corner-left" id="link-expandAll"><span class="ui-icon ui-icon-plus"></span>Expandir Todo</a>
						<a href="#" class="fg-button fg-button-icon-right ui-state-default ui-corner-right" id="link-contractAll">Contraer Todo<span class="ui-icon ui-icon-minus"></span></a>
			</div>
			
			<div class='wrapper-respuestasComponente'>
				<?php $_from = $this->_tpl_vars['respuestas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nombre_componente'] => $this->_tpl_vars['preguntas']):
?>
					<h5 class='header-nombreComponente ui-state-default' id="c-<?php echo ((is_array($_tmp=$this->_tpl_vars['nombre_componente'])) ? $this->_run_mod_handler('underscorify', true, $_tmp) : underscorify($_tmp)); ?>
"><?php echo $this->_tpl_vars['nombre_componente']; ?>
</h5>
					<div class="inner-respuestasComponente">
					<?php $_from = $this->_tpl_vars['preguntas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pregunta']):
?>
					<div class="questions-line-field fixed-width">
						<div class='ui-field inline'>
							Pregunta <?php echo ((is_array($_tmp=$this->_tpl_vars['pregunta']['numeral'])) ? $this->_run_mod_handler('zeropad', true, $_tmp, 3) : zeropad($_tmp, 3)); ?>
:
						</div>
						<?php $_from = $this->_tpl_vars['letras']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['letra']):
?>
							<div class='ui-field inline <?php if (! $this->_tpl_vars['is_digita_icfes_login'] && in_array ( ((is_array($_tmp=$this->_tpl_vars['letra'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)) , $this->_tpl_vars['pregunta']['respuesta'] )): ?>letraConRespuestaCorrecta ui-corner-all<?php endif; ?> <?php if ($this->_tpl_vars['pregunta'][$this->_tpl_vars['letra']] == 't'): ?>letra-escogida<?php endif; ?>'>
								<label class="lb-letra"><?php echo ((is_array($_tmp=$this->_tpl_vars['letra'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)); ?>
</label>
								<span class='casilla resp-<?php echo $this->_tpl_vars['pregunta'][$this->_tpl_vars['letra']]; ?>
'>
								<?php if ($this->_tpl_vars['pregunta'][$this->_tpl_vars['letra']] == 't'): ?>&#9632;<?php else: ?>&#9633;<?php endif; ?>
								</span>
								
								<?php if (! $this->_tpl_vars['is_digita_icfes_login']): ?>
								<span class="placeholder"></span>
								<?php endif; ?>
							</div>
						<?php endforeach; endif; unset($_from); ?>
						<?php if ($this->_tpl_vars['is_digita_icfes_login'] || is_root_login ( )): ?>
							<a href="#<?php echo $this->_tpl_vars['cedula']; ?>
-<?php echo $this->_tpl_vars['cod_prueba']; ?>
-<?php echo $this->_tpl_vars['pregunta']['numeral']; ?>
" class="link-editarRespuesta edit link-edit"><span class="icon"></span> Editar</a>
						<?php endif; ?>
						<?php if (! $this->_tpl_vars['is_digita_icfes_login'] || $this->_tpl_vars['pregunta']['VALORACION'] == 'VACIAS'): ?>
							<div class="ui-field inline nota-valoracion">
								<span class='respuesta-<?php echo ((is_array($_tmp=$this->_tpl_vars['pregunta']['VALORACION'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
'><?php echo ((is_array($_tmp=$this->_tpl_vars['pregunta']['VALORACION'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, -1) : substr($_tmp, 0, -1)); ?>
</span>
							</div>
						<?php endif; ?>
					</div>
					<?php endforeach; endif; unset($_from); ?>
				</div>
				<?php if (! $this->_tpl_vars['is_digita_icfes_login']): ?>
					<div class="question-line-field fixed-width subtotal-valoracion">
						<?php $_from = $this->_tpl_vars['resumen'][$this->_tpl_vars['nombre_componente']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['valoracion'] => $this->_tpl_vars['subtotal']):
?>
							<?php if ($this->_tpl_vars['valoracion'] != 'NO CALIFICADAS'): ?>
								<div class="ui-field inline">
									<label class='respuesta-<?php echo ((is_array($_tmp=$this->_tpl_vars['valoracion'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
'>Total <?php echo $this->_tpl_vars['valoracion']; ?>
:</label><span><?php echo $this->_tpl_vars['subtotal']; ?>
</span>
								</div>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
					</div>
				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
			</div>
			
			<div>
				<?php if (! $this->_tpl_vars['is_digita_icfes_login'] && is_array ( $this->_tpl_vars['resumen']['GENERAL'] )): ?>
					<table class="table" id="table-resumenNotas">
						<caption>Resumen</caption>
					<?php $_from = $this->_tpl_vars['resumen']['GENERAL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['valoracion'] => $this->_tpl_vars['subtotal']):
?>
						<?php if ($this->_tpl_vars['valoracion'] != 'NO CALIFICADAS'): ?>
						<tr class="respuesta-<?php echo ((is_array($_tmp=$this->_tpl_vars['valoracion'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
">
							<th><?php echo $this->_tpl_vars['valoracion']; ?>
</th><td><?php echo $this->_tpl_vars['subtotal']; ?>
</td>
						</tr>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					<tr class="total">
						<th>TOTAL</th><td><?php echo array_sum($this->_tpl_vars['resumen']['GENERAL']); ?>
</td>
					</tr>
					</table>
				<?php endif; ?>
			</div>
			<div class="toTop">Arriba<span class="ui-icon"></span></div>
			<?php if ($this->_tpl_vars['is_digita_icfes_login']): ?>
			<?php echo smarty_function_link_to(array('name' => 'Volver','action' => 'add','cod_prueba' => $this->_tpl_vars['cod_prueba']), $this);?>

			<?php endif; ?>
			<?php if (is_root_login ( )): ?>
			<a href="#<?php echo $this->_tpl_vars['cedula']; ?>
-<?php echo $this->_tpl_vars['cod_prueba']; ?>
" id="link-eliminarCuestionario">Eliminar Cuestionario</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

<?php endif; ?>