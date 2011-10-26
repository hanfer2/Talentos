<?php /* Smarty version 2.6.26, created on 2011-10-07 16:49:45
         compiled from ./modules/observaciones/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_template', './modules/observaciones/templates//view.tpl', 2, false),array('function', 'include_partial', './modules/observaciones/templates//view.tpl', 6, false),array('function', 'persona_url', './modules/observaciones/templates//view.tpl', 9, false),array('modifier', 'lower', './modules/observaciones/templates//view.tpl', 13, false),array('modifier', 'capitalize', './modules/observaciones/templates//view.tpl', 14, false),array('modifier', 'escape', './modules/observaciones/templates//view.tpl', 14, false),array('modifier', 'count', './modules/observaciones/templates//view.tpl', 14, false),array('modifier', 'date_format', './modules/observaciones/templates//view.tpl', 20, false),)), $this); ?>
<?php if (! isset ( $this->_tpl_vars['cedula'] )): ?>
		<?php echo smarty_function_include_template(array('file' => 'persona.form','title' => 'Listado de Observaciones'), $this);?>

 
	<div class='ajax-request'></div>
<?php else: ?>
<?php echo smarty_function_include_partial(array('file' => 'new.tpl','module' => 'observaciones'), $this);?>

<div class='ui-widget decorated'>
	<h1>Listado de Observaciones Individual</h1>
	<h2><?php echo smarty_function_persona_url(array('cedula' => $this->_tpl_vars['cedula']), $this);?>
 - <?php echo $this->_tpl_vars['nombre_persona']; ?>
</h2>
	
	<div id='wrapper-listado-observaciones' class="frm-6">
	<?php $_from = $this->_tpl_vars['observaciones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tipo'] => $this->_tpl_vars['anotaciones']):
?>
		<div id='wrapper-<?php echo ((is_array($_tmp=$this->_tpl_vars['tipo'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
' class='wrapper-tipoObservacion ui-corner-all'>
			<h4 class='ui-state-default'><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['tipo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 (<?php echo count($this->_tpl_vars['tipo']); ?>
)</h4>
			<div id='inner-<?php echo ((is_array($_tmp=$this->_tpl_vars['tipo'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
' class='inner-observaciones'>
			<?php $_from = $this->_tpl_vars['anotaciones']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['observaciones'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['observaciones']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['observacion']):
        $this->_foreach['observaciones']['iteration']++;
?>
				<div class='ui-widget-content ui-corner-all observacion-content' id='observacion-<?php echo $this->_tpl_vars['observacion']['codigo']; ?>
'>
					<h2 class='observacion-idx'> <?php echo ((is_array($_tmp=$this->_tpl_vars['tipo'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 No. <?php echo $this->_foreach['observaciones']['iteration']; ?>
</h2>
					<p class="observacion-text"><?php echo ((is_array($_tmp=$this->_tpl_vars['observacion']['observacion'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
					<div class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['observacion']['fecha_registro'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
					<div class='ui-toolbar'>
						<a id="prueba1" href='#<?php echo $this->_tpl_vars['observacion']['codigo']; ?>
' class='link-delete link-eliminarObservacion'><span class='ui-icon ui-icon-close link-icon inline-icon'></span>Eliminar</a>
					</div>
				</div>
			<?php endforeach; endif; unset($_from); ?>
			</div>
		</div>
	<?php endforeach; else: ?>
		<p>Este estudiante no tiene observaciones registradas</p>
	<?php endif; unset($_from); ?>
	</div>
	
	<div id='ui-toolbar'>
		<a href="#" id="link-toggleNuevaObservacion">Agregar Nueva Observacion</a>
	</div>

</div>
<?php endif; ?>