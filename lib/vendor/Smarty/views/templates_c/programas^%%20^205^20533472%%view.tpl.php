<?php /* Smarty version 2.6.26, created on 2011-07-14 09:43:03
         compiled from ./modules/programas/templates//view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'nombre_programa', './modules/programas/templates//view.tpl', 9, false),array('function', 'link_to', './modules/programas/templates//view.tpl', 17, false),array('modifier', 'date_format', './modules/programas/templates//view.tpl', 44, false),)), $this); ?>
<div class="ui-widget decorated">
	<?php if (empty ( $this->_tpl_vars['cod_programa'] )): ?>
		<h1><?php echo $this->_config[0]['vars']['PNAT']; ?>
 No Hallado!</h1>
		<?php if (is_professor_login ( )): ?>
			<p>Usted no tiene cursos asignados actualmente</p>
		<?php endif; ?>
	<?php else: ?>
		<h1>Informaci&oacute;n <?php echo $this->_config[0]['vars']['PNAT']; ?>
</h1>
		<h2><span id="sp-value-cod_programa"><?php echo $this->_tpl_vars['cod_programa']; ?>
</span> - <?php echo smarty_function_nombre_programa(array(), $this);?>
</h2>
    
    
  <?php if ($this->_tpl_vars['siat_user']->isRoot()): ?>
   <div class="menu sidebar sb-float sb-r">
			<h3 class="ui-state-default">MENU</h3>
      <div>
        <?php if (! $this->_tpl_vars['is_closed']): ?>
          <?php echo smarty_function_link_to(array('name' => 'Configuración','action' => 'configurar','cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>

          <?php echo smarty_function_link_to(array('name' => 'Cerrar','action' => 'close','cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>

        <?php endif; ?>
      </div>
   </div>
  <?php endif; ?>
  <?php if (! $this->_tpl_vars['siat_user']->isStudent()): ?>
		<div class="ui-toolbar">
			<?php echo smarty_function_link_to(array('name' => "Listado de PNAT's"), $this);?>
 <br/>
      <?php echo smarty_function_link_to(array('name' => 'Listado de Participantes','controller' => 'estudiantes','cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>
 |
      <?php echo smarty_function_link_to(array('name' => 'Listado de Cursos','controller' => 'cursos','cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>

		</div>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['is_closed']): ?>
    <div class="ui-state-highlight ui-corner-all frm-3 notif-block ">
      <span class="ui-icon ui-icon-circle-close inline-icon"></span> Este programa se encuentra <strong>cerrado</strong>.
    </div>
    <br/>
  <?php endif; ?>
		<div id='wrapper-semestres'>
			<?php unset($this->_sections['semestre']);
$this->_sections['semestre']['name'] = 'semestre';
$this->_sections['semestre']['start'] = (int)1;
$this->_sections['semestre']['loop'] = is_array($_loop=$this->_tpl_vars['cantidad_semestres']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['semestre']['show'] = true;
$this->_sections['semestre']['max'] = $this->_sections['semestre']['loop'];
$this->_sections['semestre']['step'] = 1;
if ($this->_sections['semestre']['start'] < 0)
    $this->_sections['semestre']['start'] = max($this->_sections['semestre']['step'] > 0 ? 0 : -1, $this->_sections['semestre']['loop'] + $this->_sections['semestre']['start']);
else
    $this->_sections['semestre']['start'] = min($this->_sections['semestre']['start'], $this->_sections['semestre']['step'] > 0 ? $this->_sections['semestre']['loop'] : $this->_sections['semestre']['loop']-1);
if ($this->_sections['semestre']['show']) {
    $this->_sections['semestre']['total'] = min(ceil(($this->_sections['semestre']['step'] > 0 ? $this->_sections['semestre']['loop'] - $this->_sections['semestre']['start'] : $this->_sections['semestre']['start']+1)/abs($this->_sections['semestre']['step'])), $this->_sections['semestre']['max']);
    if ($this->_sections['semestre']['total'] == 0)
        $this->_sections['semestre']['show'] = false;
} else
    $this->_sections['semestre']['total'] = 0;
if ($this->_sections['semestre']['show']):

            for ($this->_sections['semestre']['index'] = $this->_sections['semestre']['start'], $this->_sections['semestre']['iteration'] = 1;
                 $this->_sections['semestre']['iteration'] <= $this->_sections['semestre']['total'];
                 $this->_sections['semestre']['index'] += $this->_sections['semestre']['step'], $this->_sections['semestre']['iteration']++):
$this->_sections['semestre']['rownum'] = $this->_sections['semestre']['iteration'];
$this->_sections['semestre']['index_prev'] = $this->_sections['semestre']['index'] - $this->_sections['semestre']['step'];
$this->_sections['semestre']['index_next'] = $this->_sections['semestre']['index'] + $this->_sections['semestre']['step'];
$this->_sections['semestre']['first']      = ($this->_sections['semestre']['iteration'] == 1);
$this->_sections['semestre']['last']       = ($this->_sections['semestre']['iteration'] == $this->_sections['semestre']['total']);
?>
			<?php $this->assign('semestre', $this->_sections['semestre']['index']); ?>
			<div class="boxed" id="box-semestre-<?php echo $this->_tpl_vars['semestre']; ?>
">
				<div class="ui-subtitle-section">Semestre <?php echo $this->_tpl_vars['semestre']; ?>
</div>
				<div class='box-date-semestre' >
					<label>De:</label>
					<?php $this->assign('fecha_inicio', "fecha_inicio_".($this->_tpl_vars['semestre'])); ?>
					<strong class="date dark-highlighted-text"><?php echo ((is_array($_tmp=$this->_tpl_vars['programa'][$this->_tpl_vars['fecha_inicio']])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</strong>
					<label>Hasta:</label>
					<?php $this->assign('fecha_cierre', "fecha_cierre_".($this->_tpl_vars['semestre'])); ?>
					<strong class="date dark-highlighted-text"><?php echo ((is_array($_tmp=$this->_tpl_vars['programa'][$this->_tpl_vars['fecha_cierre']])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</strong>
				</div>
				
				<div class='placeholder-listado-componentes' id="placeholder-listado-componentes-<?php echo $this->_tpl_vars['semestre']; ?>
"></div>
				
			</div>
			<?php endfor; endif; ?>
			<div class="clear"> </div>
		</div>
    <?php if ($this->_tpl_vars['siat_config']->get('cursos_especiales.enabled')): ?>
    <div class="boxed" id="box-cursos_especiales">
      <h4 class="ui-subtitle-section">Cursos Especiales</h4><br/>
      <div class='placeholder-listado-componentes' id="placeholder-listado-componentes-cursos_especiales"></div>
      <div class="ui-toolbar">
        <?php if (! $this->_tpl_vars['is_closed']): ?>
        <?php echo smarty_function_link_to(array('name' => 'Configurar Cursos Especiales','controller' => 'cursos_especiales','action' => 'index','cod_programa' => $this->_tpl_vars['cod_programa']), $this);?>

        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
	<?php endif; ?>
</div>