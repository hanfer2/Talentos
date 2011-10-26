<?php /* Smarty version 2.6.26, created on 2011-07-14 09:43:06
         compiled from modules/programas_componentes/templates/edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'include_partial', 'modules/programas_componentes/templates/edit.tpl', 5, false),array('modifier', 'escape', 'modules/programas_componentes/templates/edit.tpl', 15, false),array('modifier', 'truncate', 'modules/programas_componentes/templates/edit.tpl', 17, false),)), $this); ?>
<div class="widget-programas-componentes-edit">
	<!-- LISTADO DE COMPONENTES YA ASIGNADOS -->
	<div class="wrapper-programas-componentes  wrapper-list-componentes-asignados">
		<h4 class="ui-state-default">Componentes Asignados</h4>
		<?php echo smarty_function_include_partial(array('file' => "_list.tpl",'componentes' => $this->_tpl_vars['componentesAsignados'],'componentesSinHorario' => $this->_tpl_vars['componentesSinHorario']), $this);?>

	</div>
	<!-- LISTADO DE COMPONENTES DISPONIBLES -->
	<div  class="wrapper-programas-componentes">
		<h4 class="ui-state-default">Componentes Disponibles</h4>
		<?php if (empty ( $this->_tpl_vars['componentesDisponibles'] )): ?>
			<p>No hay aun componentes asignados<br/>a este semestre</p>
		<?php else: ?>
			<div class='list-componentes list-componentes-disponibles'>
				<?php $_from = $this->_tpl_vars['componentesDisponibles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
				<div title="<?php echo ((is_array($_tmp=$this->_tpl_vars['componente']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="item-list ui-corner-all componente-<?php echo $this->_tpl_vars['componente']['codigo']; ?>
">
					<span class="cod_componente-value hidden"><?php echo $this->_tpl_vars['componente']['codigo']; ?>
</span>
					<span class="nombre_componente-value"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente']['nombre'])) ? $this->_run_mod_handler('truncate', true, $_tmp, '35') : smarty_modifier_truncate($_tmp, '35')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span>
					<span title="Agregar" class="ui-icon ui-icon-plus inline-icon right-icon clickable"></span>
				</div>
				<?php endforeach; endif; unset($_from); ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="clear"></div>
</div>