<?php /* Smarty version 2.6.26, created on 2011-07-14 09:43:04
         compiled from modules/programas_componentes/templates/_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'modules/programas_componentes/templates/_list.tpl', 6, false),array('modifier', 'truncate', 'modules/programas_componentes/templates/_list.tpl', 7, false),)), $this); ?>
<ul class='list-componentes basic-list list-componentes-asignados'>
	<?php if (empty ( $this->_tpl_vars['componentes'] )): ?>
		<p>No hay aun componentes asignados<br/>a este semestre</p>
	<?php else: ?>
		<?php $_from = $this->_tpl_vars['componentes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['componente']):
?>
		<li title="<?php echo $this->_tpl_vars['componente']['codigo']; ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['componente']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="item-list componente-<?php echo $this->_tpl_vars['componente']['codigo']; ?>
">
		<span class="cod_componente-value hidden"><?php echo $this->_tpl_vars['componente']['codigo']; ?>
</span><span class="nombre_componente-value"> <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['componente']['nombre'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('truncate', true, $_tmp, '35') : smarty_modifier_truncate($_tmp, '35')); ?>
</span>
		<?php if (isset ( $this->_tpl_vars['componentesSinHorario'] )): ?>
			<?php if (in_array ( $this->_tpl_vars['componente']['codigo'] , $this->_tpl_vars['componentesSinHorario'] )): ?>
			<span class="ui-icon ui-icon-close inline-icon right-icon" title="Desasignar Componente"></span>
			<?php else: ?>
			<span class="ui-icon ui-icon-locked inline-icon right-icon" title="Componente Bloqueado"></span>
			<?php endif; ?>
		<?php endif; ?>
		</li>
		<?php endforeach; endif; unset($_from); ?>
	<?php endif; ?>
</ul>