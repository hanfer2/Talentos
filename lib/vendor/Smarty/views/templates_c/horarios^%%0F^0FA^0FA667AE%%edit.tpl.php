<?php /* Smarty version 2.6.26, created on 2011-11-28 17:19:38
         compiled from modules/horarios/templates/edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', 'modules/horarios/templates/edit.tpl', 3, false),array('function', 'link_open_external', 'modules/horarios/templates/edit.tpl', 10, false),array('function', 'include_partial', 'modules/horarios/templates/edit.tpl', 47, false),array('modifier', 'escape', 'modules/horarios/templates/edit.tpl', 33, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cod_curso'] )): ?>
  <?php if ($_GET['t'] == 'ce'): ?>
    <?php echo smarty_function_include_template(array('file' => "curso_especial.form",'title' => 'Configurar Horarios Especiales'), $this);?>

  <?php elseif (! isset ( $this->_tpl_vars['semestre'] )): ?>
    <?php echo smarty_function_include_template(array('file' => 'cursos_con_semestres','title' => 'Configurar Horarios'), $this);?>

  <?php endif; ?>
	<div class='ajax-request' id="ajax-horarios-edit"></div>
<?php else: ?>
	<div class='ui-widget decorated' id='widget-configurar-horarios'>
  <?php echo smarty_function_link_open_external(array(), $this);?>

		<h1>Editar Horarios</h1>
		<h2><span title="PNAT <?php echo $this->_tpl_vars['cod_programa']; ?>
, Semestre <?php echo $this->_tpl_vars['semestre']; ?>
" class="tooltip">
			PNAT <?php echo $this->_tpl_vars['cod_programa']; ?>
-<span id="horario-semestre-valor"><?php echo $this->_tpl_vars['semestre']; ?>
</span></span> :: Curso <?php echo $this->_tpl_vars['nombre_curso']; ?>

		</h2>
		<span id='horario-cod_curso' class='ui-helper-hidden'><?php echo $this->_tpl_vars['cod_curso']; ?>
</span>
		
		<?php if (empty ( $this->_tpl_vars['componentes'] )): ?>
		<div class='notice-error'>
			<span class="t-icon-alert t-icon-alert-64 left-icon"></span>
			<p class='ui-state-error-text'>No hay componentes registrados<br/>para este semestre</p>
			<span class="clear"></span>
		</div>
		<?php else: ?>
			<!-- FULLCALENDAR-->
			<div class='full-calendar' id='calendar-editHorarios'></div>
			
			<!-- Listado de Componentes-->
			<div id='wrapper-listadoDeComponentes' class='ui-corner-all'>
				<h4 class='ui-state-default'>Componentes</h4>
				<div id='inner-listadoDeComponentes'>
					<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
					<div class='item-componente ui-corner-all draggable'>
						<input type="checkbox" /> <span class='item-nombre_componente'><?php echo ((is_array($_tmp=$this->_tpl_vars['componente']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 </span>
						<span class='hidden item-cod_componente'><?php echo $this->_tpl_vars['componente']['codigo']; ?>
</span>
					</div>
					<?php endforeach; else: ?>
						<div>No hay componentes asignados</div>
					<?php endif; unset($_from); ?>
				</div>
			</div>
			
			<div class="clear"></div>
			
      <span class="ui-helper-hidden" id="horario-fechaInicio-valor"><?php echo $this->_tpl_vars['fechas']['inicio']; ?>
</span> 
			<span class="ui-helper-hidden" id="horario-fechaCierre-valor"><?php echo $this->_tpl_vars['fechas']['cierre']; ?>
</span> 
			
			<?php echo smarty_function_include_partial(array('file' => "_form.tpl",'sedes' => $this->_tpl_vars['sedes'],'docentes' => $this->_tpl_vars['docentes'],'periodicidad' => $this->_tpl_vars['periodicidad']), $this);?>

		<?php endif; ?>
	</div>
<?php endif; ?>